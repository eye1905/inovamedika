<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Medicine extends Model
{
    use HasFactory;
    protected $table = "medicines";
    protected $primaryKey = "medicine_id";
    
    public static function getListObat()
    {
        $sql = "select s.medical_id,m.medicine_id,m.name from medical_medicines s
join medicines m on s.medicine_id = m.medicine_id";

        $data = DB::select($sql);

        $a_data = [];
        foreach($data as $key =>  $value){
            $a_data[$value->medical_id][$value->medicine_id] = $value->name;
        }
        
        return $a_data;
    }
}
