<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigations extends Model
{
    use HasFactory;
    protected $table = "navigations";
    protected $primaryKey = "navigation_id";

    public function parent()
    {
        return $this->belongsTo('App\Models\Navigations', 'parent_navigation_id', 'navigation_id');
    }
    
    public static function getMenu($level = null)
    {
        $data = self::select("name", "navigation_id", "uri", "icon","description", "parent_navigation_id")->where("is_show", 1);
        
        if($level != null){
            $data->where("level",$level);
        }

        $data->orderBy("level", "asc")->orderBy("position", "asc");

        return $data->get();
    }

    public static function getList($level = null)
    {
        $data = self::where("level", $level)->orderBy("level", "asc")->orderBy("position", "asc")->get();
        
        return $data;
    }

    public static function getListMenu()
    {
        $data = self::select("navigations.name", "navigations.navigation_id", "navigations.level", "navigations.parent_navigation_id", "navigations.icon", "navigations.description", "navigations.is_master", "navigations.controller", "navigations.position", "navigations.uri", "nf.name as parent")
        ->leftjoin("navigations as nf", "nf.navigation_id", "navigations.parent_navigation_id");

        $data->orderBy("navigations.level", "asc")
        ->orderBy("nf.position", "asc");

        return $data->get();
    }

    public static function getUpPosition($level, $position, $parent = null)
    {
        $data = self::select("navigation_id", "position", "parent_navigation_id")
        ->where("level", $level)
        ->where("position", "<", $position);
        if($parent != null){
            $data->where("parent_navigation_id", $parent);
        }
        $data->orderBy("position", "desc");
        return $data->get()->first();
    }
    
    public static function getDownPosition($level, $position, $parent = null)
    {
        $data = self::select("navigation_id", "position", "parent_navigation_id")
        ->where("level", $level)
        ->where("position", ">", $position);
        if($parent != null){
            $data->where("parent_navigation_id", $parent);
        }
        $data->orderBy("position", "asc");
        return $data->get()->first();
    }
}
