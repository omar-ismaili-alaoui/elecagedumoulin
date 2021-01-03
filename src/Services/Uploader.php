<?php


namespace App\Services;


use Symfony\Component\HttpFoundation\Request;

class Uploader {

    public function removeFile($tempFolder, $userId){
        $target_dir = realpath('uploads/'.$tempFolder.'/temp-files');
        unlink('test.html');
    }

    public function uploadTempFile($tempFolder, $userId){
        $target_dir = realpath('uploads/'.$tempFolder.'/temp-files');
        $target_file = $target_dir .'/'.$userId.'-'. basename($_FILES["fileBB"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $gen = $this->generateSecret('',8,'');
        $target_file = substr($target_file,0,-4);
        $target_file = str_replace(' ','-',$target_file);
        $target_file = $target_file . '-' . $gen . '.' . $imageFileType;
        $name = substr(basename($_FILES["fileBB"]["name"]),0,-4);
        $name = str_replace(' ','-',$name);
        // Check if image file is a actual image or fake image
        if(isset($_POST)) {
            $check = getimagesize($_FILES["fileBB"]["tmp_name"]);
            if($check !== false) {
                //echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
                return "File is not an image.";
            }
        }
        $imagedetails = getimagesize($_FILES['fileBB']['tmp_name']);

        $width = $imagedetails[0];
        $height = $imagedetails[1];
        if (file_exists($target_file)) {
            $uploadOk = 0;
            return "Sorry, file already exists.";
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            return "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileBB"]["tmp_name"], $target_file)) {
                //$this->imageCropping($target_file);
                //echo "The file ". basename( $_FILES["fileBB"]["name"]). " has been uploaded.";
            } else {
                return "Sorry, there was an error uploading your file.";
            }
        }
        if($imageFileType == "png" || $imageFileType == "PNG") {
            $nameTwo = substr($target_file,0,-4);
            $this->png2jpg($target_file,$nameTwo.'.jpg',100);
            return '/'.$tempFolder.'/temp-files/'.$userId.'-'.$name.'-'.$gen.'.'.'jpg'.'***'.$width.'***'.$height;
        }else{
            return '/'.$tempFolder.'/temp-files/'.$userId.'-'.$name.'-'.$gen.'.'.$imageFileType .'***'.$width.'***'.$height;
        }
    }

    public function cropFile(Request $request,$userId){
        $dateNow = (new \DateTime('NOW'))->getTimestamp();
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            $newFileName = $userId.'-'.$dateNow.'.jpg';
            $srcFile = 'uploads/'.$_POST['folder'].'/' . $newFileName;
            move_uploaded_file($_FILES['file']['tmp_name'], $srcFile);
            list($width, $height) = getimagesize($srcFile);

            $this->createThumbImageFromOriginalImage($srcFile,640,((640*$height)/$width),$srcFile,$newFileName,'');
            unlink($srcFile);
            return ''.$_POST['folder'].'/640x'.((640*$height)/$width).'_art_'.$newFileName;
        }
    }

    private function createThumbImageFromOriginalImage($src,$newWidth,$newHeight,$realPath,$newFileName,$path){
        list($width, $height) = getimagesize($src);
        $thumb = imagecreatetruecolor($newWidth,$newHeight);
        $source = imagecreatefromstring( file_get_contents( $realPath ) );
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth,$newHeight, $width, $height);
        imagepng( $thumb,(realpath('uploads/'.$_POST['folder']).'/'.$path.'/'.$newWidth.'x'.$newHeight.'_art_'.$newFileName.''));
    }

    private function png2jpg($originalFile, $outputFile, $quality) {
        $image = imagecreatefrompng($originalFile);
        imagejpeg($image, $outputFile, $quality);
        imagedestroy($image);
    }

    private function generateSecret($userId_,$length_,$salt_){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length_; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString.$salt_.base64_encode($userId_);
    }
}