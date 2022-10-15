<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = "roles";
    protected $primaryKey = "role_id";

    public static function getList($id = null)
    {   
        $data = self::select("role_id", "code", "name");
        if($id != null){
            $data->where("role_id", $id);
        }
        
        $data->where("role_id", ">", 1);

        return $data->get();
    }

    public static function getRoleCode($code = null)
    {
        $data = self::select("role_id", "code", "name")->where("code", $code)->first();
        
        return $data;
    }
}
