<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Checkup extends Model
{
    use HasFactory;
    protected $table = "checkups";
    protected $primaryKey = "checkup_id";

    public static function getListTindakan()
    {
        $sql = "select c.name, c.checkup_id, s.medical_id from medical_checkups s 
        join checkups c on s.checkup_id = c.checkup_id";

        $data = DB::select($sql);

        $a_data = [];
        foreach($data as $key =>  $value){
            $a_data[$value->medical_id][$value->checkup_id] = $value->name;
        }
        
        return $a_data;
    }
}
