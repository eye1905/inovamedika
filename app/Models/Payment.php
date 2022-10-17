<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

class Payment extends Model
{
    use HasFactory;
    protected $table = "payments";
    protected $primaryKey = "payment_id";
    
    public static function getMedical($perpage, $page, $pasien =null, $code=null, $cara=null, $dr_tgl=null, $sp_tgl=null)
    {
        $sql = "select t.*,m.medical_code,p.name as pasien,p.gender,p.phone,s.name as staff,m.medical_code from payments t
                join medical_treatments m on t.medical_id = m.medical_id
        join patients p on m.patient_id = p.patient_id
        left join staffs s on t.staff_id=m.staff_id where t.date >= '".$dr_tgl."' and t.date <='".$sp_tgl."' ";

        if($pasien != null){
            $sql .= " and m.patient_id ='".$pasien."' ";
        }

        if($code != null){
            $sql .= " and m.medical_code ='".$code."' ";
        }

        if($cara != null){
            $sql .= " and t.method ='".$cara."' ";
        }
        
        $sql .= " order by t.date desc";

        $data = DB::select(DB::raw($sql));
        $collect = collect($data);
        
        $data = new LengthAwarePaginator(
            $collect->forPage($page, $perpage),
            $collect->count(), 
            $perpage, 
            $page
        );

        return $data;
    }
}
