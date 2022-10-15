<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Regions extends Model
{
    use HasFactory;
    protected $table = "regions";
    protected $primaryKey = "id_wil";

    public static function getWilayah($nama = null, $level = null)
    {
        $sql = "SELECT r.*
        ,prov.nama_wil AS provinsi
        , kab.nama_wil AS kabupaten
        , kec.nama_wil AS kecamatan
        FROM regions r
        left JOIN regions prov ON r.prov_id = prov.id_wil
        left JOIN regions kab ON r.kab_id = kab.id_wil
        left JOIN regions kec ON r.kec_id = kec.id_wil";
        
        if (isset($nama)) {
            $sql = $sql." where lower(r.nama_wil) like lower('%".$nama."%')";

        }
        
        if (isset($level)) {
            $sql = $sql." and r.level_wil='".$level."' ";
        }
        
        $sql = $sql." order by r.level_wil,nama_wil asc";

        $data = DB::select(DB::raw($sql));
        
        return $data;
    }

    public static function getSelect2($id = null)
    {
        $sql = "select c.id_wil,CONCAT(p.nama_wil,' > ', c.nama_wil)  as kota from regions p 
        join regions c on p.id_wil = c.prov_id
        where c.level_wil = '2'";

        $kota = DB::select($sql);

        $sql = "select id_wil,kab_id, nama_wil as kec from regions where level_wil = '3'";
        $kec = DB::select($sql);

        $kec2 = [];
        foreach($kec as $key => $value){
            $kec2[$value->kab_id][$value->id_wil] = $value;
        }
        $wilayah = [];
        foreach($kota as $key => $value){
            if(isset($kec2[$value->id_wil])){
                foreach($kec2[$value->id_wil] as $key2 => $value2){

                }
            }
        }
        
        $data = $kota;

        return $data;
    }
}
