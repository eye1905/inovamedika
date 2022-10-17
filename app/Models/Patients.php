<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Helpers\StringHelper;

class Patients extends Model
{
    use HasFactory;
    protected $table = "patients";
    protected $primaryKey = "patient_id";
    protected $fillable = ['medical_record_number','name','birthplace', 'birthdate', 'gender', 'email', 'phone', 'address', 'first_entry', 'patient_status_id', 'referral_doctor_id', 'status', 'created_by', 'created_at'];
    
    public function region()
    {
        return $this->belongsTo('App\Models\Regions', 'birthplace', 'id_wil');
    }
    public static function countkelamin($start, $end)
    {
        $sql = "select COALESCE(l.laki,0) as laki, COALESCE(n.perempuan ,0) as perempuan, DATE_FORMAT(p.first_entry, '%m') as bulan from patients 
        p left join (
        select count(patient_id) as laki,gender from patients where gender = 'male'
        ) as l on p.gender = l.gender 
        left join (
        select count(patient_id) as perempuan,gender from patients where gender = 'female'
        ) as n on n.gender = p.gender
        GROUP BY p.gender, DATE_FORMAT(p.first_entry, '%m') order by DATE_FORMAT(p.first_entry, '%m') asc";

        $data = DB::select($sql);
        $a_data = [];
        foreach($data as $key => $value){
            $a_data[$value->bulan]["laki"] = $value->laki;
            $a_data[$value->bulan]["perempuan"] = $value->perempuan;
        }

        $a_bulan = [];
        for($i = 1; $i<=12; $i++){
            $f = $i;
            if($i<10){
                $f = "0".$i;
            }

            $a_bulan[$f]["laki"] = 0;
            $a_bulan[$f]["perempuan"] = 0;
            if(isset($a_data[$f])){
                $a_bulan[$f]["laki"] = $a_data[$f]["laki"];
                $a_bulan[$f]["perempuan"] = $a_data[$f]["perempuan"];
            }
        }

        return $a_bulan;
    }

    public static function getusia()
    {   

        $pasien = self::select("birthdate")->get();
        
        $umur = [];
        for ($i = 0; $i <12 ; $i++) {
            $umur[$i]= 0;
        }

        foreach($pasien as $key => $value){
            $usia = StringHelper::datedifferent(date("Y-m-d"), $value->birthdate);
            if($usia < 10){
                $umur[0] += $umur[0]+1;
            }elseif($usia >= 10 and $usia < 15){
                $umur[1] += $umur[1]+1;
            }elseif($usia >= 15 and $usia < 20){
                $umur[2] += $umur[2]+1;
            }elseif($usia >= 15 and $usia < 20){
                $umur[3] += $umur[3]+1;
            }elseif($usia >= 20 and $usia < 25){
                $umur[4] += $umur[4]+1;
            }elseif($usia >= 25 and $usia < 30){
                $umur[5] += $umur[5]+1;
            }elseif($usia >= 30 and $usia < 35){
                $umur[6] += $umur[6]+1;
            }elseif($usia >= 35 and $usia < 40){
                $umur[7] += $umur[7]+1;
            }elseif($usia >= 40 and $usia < 45){
                $umur[8] += $umur[8]+1;
            }elseif($usia >= 45 and $usia < 50){
                $umur[9] += $umur[9]+1;
            }
        }

        return $umur;
    }
}
