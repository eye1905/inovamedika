<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;
use Auth;
use DB;

class Staff extends Model
{
    use HasFactory;
    protected $table = "staffs";
    protected $primaryKey = "staff_id";
    protected $fillable = ['identity_id','name','birthplace', 'birthdate', 'gender', 'email', 'phone', 'address', 'entry_year', 'is_terapis', 'staff_status', 'created_by', 'created_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'staff_id', 'staff_id');
    }
    
    public static function getUserStaff($fisio = 0){
        $data = DB::select("
            select u.phone, u.email,u.user_id from staffs s
            join users u on u.staff_id = s.staff_id where s.is_terapis = '".$fisio."' ");

        return $data;
    }
}
