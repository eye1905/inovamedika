<?php

namespace App\Helpers;

use Exception;
use stdClass;

class ImageHelper
{
    private $imagePath;
    private $width;
    private $height;
    private $targetPath;

    public function __construct($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    public function setTargetPath($targetPath)
    {
        $this->targetPath = $targetPath;
        return $this;
    }

    public function resize($width, $height)
    {
        $this->width = $width;
        $this->height = $height;

        return $this;
    }

    public function save()
    {
        try {
            $info = getimagesize($this->imagePath);
            $mime = $info['mime'];
            $random_name = StringHelper::generate_uuid();
        
            switch ($mime) {
                    case 'image/jpeg':
                            $image_create_func = 'imagecreatefromjpeg';
                            $image_save_func = 'imagejpeg';
                            $ext = 'jpg';
                            break;
        
                    case 'image/png':
                            $image_create_func = 'imagecreatefrompng';
                            $image_save_func = 'imagepng';
                            $ext = 'png';
                            break;
        
                    case 'image/gif':
                            $image_create_func = 'imagecreatefromgif';
                            $image_save_func = 'imagegif';
                            $ext = 'gif';
                            break;
        
                    default: 
                            throw new Exception('Unknown image type');
            }
        
            $img = $image_create_func($this->imagePath);
            list($width, $height) = getimagesize($this->imagePath);
        
            $tmp = imagecreatetruecolor($this->width, $this->height);
            imagecopyresampled($tmp, $img, 0, 0, 0, 0, $this->width, $this->height, $width, $height);
        
            if (file_exists($this->imagePath)) {
                unlink($this->imagePath);
            }
    
            GeneralHelper::make_directory($this->targetPath);
            
            $image_save_func($tmp, "$this->targetPath$random_name.$ext");
            
            $obj = new stdClass;
            $obj->error = false;
            $obj->error_message = null;
            $obj->image_name = $random_name.".$ext";
            $obj->target_path = $this->targetPath;
    
            return $obj;
        } catch (\Throwable $th) {
            $obj = new stdClass;
            $obj->error = true;
            $obj->error_message = $th->getMessage();
            $obj->image_name = null;
            $obj->target_path = null;
    
            return $obj;
        }
    }

}