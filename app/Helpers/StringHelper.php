<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use App\Models\RolePermition;
use App\Models\Navigations;
use App\Models\Role;
use Session;

class StringHelper
{

    public static function inc_edit($id)
    {   
        $uri = request()->segment(1);
        $role_id = Session("role_id");
        $role = Role::where("code", $role_id)->get()->first();
        $menus = Navigations::select("navigation_id")->where("uri", $uri)->get()->first();
        $inc_role = RolePermition::where("navigation_id", $menus->navigation_id)
        ->where("role_id", $role->role_id)
        ->get()->first();
        
        $url = "'".url($uri.'/'.$id)."'";
        
        $html = '<center>'; 

        if((isset($inc_role->detail_permission) and $inc_role->detail_permission==1) or $role_id=="1"){
            $html = $html.' <a href="'.url($uri.'/'.$id).'" class="btn btn-sm btn-info" style="color: #fff" data-toggle="tooltip" data-placement="bottom" title="Show Detail">
            <i class="fa fa-eye"></i>
            </a>'; 
        }
        
        if((isset($inc_role->update_permission) and $inc_role->update_permission==1) or $role_id=="1"){
            $html = $html.' <a href="'.url($uri.'/'.$id.'/edit').'" class="btn btn-sm btn-warning" style="color: #fff" data-toggle="tooltip" data-placement="bottom" title="Edit">
            <i class="fa fa-pencil"></i>
            </a>'; 
        }
        
        if((isset($inc_role->delete_permission) and $inc_role->delete_permission==1) or $role_id=="1"){
            $html =    $html.' <button class="btn btn-sm btn-danger" id = "hapus" type="button" onclick="CheckDelete('.$url.')" data-toggle="tooltip" data-placement="bottom" title="Delete">
            <i class="fa fa-times"></i>
            </button>';
        }
        
        $html = $html.'</center>';

        return $html;
    }

    public static function inc_dropdown($id)
    {   
        $uri = request()->segment(1);
        $role_id = Session("role_id");
        $role = Role::where("code", $role_id)->get()->first();
        $menus = Navigations::select("navigation_id")->where("uri", $uri)->get()->first();
        $inc_role = RolePermition::where("navigation_id", $menus->navigation_id)
        ->where("role_id", $role->role_id)
        ->get()->first();
        
        $url = "'".url($uri.'/'.$id)."'";

        $html = '<button class="btn btn-sm btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button><div class="dropdown-menu">';

        if((isset($inc_role->detail_permission) and $inc_role->detail_permission==1) or $role_id=="1"){
            $html = $html.'<a class="dropdown-item" href="'.url($uri.'/'.$id).'"><i class="fa fa-eye"></i> Detail</a>';
        }
        
        if((isset($inc_role->update_permission) and $inc_role->update_permission==1) or $role_id=="1"){
            $html = $html.'<a class="dropdown-item" href="'.url($uri.'/'.$id.'/edit').'"><i class="fa fa-edit"></i> Edit</a>';
        }

        if((isset($inc_role->delete_permission) and $inc_role->delete_permission==1) or $role_id=="1"){
            $html = $html.'<a class="dropdown-item" href="#" onclick="CheckDelete('.$url.')"><i class="fa fa-times"></i> Hapus</a>';
        }
        

        $html = $html."</div>";

        return $html;
    }

    public static function ucsplit($arr)
    {
        $data = explode(" ", $arr);
        $kata = null;
        foreach($data as $key => $value){
            $kata .= ucfirst($value)." ";
        }

        return $kata;

    }

    public static function getNameMenu($uri = null)
    {
        $nav_menu = null;
        if($uri != null){
            $nav_menu = Navigations::select("name")->where("uri", $uri)->get()->first();
        }else{
            $nav_menu = Navigations::select("name")->where("uri", request()->segment(1))->get()->first();
        }
        return ucfirst($nav_menu->name);
    }
    
    public static function random_alfanumeric($length = 16)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $input_length = strlen($permitted_chars);
        $random_string = '';

        for ($i = 0; $i < $length; $i++) {
            $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }

