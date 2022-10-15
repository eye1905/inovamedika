<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Navigations;

class RolePermition extends Model
{
    use HasFactory;
    protected $table = "role_permissions";
    protected $primaryKey = "role_permission_id";

    public function menu()
    {
        return $this->belongsTo('App\Models\Navigations', 'navigation_id', 'navigation_id');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'role_id');
    }

    public static function getList($id = null)
    {
        $sql = self::join("roles", "role_permissions.role_id", "=", "roles.role_id")
        ->join("navigations", "role_permissions.navigation_id", "=", "navigations.navigation_id");

        if($id != null){
            $sql->where("role_permissions.role_permission_id", $id);
        }
        $sql->select("role_permissions.create_permission", "role_permissions.update_permission", "role_permissions.delete_permission", "role_permissions.read_permission", "role_permissions.detail_permission", "role_permissions.import_permission", "role_permissions.export_permission", "role_permissions.role_permission_id", "navigations.name as nm_menu", "roles.name")
        ->orderBy("roles.role_id", "asc")
        ->orderBy("navigations.level", "asc")->orderBy("navigations.position");

        return $sql->get();
    }

    public static function getMenu($level, $role_id)
    {
        $role = Role::where("code", $role_id)->get()->first();
        $sql = "select n.name, n.controller, n.parent_navigation_id,n.navigation_id, n.uri, n.icon, n.description from navigations n 
        join role_permissions r on r.navigation_id = n.navigation_id
        where n.level = '".$level."' and r.role_id ='".$role->role_id."' and n.is_show='1' order by n.level, n.position asc";
        
        return DB::select($sql);
    }

    public static function getAccess($uri, $id_role)
    {   
        $uri = str_replace("cetak", "report", request()->segment(1));
        $menu = Navigations::where("uri", $uri)->get()->first();
        $role = Role::where("code", $id_role)->get()->first();
        $data = self::where("navigation_id", $menu->navigation_id)->where("role_id", $role->role_id)->get()->first();
        
        return $data;
    }
}
