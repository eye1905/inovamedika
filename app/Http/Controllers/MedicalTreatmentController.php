<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patients;
use App\Models\Staff;
use App\Models\Regions;
use App\Models\MedicalTreatment;
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

class MedicalTreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'patient_id'  => 'bail|required|alphanum_spaces|max:255|exists:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.patients,patient_id',
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());;
        }
        
        $id = null;
        try {

            DB::beginTransaction();
            $medical = new MedicalTreatment();
            $medical->patient_id             = $request->patient_id;
            $medical->medical_code          = "MT-".StringHelper::random_number(9);
            $medical->date             = $request->date;
            $medical->description       = $request->description;
            $medical->staff_id       = Auth::user()->staff_id;
            $medical->created_ip       = $request->ip();
            $medical->created_by = Auth::user()->user_id;
            $medical->is_payment = 0;
            $medical->save();

            $id = $medical->medical_id;
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data pemeriksaan medis Gagal Disimpan'.$e->getMessage())->withInput($request->input());
        }
        
        return redirect("medical/".$id)->with('success', 'Data pemeriksaan medis Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $medical  = MedicalTreatment::findOrFail($id);
        $patients = Patients::findOrFail($medical->patient_id);
        $data['pasien']  = $patients;
        $data["data"] = $medical;
        //dd($data);
        return view("form.medical", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
