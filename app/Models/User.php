<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";
    protected $primaryKey = "user_id";
    
    public static function getStatus()
    {
        $data = array("active" => "active", "inactive"=>"inactive", "suspended" => "suspended", "deleted"=> "deleted");
        
        return $data;
    }
    
    public function staff()
    {
        return $this->belongsTo('App\Models\Staff', 'staff_id', 'staff_id');
    }
}
