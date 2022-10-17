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
use App\Models\Medicine;
use App\Models\Checkup;
use App\Models\MedicalCheckup;
use App\Models\MedicalMedicine;
use App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perpage = $request->shareselect?$request->shareselect:10;
        $page = $request->dr_tgl?$request->sp_tgl:1;
        $f_patient_id = $request->f_patient_id?$request->f_patient_id:null;
        $f_medical_code = $request->f_medical_code?$request->f_medical_code:null;
        $f_method = $request->f_method?$request->f_method:null;
        $start_date = $request->start_date?$request->start_date:date('Y-m-01');
        $end_date = $request->end_date?$request->end_date:date('Y-m-t');
        
        $data["data"] = Payment::getMedical($perpage, $page, $f_patient_id, $f_medical_code, $f_method, $start_date, $end_date);
        $data["code"] = MedicalTreatment::select("medical_code")->orderBy("date", "desc")->get();
        $data["pasien"] = Patients::select("name", "patient_id")->orderBy("name", "asc")->get();
        $data["filter"] = array("page" => $perpage, 
                            "f_patient_id" => $f_patient_id,
                            "f_medical_code" => $f_medical_code,
                            "f_method" => $f_method,
                            "start_date" => $start_date,
                            "end_date" => $end_date);

        $data["metode"] = array("transfer" => "transfer",
                            "tunai" => "tunai",
                            "va" => "va",
                            "va" => "va",
                            "gopay" => "gopay",
                            "shopeepay" => "shopeepay",
                            "qris" => "qris");
        
        return view("payment", $data);
    }
}