    public static function random_number($length = 5)
    {
        $permitted_chars = '0123456789';

        $input_length = strlen($permitted_chars);
        $random_string = '';

        for ($i = 0; $i < $length; $i++) {
            $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }

    public static function generate_merchant_code()
    {
        $merchant_code = "MRC-BKP-" . strtoupper(self::random_alfanumeric(6));

        return $merchant_code;
    }

    public static function generate_product_uuid()
    {
        $product_uuid = self::generate_uuid();

        return $product_uuid;
    }

    public static function generate_customer_code()
    {
        $customer_code = "CUST-BKP-" . strtoupper(self::random_alfanumeric(6));

        return $customer_code;
    }
    
    public static function generate_uuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    public static function getAccess($permit)
    {   
        $uri = request()->segment(1);
        if(Session("role_id") == "1"){
            return true;
        }else{
            $menu  = Navigations::select("navigation_id")->where("uri", $uri)->get()->first();
            $role = Role::where("code", Session("role_id"))->get()->first();
            $h_access = RolePermition::select($permit)->
            where("role_id", $role->role_id)->where("navigation_id", $menu->navigation_id)->get()->first()->toArray();
            
            return $h_access[$permit];
        }
    }

    public static function slugify($text, string $divider = '-')
    {
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('[^-\w]+', '', $text);
        $text = trim($text, $divider);
        $text = preg_replace('-+', $divider, $text);
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function route_redirect()
    { 
        $route = Request::segment(1);

        return $route;
    }

    public static function toRupiah($data, $digit = null)
    { 
        $data = "Rp. ".number_format($data, $digit, ',', '.');

        return $data;
    }

    public static function tonumberround($data){

        $data = number_format($data, 2, ',', '.');
        return $data;

    }

    public static function datedifferent($start, $end)
    {
        $diff = abs(strtotime($start) - strtotime($end));

        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

        $dd = $years." Tahun ".$months." Bulan ".$days." Hari";

        return $dd;
    }

    public static function daydifferent($start, $end)
    {
        $start_date = strtotime($start);
        $end_date = strtotime($end);
        $diff = ($end_date - $start_date)/60/60/24;
        
        return $diff;
    }

    public static function tonumber($data){

        $data = number_format($data, 0, ',', '.');
        return $data;

    }

    public static function toMinutes($str) {
        $jam = (Double)date("H", strtotime($str))*60;
        $minute = (Double)date("i", strtotime($str));
        $second = (Double)date("s", strtotime($str))/60;

        $total = $jam+$minute+$second;

        return $total;
    }

    public static function terbilang($nilai) {
        if($nilai<0) {
            $hasil = "minus ". trim(penyebut($nilai));
        } else {
            $hasil = trim(penyebut($nilai));
        }           
        return $hasil;
    }

    public static function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = penyebut($nilai - 10). " Belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " Seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
        }     
        return $temp;
    }

    public static function daydate($tanggal)
    {   
        $date = strtolower(date_format(date_create($tanggal), "D"));
            //dd($date);
        $hari = "";
        if($date=="sun"){
            $hari = "Minggu";
        }elseif($date=="mon"){
            $hari = "Senin";
        }elseif($date=="tue"){
            $hari = "Selasa";
        }elseif($date=="wed"){
            $hari = "Rabu";
        }elseif($date=="thu"){
            $hari = "Kamis";
        }elseif($date=="fri"){
            $hari = "Jum'at";
        }elseif($date=="sat"){
            $hari = "Sabtu";
        }else{
            $hari = "tidak valid";
        }

        return $hari;
    }

    public static function flipdate($day)
    {
        $array_date = array("Minggu" => 7,
                            "Senin" => 1,
                            "Selasa" => 2,
                            "Rabu" => 3,
                            "Kamis" => 4,
                            "Jum'at" => 5,
                            "Sabtu" => 6
                        );

                    return $array_date[$day];
    }

    public static function dateindo($tanggal)
    {   
        $date = date("d-m-Y", strtotime($tanggal));

        $bulan = array (
            1 =>   'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Jul',
            8 => 'Ags',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des'
        );

        $pecahkan = explode('-', $date);

        return $pecahkan[0] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[2];
    }

    public static function dateindohours($tanggal)
    {   
        $date = date("d-m-Y H:i:s", strtotime($tanggal));

        $bulan = array (
            1 =>   'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Jul',
            8 => 'Ags',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des'
        );

        $pecahkan = explode('-', $date);

        return $pecahkan[0] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[2].' '.$pecahkan[3];
    }

    public static function livestorage()
    {
        $Storage = base_path()."/../../storage.bukapasar.id";

        return $Storage;
    }

    public static function urlstorage()
    {
        $Storage = env("APP_STORAGE", null)."/";

        return $Storage;
    }

    public static function getweek($start)
    {
        $date = date("Y-m-d", strtotime($start . "+1 week"));
        
        return $date;
    }

    public static function validateIndo($nomor)
    {
        $no = $nomor;
        $sb = substr($nomor, 0,1);
        if($sb == 0){
            $no = substr($nomor,1);
        }
        
        $sb2 = substr($nomor, 0,2);
        if($sb2 == 62){
            $no = substr($nomor, 2);
        }
        
        return "62".$no;
    }
    
}