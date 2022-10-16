<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class MedicalCheckup extends Model
{
    use HasFactory;
    protected $table = "medical_checkups";
    protected $primaryKey = "medical_checkup_id";

    public static function getDetail($id)
    {
        $sql = "SELECT c.name,m.description,m.medical_id FROM medical_checkups m 
        join checkups c on m.checkup_id = c.checkup_id
        where m.medical_id = '".$id."' ";
        $data = DB::select($sql);

        return $data;
    }
}
