<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use DB;
use Session;
use Exception;
use Auth;
use Validator;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = 10;
        if(isset($request->shareselect) and $request->shareselect != null){
            $page = $request->shareselect;
        }

        $data["data"] = Medicine::paginate($page);
        $data["filter"] = array("page" => $page);
        
        return view("medicines", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data["data"] = [];

        return view("form.medicine", $data);
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
            'name'  => 'bail|required|alphanum_spaces|max:20|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.medicines,name',
            'code'  => 'bail|required|alphanum_spaces|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.medicines,code',
            'dosis'  => 'bail|nullable',
            'indikasi'  => 'bail|nullable',
            'harga'  => 'bail|required|numeric',
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());;
        }
        
        try {
            DB::beginTransaction();
            $obat = new Medicine();
            $obat->name             = $request->name;
            $obat->code             = $request->code;
            $obat->indikasi      = $request->indikasi;
            $obat->dosis      = $request->dosis;
            $obat->harga      = $request->harga;
            $obat->created_ip       = $request->ip();
            $obat->created_by = Auth::user()->user_id;
            $obat->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data obat Gagal Disimpan' )->withInput($request->input());;
        }
        
        return redirect("medicine")->with('success', 'Data obat Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data["data"] = Medicine::findOrFail($id);
        
        return view("form.medicine", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data["data"] = Medicine::findOrFail($id);
        
        return view("form.medicine", $data);
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
            'name'  => 'bail|required|alphanum_spaces|max:20|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.medicines,name,'.$id.',medicine_id',
            'code'  => 'bail|required|alphanum_spaces|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.medicines,code,'.$id.',medicine_id',
            'dosis'  => 'bail|nullable',
            'indikasi'  => 'bail|nullable',
            'harga'  => 'bail|required|numeric',
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());;
        }
        
        try {
            DB::beginTransaction();
            $obat = Medicine::findOrFail($id);
            $obat->name             = $request->name;
            $obat->code             = $request->code;
            $obat->indikasi      = $request->indikasi;
            $obat->dosis      = $request->dosis;
            $obat->harga      = $request->harga;
            $obat->updated_ip       = $request->ip();
            $obat->updated_by = Auth::user()->user_id;
            $obat->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data obat Gagal Disimpan' )->withInput($request->input());;
        }
        
        return redirect("medicine")->with('success', 'Data obat Disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $obat = Medicine::findOrFail($id);
            $obat->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data obat Gagal dihapus' )->withInput($request->input());;
        }
        
        return redirect()->back()->with('success', 'Data obat dihapus');
    }
}
