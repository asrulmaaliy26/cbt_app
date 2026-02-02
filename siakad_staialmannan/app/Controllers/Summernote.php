<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Summernote extends BaseController
{
    //upload image summernote
    function upload_image(){
        if($this->request->getFile('image')){
            $dataImage = $this->request->getFile('image');
            $fileName = $dataImage->getRandomName();
            $dataImage->move("upload/summernote/", $fileName);
            echo base_url("upload/summernote/$fileName");
        }
    }
    
    function upload_file(){
        if($this->request->getFile('file')){
            $dataFile = $this->request->getFile('file');
            $fileName = $dataFile->getRandomName();
            $dataFile->move("upload/summernote/", $fileName);
            echo base_url("upload/summernote/$fileName");
        }
    }

    //Delete image summernote
    function delete_image(){
        $src = $this->request->getVar('src');
        $file_name = /*$src;*/str_replace(base_url()."/", '', $src);
        if(@unlink($file_name)){
            echo 'File Delete Successfully';
        }
    }
}