<?php

namespace App\Helpers;

use App\Utils\StorageUtils;
use Exception;

class FileHelper
{
    private $STORAGE_PATH = null;
    private $file = null;
    private $filePath = "";
    private $fileExtension = "";    
    private $fileMaxSize = 0;
    private $allowedTypes = [];
    private $is_multiple = false;

    public function __construct($filename, $path)
    {
        $this->STORAGE_PATH = "/../".StorageUtils::getStorageDir()."/";

        if (!is_array($_FILES[$filename]['name'])) {
            if (!isset($_FILES[$filename]['name']) && empty($_FILES[$filename]['name'])) {
                throw new Exception("Invalid file format", 401);
            }
        } else {
            $this->is_multiple = true;
        }

        if ($path == NULL) {
            throw new Exception("Invalid path", 401);
        }

        $this->file = $_FILES[$filename];
        $this->fileName = $filename;
        $this->filePath = $path;
    }

    public function allowedTypes(array $allowed_types) : object
    {
        $this->allowedTypes = $allowed_types;
        return $this;
    }

    public function maxSize(int $max_size) : object
    {
        $this->fileMaxSize = $max_size;
        return $this;
    }

    public function save()
    {
        if (!$this->is_multiple) {
            $exploded = explode('.', $this->file['name']);
            $exploded = end($exploded);
            $this->fileExtension = strtolower($exploded);
        } else {
            $exploded = explode('.', $this->file['name'][0]);
            $exploded = end($exploded);
            $this->fileExtension = strtolower($exploded);
        }

        //check mime types of file for first
        if (!$this->checkMimeTypes()) {
            return new FileCallback(true, "Format file is invalid");
        }

        if (($this->file['size'] >> 10) > $this->fileMaxSize) {
            return new FileCallback(true, "File size is too large");
        }

        if (!in_array($this->fileExtension, $this->allowedTypes)) {
            return new FileCallback(true, "File type is not allowed");
        }
        
        if (!is_dir(base_path().$this->STORAGE_PATH.$this->filePath)) {
            mkdir(base_path().$this->STORAGE_PATH.$this->filePath, 0777, true);
        }

        if (!$this->is_multiple) {
            $encryptedFileName = $this->generateEncryptedFileName();
            $encryptedFileName .= ".$this->fileExtension";        
    
            // Now you move/upload file
            if (!move_uploaded_file($this->file['tmp_name'] , base_path().$this->STORAGE_PATH.$this->filePath.$encryptedFileName)) {
                // File moved to the destination
                return new FileCallback(true, "Something went wrong occurs, please try again later", $this->file['name']);
            }
    
            return new FileCallback(false, "", $this->file['name'], $encryptedFileName, $this->filePath, 
                                    $this->file['size'], $this->file['type'],
                                    $this->fileExtension);
        } else {
            $encryptedFileNames = [];
            $listFileCallback = [];

            foreach ($this->file['name'] as $key => $value) {
                $encryptedFileName = $this->generateEncryptedFileName();
                $encryptedFileName .= ".$this->fileExtension";
                $encryptedFileNames[] = $encryptedFileName;

                // Now you move/upload file
                if (!move_uploaded_file($this->file['tmp_name'][$key] , $this->STORAGE_PATH.$this->filePath.$encryptedFileName)) {
                    // File moved to the destination
                    return new FileCallback(true, "Something went wrong occurs, please try again later", $this->file['name']);
                }

                array_push($listFileCallback, new FileCallback(false, "", $this->file['name'], $encryptedFileNames, $this->filePath, 
                                                $this->file['size'], $this->file['type'],
                                                $this->fileExtension));
            }

            return $listFileCallback;
        }
    }

    private function checkMimeTypes() : bool
    {
        $mime_types = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',
            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',
            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',
            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rt',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        $type = mime_content_type($this->file['tmp_name']);

        if (!isset($mime_types[$this->fileExtension])) {
            return false;
        }

        if ($mime_types[$this->fileExtension] != $type) {
            return false;
        }

        return true;
    }

    private function generateEncryptedFileName()
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $input_length = strlen($permitted_chars);
        $random_string = '';

        for ($i = 0; $i < 32; $i++) {
            $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }

}

class FileCallback
{
    private $error = false;
    private $errorMessage = "";
    private $fileName = "";
    private $filePath = "";
    private $fileOriginName = "";
    private $fileType = "";
    private $fileSize = "";
    private $fileExtension = "";

    public function __construct($error, $errorMessage, $fileOriginName = null, $fileName = null, $filePath = null, $fileSize = null, $fileType = null, $fileExtension = null)
    {
        $this->error = $error;
        $this->errorMessage = $errorMessage;
        $this->fileOriginName = $fileOriginName;
        $this->fileName = $fileName;
        $this->filePath = $filePath;
        $this->fileSize = $fileSize;
        $this->fileType = $fileType;
        $this->fileExtension = $fileExtension;
    }   

    public function error()
    {
        return $this->error;
    }

    public function getOriginName()
    {
        return $this->fileOriginName;
    }

    public function getName()
    {
        return $this->fileName;
    }

    public function getPath()
    {
        return $this->filePath;
    }

    public function getSize()
    {
        return $this->fileSize;
    }

    public function getType()
    {
        return $this->fileType;
    }

    public function getExtension()
    {
        return $this->fileExtension;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function getFileSize()
    {
        return $this->fileSize;
    }

}