<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkup;
use DB;
use Session;
use Exception;
use Auth;
use Validator;
use App\Helpers\Stringhelper;

class CheckupController extends Controller
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

        $data["data"] = Checkup::paginate($page);
        $data["filter"] = array("page" => $page);
        
        return view("checkup", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
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
            'name'  => 'bail|required|alphanum_spaces|max:255|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.checkups,name',
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());;
        }
        
        try {

            DB::beginTransaction();
            $obat = new Checkup();
            $obat->name             = $request->name;
            $obat->created_ip       = $request->ip();
            $obat->created_by = Auth::user()->user_id;
            $obat->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data tindakan Gagal Disimpan' )->withInput($request->input());;
        }
        
        return redirect()->back()->with('success', 'Data tindakan Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
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
            'name'  => 'bail|required|alphanum_spaces|max:255|unique:'.env('DB_CONNECTION').'.'.env('DB_DATABASE').'.checkups,name,'.$id.',checkup_id',
        ]);
        
        if ($validator->fails())
        {
            return redirect()->back()->with('errors', $validator->errors())->withInput($request->input());;
        }
        
        try {

            DB::beginTransaction();
            $obat = Checkup::findOrFail($id);
            $obat->name             = $request->name;
            $obat->updated_ip       = $request->ip();
            $obat->updated_by = Auth::user()->user_id;
            $obat->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data tindakan Gagal Disimpan' )->withInput($request->input());;
        }
        
        return redirect()->back()->with('success', 'Data tindakan Disimpan');
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
            $obat = Checkup::findOrFail($id);
            $obat->delete();
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data tindakan Gagal dihapus' );
        }
        
        return redirect()->back()->with('success', 'Data tindakan dihapus');
    }
}
