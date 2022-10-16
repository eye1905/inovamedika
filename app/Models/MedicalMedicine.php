<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class MedicalMedicine extends Model
{
    use HasFactory;
    protected $table = "medical_medicines";
    protected $primaryKey = "medical_medicine_id";

    public static function getDetail($id)
    {
        $sql = "select m.medicine_id,s.name,m.medical_medicine_id,s.harga,m.qty,m.price  from medical_medicines m 
        join medicines s on m.medicine_id = s.medicine_id
        where m.medical_id = '".$id."' ";

        $data = DB::select($sql);

        return $data;        
    }
}
