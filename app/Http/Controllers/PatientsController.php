<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patients;
use App\Models\Staff;
use App\Models\Regions;
use DB;
use Session;
use Exception;
use Auth;
use Validator;
use Storage;
use App\Helpers\StringHelper;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
Use Response;
use Illuminate\Support\Facades\File;
use App\Exports\PasienExport;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = 10;
        $start_date = null;
        $end_date = null;
        $kelamin = null;
        $fpatient_id = null;

        $patients = Patients::orderBy("name", "asc");
        if(isset($request->shareselect) and $request->shareselect != null){
            $page = $request->shareselect;
        }

        if(isset($request->fpatient_id) and $request->fpatient_id != null){
            $fpatient_id = $request->fpatient_id;
            $patients->where("patient_id", $fpatient_id);
        }
        
        if(isset($request->start_date) and $request->start_date!= null){
            $start_date = $request->start_date;
            $patients->where("first_entry", ">=", $start_date);
        }

        if(isset($request->end_date) and $request->end_date!= null){
            $end_date = $request->end_date;
            $patients->where("first_entry", "<=", $end_date);
        }

        if(isset($request->kelamin) and $request->kelamin!= null){
            $kelamin = $request->kelamin;
            $patients->where("gender", $kelamin);
        }

        $data["pasien"] = Patients::select("patient_id", "name")->where("status", "active")->orderBy("name", "asc")->get();
        $data["data"] = $patients->paginate($page);
        $data["filter"] = array("page" => $page, 
            "end_date" => $end_date,
            "start_date"=>$start_date,
            "kelamin"=>$kelamin,
            "fpatient_id" => $fpatient_id);
        
        return view("patients", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data["data"] = [];
        $data["wilayah"] = Regions::getWilayah();
        
        return view("form.patients", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'record'  => 'bail|required|alpha_num|min:3|max:50|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.patients,medical_record_number',
            'name'  => 'bail|required|gelar|min:4|max:100',
            'kelamin'  => 'bail|required|in:male,female',
            'patient_status_id' => 'bail|required|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.patient_status,patient_status_id',
            'birthplace'  => 'bail|nullable|alphanum_spaces|max:255',
            'birthdate'  => 'bail|nullable|date',
            'first_entry'  => 'bail|required|date',
            'email'  => 'bail|nullable|email|min:5|max:100|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.patients,email',
            'phone'  => 'bail|required|digits_between:6,13|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.patients,phone',
            'address'  => 'bail|required|max:100|min:5',
            'status'  => 'bail|nullable|in:active,inactive',
            'doctor_id'  => 'bail|nullable|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.doctors,doctor_id',
            'dpjp_doctor_id'  => 'bail|nullable|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.doctors,doctor_id',
            'gambar'  => 'bail|nullable|image|mimes:JPG,JPEG,PNG,GIF,SVG,jpg,png,jpeg,gif,svg|max:2048',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());
        }

        $id = null;
        try {
            
            DB::beginTransaction();
            $patients                   = new Patients();
            $patients->medical_record_number             = $request->record;
            $patients->name             = $request->name;
            $patients->gender             = $request->kelamin;
            $patients->phone             = $request->phone;
            $patients->email             = $request->email;
            $patients->birthplace             = $request->birthplace;
            $patients->birthdate             = $request->birthdate;
            $patients->first_entry             = $request->first_entry;
            $patients->address             = $request->address;
            $patients->status             = $request->status;
            $patients->created_ip       = $request->ip();
            $patients->patient_status_id = $request->patient_status_id;

            if(isset($request->doctor_id) and $request->doctor_id != null){
                $patients->referral_doctor_id = $request->doctor_id;
            }

            if(isset($request->dpjp_doctor_id) and $request->dpjp_doctor_id != null){
                $patients->dpjp_doctor_id = $request->dpjp_doctor_id;
            }

            if(isset($request->status) and $request->status == null){
                $patients->status = "inactive";
            }            
            
            if(isset(Auth::user()->user_id)){
                $patients->created_by       = Auth::user()->user_id;
            }
            
            if(isset($request->gambar) and $request->file('gambar')!=null){
                $img = $request->file('gambar');
                
                $path_img = $img->store('patients');
                $image = explode("/", $path_img);
                $patients->picture = $image[1];
            }

            $patients->save();
            $id = $patients->patient_id;

            if(isset($request->doctor_id) and $request->doctor_id != null){
                $nominal = 0;
                $setting = SettingReferral::get()->first();
                if(isset($setting->pasien_baru) and $setting->pasien_baru != null){
                    $nominal = $setting->pasien_baru;
                }
                
                $ref = new HistoryReferral();
                $ref->id_history = HistoryReferral::generateId();
                $ref->doctor_id = $request->doctor_id;
                $ref->nominal = $nominal;
                $ref->date_referral = date("Y-m-d");
                $ref->type= "pasien";
                $ref->created_ip       = $patients->created_ip;
                $ref->created_by       = $patients->created_by;
                if($ref->nominal > 0){
                    $ref->save();
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data pasien Gagal Disimpan' )->withInput($request->input());
        }
        
        return redirect("patient/".$patients->patient_id."/package")->with('success', 'Data pasien Disimpan');
    }
    
    public function package($id)
    {
        $patients = Patients::findOrFail($id);
        if($patients->picture != null and Storage::exists('patients/'.$patients->picture)){
            $path = 'patients/'.$patients->picture;

            $full_path = Storage::path($path);
            $base64 = base64_encode(Storage::get($path));
            $image = 'data:'.mime_content_type($full_path) . ';base64,' . $base64;
            $patients->picture = $image;
        }else{
            $path = asset("images/no-image.png");
            $patients->picture = $path;
        }
        
        $patients->usia = StringHelper::datedifferent(date("Y-m-d"), $patients->birthdate);
        $data["data"] = [];
        $data["pasien"] = $patients;
        $data["paket"] = Package::orderBy("name", "asc")->get();
        $data["terapis"] = Staff::getTerapis();
        $data["times"] = Schedule::select("start_clock", "end_clock", "schedule_shift_id")->get();
        $data["diagnosa"] = Diagnoses::select("diagnose_id", "name")->get();

        return view("detail.patients-package", $data);
    }
    
    public function schedule($id)
    {
        $package = PatientsPackage::findOrFail($id);
        $patients = Patients::findOrFail($package->patient_id);
        $patients->usia = StringHelper::datedifferent(date("Y-m-d"), $patients->birthdate);
        $detail = PatientsPackageMeet::getdetail($id);
        $data["data"] = $package;
        $data["detail"] = $detail;
        $data["pasien"] = $patients;
        
        return view("detail.schedule", $data);
    }

    public function savepackage(Request $request, $id)
    {
        $date = date("Y-m-d");
        $yesterday = date('Y-m-d',(strtotime('-1 day', strtotime($date))));

        $validator = Validator::make($request->all(), [
            'diagnose_id'  => 'bail|required|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.diagnoses,diagnose_id',
            'package_id'  => 'bail|required|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.packages,package_id',
            'times'  => 'bail|required|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.schedule_shifts,schedule_shift_id',
            'staff_id'  => 'bail|required|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.staffs,staff_id',
            'registration_date' => 'bail|required|date_format:Y-m-d',
            'note'=> 'bail|nullable|max:255'
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());
        }
        
        $package_id = null;
        try {
            DB::beginTransaction();
            $patients = Patients::findOrFail($id);
            // get total and ready meet in patient packages
            $ready = Package::getReady($request->package_id, $id);
            $sisa = $ready["total"] - $ready["ready"];
            
            if($sisa != 0){
                return redirect("appointment/".$package_id)->with('success', 'Paket Treatment Pasien telah dibuat, silahkan atur jadwal treatment');
            }
            
            // save patients package
            $package                   = new PatientsPackage();
            $package->patient_id             = $id;
            $package->diagnose_id             = $request->diagnose_id;
            $package->package_id             = $request->package_id;
            $package->total_meet             = $ready["total"];
            $package->remaining_meet             = $ready["ready"];
            $package->note             = $request->note;
            $package->registration_date             = $request->registration_date;
            $package->registration_code             = PatientsPackage::RegisterationCode();
            $package->created_ip       = $request->ip();
            if(isset(Auth::user()->user_id)){
                $package->created_by       = Auth::user()->user_id;
            }

            $package->save();
            $package_id = $package->patient_package_id;

            $schedule = ScheduleTerapi::where("staff_id", $request->staff_id)
            ->where("schedule_shift_id", $request->times)
            ->get()->first();

            // this for patient package meets
            $meet = [];
            for($i = 0; $i< $ready["ready"]; $i++){
                $meet[$i]["patient_package_id"] = $package_id;
                $meet[$i]["physiotherapist_schedule_id"] = $request->staff_id;
                $kali = 7*$i;  
                $date = strtotime($request->registration_date);
                $date = strtotime("+".$kali." day", $date);
                $date = date("Y-m-d", $date);
                $meet[$i]["date_scheduled"] = $date;
                $meet[$i]["physiotherapist_schedule_id"] = $schedule->physiotherapis_schedule_id;
                $meet[$i]["created_ip"]       = $request->ip();
                if(isset(Auth::user()->user_id)){
                    $meet[$i]["created_by"]       = Auth::user()->user_id;
                }
                $meet[$i]["created_at"] = date("Y-m-d H:i:s");
                $meet[$i]["updated_at"] = date("Y-m-d H:i:s");
                $meet[$i]["staff_id"] = $request->staff_id;
                $meet[$i]["package_id"] = $request->package_id;
                $meet[$i]["meeting_index"] = $i+1;
                $meet[$i]["is_assesment"] = 0;
                $meet[$i]["is_claimed"] = 0;
            }
            
            PatientsPackageMeet::insert($meet);
            
            // set notifikasi
            $ide = PatientsPackageMeet::where("patient_package_id", $package_id)
                    ->orderBy("meeting_index", "asc")->get()->first();
                    
            PatientsPackageMeet::notifFisio($ide->patient_package_meet_id);
            PatientsPackageMeet::notifPasien($ide->patient_package_meet_id);;

            // this for referral
            if(isset($patients->referral_doctor_id) and $patients->referral_doctor_id != null){
                $nominal = 0;
                $setting = SettingReferral::get()->first();
                if(isset($setting->treatment_baru) and $setting->treatment_baru != null){
                    $nominal = $setting->treatment_baru;
                }

                $ref = new HistoryReferral();
                $ref->id_history = HistoryReferral::generateId();
                $ref->doctor_id = $patients->referral_doctor_id;
                $ref->nominal = $nominal;
                $ref->date_referral = date("Y-m-d");
                $ref->type= "paket";
                $ref->created_ip       = $package->created_ip;
                $ref->created_by       = $package->created_by;
                $ref->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Paket Treatment Pasien gagal disimpan' )->withInput($request->input());
        }
        
        return redirect("appointment/".$package_id)->with('success', 'Paket Treatment Pasien dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patients = Patients::findOrFail($id);
        if($patients->picture != null and Storage::exists('patients/'.$patients->picture)){
            $path = 'patients/'.$patients->picture;

            $full_path = Storage::path($path);
            $base64 = base64_encode(Storage::get($path));
            $image = 'data:'.mime_content_type($full_path) . ';base64,' . $base64;
            $patients->picture = $image;
        }else{
            $path = asset("images/no-image.png");
            $patients->picture = $path;
        }

        $data["jenis"] = PatientStatus::select("name", "patient_status_id")->orderBy("name", "asc")->get();
        $data["doctor"] = Doctors::getActive("referral");
        $data["dpjp"] = Doctors::getActive("dpjp");
        $data["data"] = $patients;
        return view("form.patients", $data);
    }
    
    public function getpatient($id)
    {
        $patients = Patients::findOrFail($id);
        if($patients->picture != null and Storage::exists('patients/'.$patients->picture)){
            $path = 'patients/'.$patients->picture;

            $full_path = Storage::path($path);
            $base64 = base64_encode(Storage::get($path));
            $image = 'data:'.mime_content_type($full_path) . ';base64,' . $base64;
            $patients->picture = $image;
        }else{
            $path = asset("images/no-image.png");
            $patients->picture = $path;
        }
        
        return Response()->json($patients);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $patients = Patients::findOrFail($id);

        if($patients->picture != null and Storage::exists('patients/'.$patients->picture)){
            $path = 'patients/'.$patients->picture;

            $full_path = Storage::path($path);
            $base64 = base64_encode(Storage::get($path));
            $image = 'data:'.mime_content_type($full_path) . ';base64,' . $base64;
            $patients->picture = $image;
        }else{
            $path = asset("images/no-image.png");
            $patients->picture = $path;
        }
        $data["jenis"] = PatientStatus::select("name", "patient_status_id")->orderBy("name", "asc")->get();
        $data["doctor"] = Doctors::getActive("referral");
        $data["dpjp"] = Doctors::getActive("dpjp");
        $data["data"] = $patients;
        return view("form.patients", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $validator = Validator::make($request->all(), [
        'record'  => 'bail|required|alpha_num|min:3|max:50|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.patients,medical_record_number,'.$id.',patient_id',
        'name'  => 'bail|required|gelar|min:4|max:100',
        'kelamin'  => 'bail|required|in:male,female',
        'patient_status_id' => 'bail|required|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.patient_status,patient_status_id',
        'birthplace'  => 'bail|nullable|alphanum_spaces|max:255',
        'birthdate'  => 'bail|nullable|date',
        'first_entry'  => 'bail|required|date',
        'email'  => 'bail|nullable|email|min:5|max:100|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.patients,email,'.$id.',patient_id',
        'phone'  => 'bail|required|digits_between:6,13|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.patients,phone,'.$id.',patient_id',
        'address'  => 'bail|required|max:100|min:5',
        'status'  => 'bail|nullable|in:active,inactive',
        'doctor_id'  => 'bail|nullable|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.doctors,doctor_id',
        'dpjp_doctor_id'  => 'bail|nullable|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.doctors,doctor_id',
        'gambar'  => 'bail|nullable|image|mimes:JPG,JPEG,PNG,GIF,SVG,jpg,png,jpeg,gif,svg|max:2048',
    ]);

       if ($validator->fails())
       {
        return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());
    }

    try {

        DB::beginTransaction();
        $patients                   = Patients::findOrFail($id);
        $patients->medical_record_number             = $request->record;
        $patients->name             = $request->name;
        $patients->gender             = $request->kelamin;
        $patients->phone             = $request->phone;
        $patients->email             = $request->email;
        $patients->birthplace             = $request->birthplace;
        $patients->birthdate             = $request->birthdate;
        $patients->first_entry             = $request->first_entry;
        $patients->address             = $request->address;
        $patients->status             = $request->status;
        $patients->updated_ip       = $request->ip();
        $patients->patient_status_id = $request->patient_status_id;

        if(isset($request->doctor_id) and $request->doctor_id != null){
            $patients->referral_doctor_id = $request->doctor_id;
        }

        if(isset($request->dpjp_doctor_id) and $request->dpjp_doctor_id != null){
                $patients->dpjp_doctor_id = $request->dpjp_doctor_id;
            }

        if(isset($request->status) and $request->status == null){
            $patients->status = "inactive";
        }            

        if(isset(Auth::user()->user_id)){
            $patients->updated_by       = Auth::user()->user_id;
        }

        if(isset($request->gambar) and $request->file('gambar')!=null){
            if(Storage::exists('patients/'.$patients->picture)){
                Storage::delete('patients/'.$patients->picture);
            }

            $img = $request->file('gambar');

            $path_img = $img->store('patients');
            $image = explode("/", $path_img);
            $patients->picture = $image[1];
        }

        $patients->save();
        
        DB::commit();
    } catch (Exception $e) {
        DB::rollback();
        return redirect()->back()->with('error', 'Data pasien Gagal Disimpan' )->withInput($request->input());
    }

    return redirect("patient")->with('success', 'Data pasien Disimpan');
}

public function changestatus(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'status'  => 'bail|required|in:active,inactive'
    ]);

    if ($validator->fails())
    {
        return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());
    }

    try {

        DB::beginTransaction();
        $pasien                   = Patients::findOrFail($id);
        $pasien->status             = $request->status;
        $pasien->save();

        DB::commit();
    } catch (Exception $e) {
        DB::rollback();
        return redirect()->back()->with('error', 'Data Status gagal diubah' )->withInput($request->input());
    }

    return redirect()->back()->with('success', 'Data Status berhasil diubah');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = null;
        try {

            DB::beginTransaction();
            $pn                   = Patients::findOrFail($id);
            $image = $pn->picture;
            $pn->delete();
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data pasien Gagal dihapus, karena masih terpakai table lain');
        }
        
        if(Storage::exists('patients/'.$image)){
            Storage::delete('patients/'.$image);
        }

        return redirect()->back()->with('success', 'Data pasien dihapus');
    }

    public function reportpatient(Request $request)
    {
        $format = null;
        $start_date = date("Y-m-"."01");
        $end_date = date('Y-m-d', strtotime($start_date. ' +30 days'));
        $doctor_id = null;
        $patient_status_id = null;
        $kelamin = null;

        $patients = Patients::orderBy("name", "asc");
        if(isset($request->format) and $request->format != null){
            $format = $request->format;
        }
        
        if(isset($request->start_date) and $request->start_date!= null){
            $start_date = $request->start_date;
            $patients->where("first_entry", ">=", $start_date);
        }

        if(isset($request->end_date) and $request->end_date!= null){
            $end_date = $request->end_date;
            $patients->where("first_entry", "<=", $end_date);
        }

        if(isset($request->doctor_id) and $request->doctor_id!= null){
            $doctor_id = $request->doctor_id;
            $patients->where("referral_doctor_id", $doctor_id);
        }

        if(isset($request->patient_status_id) and $request->patient_status_id!= null){
            $patient_status_id = $request->patient_status_id;
            $patients->where("patient_status_id", $patient_status_id);
        }

        if(isset($request->kelamin) and $request->kelamin!= null){
            $kelamin = $request->kelamin;
            $patients->where("gender", $kelamin);
        }

        $diff = StringHelper::daydifferent($start_date, $end_date);
        if($diff > 31){
            return redirect()->back()->with('error', 'Tanggal Awal dan Akhir tidak boleh lebih 31 hari ');
        }

        $data["jenis"] = PatientStatus::select("name", "patient_status_id")->orderBy("name", "asc")->get();
        $data["doctor"] = Doctors::getActive("referral");
        $data["data"] = $patients->get();
        $data["filter"] = array("format" => $format, 
            "end_date" => $end_date,
            "start_date"=>$start_date,
            "kelamin"=>$kelamin,
            "patient_status_id"=>$patient_status_id,
            "doctor_id" => $doctor_id);
        
        return view("report.patients", $data);
    }

    public function cetakpatient(Request $request)
    {
        $format = null;
        $start_date = date("Y-m-"."01");
        $end_date = date('Y-m-d', strtotime($start_date. ' +30 days'));
        $doctor_id = null;
        $patient_status_id = null;
        $kelamin = null;

        $patients = Patients::orderBy("name", "asc");
        if(isset($request->format) and $request->format != null){
            $format = $request->format;
        }
        
        if(isset($request->start_date) and $request->start_date!= null){
            $start_date = $request->start_date;
            $patients->where("first_entry", ">=", $start_date);
        }

        if(isset($request->end_date) and $request->end_date!= null){
            $end_date = $request->end_date;
            $patients->where("first_entry", "<=", $end_date);
        }

        if(isset($request->doctor_id) and $request->doctor_id!= null){
            $doctor_id = $request->doctor_id;
            $patients->where("referral_doctor_id", $doctor_id);
        }

        if(isset($request->patient_status_id) and $request->patient_status_id!= null){
            $patient_status_id = $request->patient_status_id;
            $patients->where("patient_status_id", $patient_status_id);
        }

        if(isset($request->kelamin) and $request->kelamin!= null){
            $kelamin = $request->kelamin;
            $patients->where("gender", $kelamin);
        }

        $diff = StringHelper::daydifferent($start_date, $end_date);
        if($diff > 31){
            return redirect()->back()->with('error', 'Tanggal Awal dan Akhir tidak boleh lebih 31 hari ');
        }
        
        $data["data"] = $patients->get();
        $data["filter"] = array("format" => $format, 
            "end_date" => $end_date,
            "start_date"=>$start_date,
            "kelamin"=>$kelamin,
            "patient_status_id"=>$patient_status_id,
            "doctor_id" => $doctor_id);
        
        if($format == "pdf"){
            $name = "Laporan".request()->segment(1).date("Y/m/d");
            $pdf = PDF::loadview("print.patients", $data)
            ->setOptions(['defaultFont' => 'sans-serif'])->setPaper('folio', 'landscape');
            return $pdf->stream();
        }

        return view("print.patients", $data);
    }


    public function import(Request $request)
    {
        // $this->validate($request, [
        //     'files' => 'required|mimes:csv,xls,xlsx'
        // ]);
        
        try {

            DB::beginTransaction();
            // menangkap file excel
            $file = $request->file('files');

        // membuat nama file unik
            $nama_file = rand().$file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
            $file->move('DoctorImport',$nama_file);

        // import data
            Excel::import(new PatientsImport, public_path('/DoctorImport/'.$nama_file));

            DB::commit();
            
            File::delete(public_path('/DoctorImport/'.$nama_file));

        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data Pasien Gagal di import'.$e->getMessage());
        }

        return redirect()->back()->with('success', 'Data Pasien berhasil di import');
    }

    public function download()
    {
        $data["referral"] = Doctors::select("doctor_id", "name")->where("type", "referral")->get();
        $data["data"] = [];

        return view("print.template-patient", $data); 
    }
    
    public function download2()
    {
        $doctor = Doctors::getActive("referral");
        $status = array("active"=>"active", "inactive"=>"inactive");
        $status_pasien = PatientStatus::where("patient_status_id", "name")->get();
        $jk = array("male" => "Laki-Laki", "female"=> "Perempuan");
        
        $users = [
            [
                'medical_record_number' => 1,
                'name' => 'Hardik',
                'referral_doctor_id' => 1,
                'birthplace' => 'Jakarta',
                'birthdate' => '28-10-1996',
                'gender' => "male",
                'email' => 'pasien@orphys.id',
                'phone' => '620803301602',
                'patient_status_id' => $status_pasien,
                'first_entry' => '28-10-2021',
                'address' => 'Jl. Raya Pd. Rosan No. 50 Jakarta',
                'status' => $status,
            ]
        ];

        return Excel::download(new PasienExport($users), 'template-pasien.xlsx');
    }
}
