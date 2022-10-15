<?php

namespace App\Helpers;

date_default_timezone_set('Asia/Jakarta');

use DateTime;
use Exception;

class GeneralHelper
{
    public static function ip_address()
    {
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? "0.0.0.0";

        return $ip_address;
    }

    public static function user_agent()
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? "-";
    }

    public static function generate_url($path)
    {
        return $path ? (url() . "/" . $path) : null;
    }

    public static function generate_path_storage($path)
    {
        return $path ? (base_path() . "/../storage/" . $path) : null;
    }

    public static function generate_timestamp()
    {
        return date('Y-m-d H:i:s');
    }

    public static function indo_dateformat($timestamp)
    {
        try {
            $datetime = new DateTime($timestamp);
            $datetime = $datetime->format('Y-m-d H:i:s');

            $explodedDatetime = explode(" ", $datetime);
            $explodedDate = $explodedDatetime[0];
            $explodedTime = $explodedDatetime[1];

            $explodedDate = explode("-", $explodedDate);
            $explodedDate = $explodedDate[2] . " " . self::indo_month($explodedDate[1]) . " " . $explodedDate[0];
            

            return $explodedDate . " " . $explodedTime;
        } catch (\Throwable $th) {
            return $timestamp;
        }
    }

    public static function indo_month($month)
    {
        $listMonths = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $month = (int) $month;

        return $listMonths[$month] ?? "";
    }

    public static function make_directory($directory)
    {
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
    }

    public static function resize_image($new_width, $target_file, $original_file) 
    {
        $info = getimagesize($original_file);
        $mime = $info['mime'];
    
        switch ($mime) {
                case 'image/jpeg':
                        $image_create_func = 'imagecreatefromjpeg';
                        $image_save_func = 'imagejpeg';
                        $new_image_ext = 'jpg';
                        break;
    
                case 'image/png':
                        $image_create_func = 'imagecreatefrompng';
                        $image_save_func = 'imagepng';
                        $new_image_ext = 'png';
                        break;
    
                case 'image/gif':
                        $image_create_func = 'imagecreatefromgif';
                        $image_save_func = 'imagegif';
                        $new_image_ext = 'gif';
                        break;
    
                default: 
                        throw new Exception('Unknown image type');
        }
    
        $img = $image_create_func($original_file);
        list($width, $height) = getimagesize($original_file);
    
        $newHeight = ($height / $width) * $new_width;
        $tmp = imagecreatetruecolor($new_width, $newHeight);
        imagecopyresampled($tmp, $img, 0, 0, 0, 0, $new_width, $newHeight, $width, $height);
    
        if (file_exists($target_file)) {
            unlink($target_file);
        }
        
        $image_save_func($tmp, "$target_file.$new_image_ext");
    }

    public static function url_dynamic_storage($path)
    {
        return $path ? (ServiceEndpoint::STORAGE_URL . $path) : null;        
    }

    public static function arraySort(&$list_of_array, $key, $sort_type = 4)
    {
        if (empty($list_of_array)) {
            return [];
        }

        if (empty($key)) {
            return $list_of_array;
        }

        if (!isset($list_of_array[0][$key])) {
            return $list_of_array;
        }

        usort($list_of_array, function ($a, $b) use ($key, $sort_type) {
            if ($sort_type == 4) {
                return $a[$key] <=> $b[$key];
            } else {
                return $b[$key] <=> $a[$key];
            }
        });
    }
}