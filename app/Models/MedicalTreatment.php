<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

class MedicalTreatment extends Model
{
    use HasFactory;
    protected $table = "medical_treatments";
    protected $primaryKey = "medical_id";

    public function staff()
    {
        return $this->belongsTo('App\Models\Staff', 'staff_id', 'staff_id');
    }

    public function pasien()
    {
        return $this->belongsTo('App\Models\Patients', 'patient_id', 'patient_id');
    }

    public static function getMedical($perpage, $page, $pasien =null, $code=null, $status=null, $dr_tgl=null, $sp_tgl=null)
    {
        $sql = "select m.*,p.name as pasien,p.gender,p.phone,s.name as staff from medical_treatments m 
        join patients p on m.patient_id = p.patient_id
        left join staffs s on s.staff_id=m.staff_id where m.date >= '".$dr_tgl."' and m.date <='".$dr_tgl."' ";

        if($pasien != null){
            $sql .= " and m.patient_id ='".$pasien."' ";
        }

        if($code != null){
            $sql .= " and m.medical_code ='".$code."' ";
        }

        if($status != null){
            $sql .= " and m.status ='".$status."' ";
        }

        $sql .= " order by m.date asc";

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
