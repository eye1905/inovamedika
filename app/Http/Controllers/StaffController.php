<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Companies;
use App\Models\MedicalTreatment;
use DB;
use Session;
use Exception;
use Auth;
use Validator;
use Storage;
use App\Models\User;
use App\Models\Role;
use App\Helpers\StringHelper;
use Hash;
use App\Imports\StaffImport;
use Maatwebsite\Excel\Facades\Excel;
Use Response;
use Illuminate\Support\Facades\File;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = 10;
        $start_date = date("Y");
        $fstaff_id = null;
        $f_status = null;
        
        $staff = Staff::with("user")->orderBy("name", "asc");

        if(isset($request->start_date) and $request->start_date!= null){
            $start_date = $request->start_date;
            $staff->where("entry_year", ">=", $start_date);
        }
        
        if(isset($request->fstaff_id) and $request->fstaff_id!= null){
            $fstaff_id = $request->fstaff_id;
            $staff->where("staff_id", $fstaff_id);
        }

        if(isset($request->f_status) and $request->f_status!= null){
            $f_status = $request->f_status;
            $staff->where("staff_status", $f_status);
        }

        $data["staff"] = Staff::select("staff_id", "name")
            ->orderBy("name", "asc")->get();
        $data["data"] = $staff->paginate($page);
        $data["filter"] = array("page" => $page, 
            "fstaff_id" => $fstaff_id,
            "start_date"=>$start_date,
            "f_status" => $f_status);

        return view("staff", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data["data"] = [];
        $data["role"] = Role::select("role_id", "name")->where("code", ">", "1")->get();

        return view("form.staff", $data);
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
            'gambar'  => 'bail|nullable|image|mimes:JPG,JPEG,PNG,GIF,SVG,jpg,png,jpeg,gif,svg|max:2048',
            'identity_id'  => 'bail|nullable|alpha_num|min:3|max:50|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.staffs,identity_id',
            'name'  => 'bail|required|gelar|min:4|max:100|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.staffs,name',
            'kelamin'  => 'bail|required|in:male,female',
            'birthplace'  => 'bail|nullable|alpha_spaces|max:100|min:4',
            'birthdate'  => 'bail|nullable|date',
            'entry_year'  => 'bail|required|digits_between:4,4',
            'email'  => 'bail|email|nullable|min:5|max:100|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.staffs,email',
            'phone'  => 'bail|required|digits_between:6,13|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.staffs,phone',
            'address'  => 'bail|required|max:100|min:5',
            'status'  => 'bail|nullable|in:active,inactive,leave',
            'role_id'  => 'bail|required|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.roles,role_id',
            'username'  => 'bail|required|alpha_num|max:20|min:5|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.users,username',
            'password'  => 'bail|required|alpha_num|max:20|min:5',
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());
        }

        try {

            DB::beginTransaction();
            $staff                   = new Staff();
            $staff->identity_id             = $request->identity_id;
            $staff->name             = $request->name;
            $staff->gender             = $request->kelamin;
            $staff->phone             = $request->phone;
            $staff->email             = $request->email;
            $staff->birthplace             = $request->birthplace;
            $staff->birthdate             = $request->birthdate;
            $staff->entry_year             = $request->entry_year;
            $staff->address             = $request->address;
            $staff->staff_status             = $request->status?$request->status:"inactive";
            $staff->created_ip       = $request->ip();
            $staff->created_by       = Auth::user()->user_id;

            if(isset(Auth::user()->user_id)){
                $staff->created_by       = Auth::user()->user_id;
            }

            if(isset($request->gambar) and $request->file('gambar')!=null){
                $img = $request->file('gambar');
                
                $path_img = $img->store('staffs');
                $image = explode("/", $path_img);
                $staff->identity_picture = $image[1];
            }

            $staff->save();

            $user =  new User();
            $user->staff_id = $staff->staff_id;
            $user->name             = $staff->name;
            $user->email             = $staff->email;
            $user->phone             = $staff->phone;
            $user->username             = $request->username;
            $user->password             = Hash::make($request->password);
            $user->role_id             = $request->role_id;
            $user->created_ip       = $request->ip();
            $user->status = $request->status?$request->status:"inactive";
            if(isset($request->gambar) and $request->file('gambar')!=null){
                $img = $request->file('gambar');
                
                $path_img = $img->store('profile');
                $image = explode("/", $path_img);
                $user->profile_picture = $image[1];
            }

            $user->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data staff Gagal Disimpan'.$e->getMessage())->withInput($request->input());
        }
        
        return redirect("staff")->with('success', 'Data staff Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $staff = Staff::findOrFail($id);
        if(Storage::exists('staffs/'.$staff->identity_picture)){
            $path = 'staffs/'.$staff->identity_picture;

            $full_path = Storage::path($path);
            $base64 = base64_encode(Storage::get($path));
            $image = 'data:'.mime_content_type($full_path) . ';base64,' . $base64;
            $staff->identity_picture = $image;
        }
        $data["data"] = $staff;
        $data["role"] = Role::select("role_id", "name")->where("code", ">", "0")->get();
        
        return view("form.staff", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staff = Staff::findOrFail($id);
        if(Storage::exists('staffs/'.$staff->identity_picture)){
            $path = 'staffs/'.$staff->identity_picture;

            $full_path = Storage::path($path);
            $base64 = base64_encode(Storage::get($path));
            $image = 'data:'.mime_content_type($full_path) . ';base64,' . $base64;
            $staff->identity_picture = $image;
        }

        $data["data"] = $staff;
        return view("form.staff", $data);
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
            'gambar'  => 'bail|nullable|image|mimes:JPG,JPEG,PNG,GIF,SVG,jpg,png,jpeg,gif,svg|max:2048',
            'identity_id'  => 'bail|nullable|alpha_num|min:3|max:50|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.staffs,identity_id,'.$id.',staff_id',
            'name'  => 'bail|required|gelar|min:4|max:100|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.staffs,name,'.$id.',staff_id',
            'kelamin'  => 'bail|required|in:male,female',
            'birthplace'  => 'bail|nullable|alpha_spaces|max:100|min:4',
            'birthdate'  => 'bail|nullable|date',
            'entry_year'  => 'bail|required|digits_between:4,4',
            'email'  => 'bail|email|nullable|min:5|max:100|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.staffs,email,'.$id.',staff_id',
            'phone'  => 'bail|required|digits_between:6,13|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.staffs,phone,'.$id.',staff_id',
            'address'  => 'bail|required|max:100|min:5',
            'status'  => 'bail|nullable|in:active,inactive,leave',
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());
        }
        
        try {

            DB::beginTransaction();
            $staff                   = Staff::findOrFail($id);
            $staff->identity_id             = $request->identity_id;
            $staff->name             = $request->name;
            $staff->gender             = $request->kelamin;
            $staff->phone             = $request->phone;
            $staff->email             = $request->email;
            $staff->birthplace             = $request->birthplace;
            $staff->birthdate             = $request->birthdate;
            $staff->entry_year             = $request->entry_year;
            $staff->address             = $request->address;
            $staff->staff_status             = $request->status;
            $staff->updated_ip       = $request->ip();
            $staff->updated_by       = Auth::user()->user_id;
            $staff->staff_status             = $request->status?$request->status:"inactive";

            if(isset($request->gambar) and $request->file('gambar')!=null){

                if(Storage::exists('staffs/'.$staff->identity_picture)){
                    Storage::delete('staffs/'.$staff->identity_picture);
                }

                $img = $request->file('gambar');
                
                $path_img = $img->store('staffs');
                $image = explode("/", $path_img);
                $staff->identity_picture = $image[1];
            }

            $staff->save();
            
            $user = User::where("staff_id", $staff->staff_id)->get()->first();
            if($user!=null){
                $user->email = $staff->email;
                $user->name = $staff->name;
                $user->phone = $staff->phone;
                $user->status = $staff->staff_status; 
                $user->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data staff Gagal Disimpan' )->withInput($request->input());
        }
        
        return redirect("staff")->with('success', 'Data staff Disimpan');
    }

    public function changestatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'staff_status'  => 'bail|required|in:active,inactive,leave'
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());
        }

        try {

            DB::beginTransaction();
            $staff                   = Staff::findOrFail($id);
            $staff->staff_status             = $request->staff_status;

            $cek = User::where("staff_id", $id)->get()->first();
            if(isset($cek->user_id) and ($staff->staff_status=="active" or $staff->staff_status=="inactive")){
                $cek->status = $staff->staff_status;
                $cek->save();
            }

            $staff->save();
            $data["status"] = $staff->staff_status;
            $user = User::where("staff_id", $id)->update($data);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data Status gagal diubah' )->withInput($request->input());
        }

        return redirect()->back()->with('success', 'Data Status berhasil diubah');
    }

    public function adduser(Request $request, $id)
    {
        $cek = User::where("staff_id", $id)->get()->first();
        
        if($cek != null){
            return redirect()->back()->with('error', 'Staff Sudah terdaftar sebagai user');
        }

        if($request->method()=="POST"){
            $validator = Validator::make($request->all(), [
                'staff_id'  => 'bail|required|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.staffs,staff_id',
                'role_id'  => 'bail|required|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.roles,role_id',
                'username'  => 'bail|required|alpha_num|max:20|min:5|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.users,username',
                'password'  => 'bail|required|alpha_num|max:20|min:5',
                'gambar'  => 'bail|nullable|image|mimes:jpg,png,jpeg,gif,svg|max:1024',
                'status' => 'bail|required|in:active,inactive'
            ]);

            if ($validator->fails())
            {
                return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());;
            }


            try {
                DB::beginTransaction();

                $user                   = new User();
                $staff                  = Staff::findOrFail($request->staff_id);
                $user->name             = $staff->name;
                $user->email            = $staff->email;
                $user->phone            = $staff->phone;
                $user->staff_id            = $staff->staff_id;
                $user->user_uuid        = StringHelper::generate_uuid();
                $user->username             = $request->username;
                $user->password             = Hash::make($request->password);
                $user->created_ip       = $request->ip();
                $user->status = $request->status;

                if($user->status == "active"){
                    $user->account_verified_at = date("Y-m-d h:i:s");
                }

                if(isset(Auth::user()->user_id)){
                    $user->created_by       = Auth::user()->user_id;
                }

                if(isset($request->gambar) and $request->file('gambar')!=null){
                    $img = $request->file('gambar');

                    $path_img = $img->store('profile');
                    $image = explode("/", $path_img);
                    $user->profile_picture = $image[1];
                }

                $user->save();

                // for role id
                $role =  new RoleUser();
                $role->user_id = $user->user_id;
                $role->role_id = $request->role_id;
                $role->created_ip       = $request->ip();
                
                if(isset(Auth::user()->user_id)){
                    $role->created_by       = Auth::user()->user_id;
                }

                $role->save();

                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()->with('error', 'Data user gagal Disimpan' )->withInput($request->input());
            }
            
            return redirect("staff")->with('success', 'Data gagal Disimpan');
        }

        $data["staff"] = Staff::findOrFail($id);
        $data["status"] = User::getStatus();
        $data["role"] = Role::select("role_id", "name")->where("code", ">", "0")->get();

        return view("form.staff-adduser", $data);
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
            $staff                   = Staff::findOrFail($id);
            $image = $staff->identity_picture;
            $staff->delete();
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data staff Gagal dihapus, karena masih terpakai table lain' );
        }
        
        if(Storage::exists('staffs/'.$image)){
            Storage::delete('staffs/'.$image);
        }

        return redirect()->back()->with('success', 'Data staff dihapus');
    }

    public function reportfisioterapis(Request $request)
    {
        $format = null;
        $start_date = date("Y");
        $is_terapis = null;
        $fstaff_id = null;
        
        $staff = Staff::with("user")->where("is_terapis", 1)->orderBy("name", "asc");

        if(isset($request->format) and $request->format!= null){
            $format = $request->format;
        }

        if(isset($request->start_date) and $request->start_date!= null){
            $start_date = $request->start_date;
            $staff->where("entry_year", ">=", $start_date);
        }
        
        if(isset($request->fstaff_id) and $request->fstaff_id!= null){
            $fstaff_id = $request->fstaff_id;
            $staff->where("staff_id", $fstaff_id);
        }   
        
        if(isset($request->is_terapis) and $request->is_terapis!= null){
            $is_terapis = $request->is_terapis;
            $staff->where("is_terapis", $is_terapis);
        }

        $data["staff"] = Staff::select("staff_id", "name")
            ->orderBy("name", "asc")->where("staff_status","active")
            ->where("is_terapis", 1)->get();
        $data["stats"] = MedicalTreatment::getStats();
        $data["data"] = $staff->get();
        $data["filter"] = array("format" => $format, 
            "fstaff_id" => $fstaff_id,
            "start_date"=>$start_date,
            "is_terapis" => $is_terapis);

        return view("report.fisioterapis", $data);
    }

    public function cetakfisioterapis(Request $request)
    {
        $format = null;
        $start_date = date("Y");
        $is_terapis = null;
        $fstaff_id = null;

        $staff = Staff::with("user")->where("is_terapis", 1)->orderBy("name", "asc");

        if(isset($request->format) and $request->format!= null){
            $format = $request->format;
        }

        if(isset($request->start_date) and $request->start_date!= null){
            $start_date = $request->start_date;
            $staff->where("entry_year", ">=", $start_date);
        }
        
        if(isset($request->fstaff_id) and $request->fstaff_id!= null){
            $fstaff_id = $request->fstaff_id;
            $staff->where("staff_id", $fstaff_id);
        }   

        if(isset($request->is_terapis) and $request->is_terapis!= null){
            $is_terapis = $request->is_terapis;
            $staff->where("is_terapis", $is_terapis);
        }

        $data["stats"] = MedicalTreatment::getStats();
        $data["data"] = $staff->get();
        $data["filter"] = array("format" => $format, 
            "fstaff_id" => $fstaff_id,
            "start_date"=>$start_date,
            "is_terapis" => $is_terapis);

        if($format == "pdf"){
            $name = "Laporan".request()->segment(1).date("Y/m/d");
            $pdf = \PDF::loadview("print.fisioterapis", $data)->setOptions(['defaultFont' => 'sans-serif'])->setPaper('folio', 'landscape');
            return $pdf->stream();
        }
        return view("print.fisioterapis", $data);
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'files' => 'required|mimes:csv,xls,xlsx'
        ]);
        
        try {

            DB::beginTransaction();
            // menangkap file excel
            $file = $request->file('files');

        // membuat nama file unik
            $nama_file = rand().$file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
            $file->move('DoctorImport',$nama_file);

        // import data
            Excel::import(new StaffImport, public_path('/DoctorImport/'.$nama_file));

            DB::commit();
            
            File::delete(public_path('/DoctorImport/'.$nama_file));

        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data Pegawai Gagal di import'.$e->getMessage());
        }

        return redirect()->back()->with('success', 'Data Pegawai berhasil di import');
    }
    
    public function download()
    {
        $filepath = public_path('template/template-staff.xlsx');
        return Response::download($filepath); 
    }
}
