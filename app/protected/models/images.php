<?php

namespace App\Models;


use App\Core\Prozess_Image;

use function  \succeeded_upload;
use function \smth_is_wrong;
use function \file_deleted;

class Images extends Prozess_Image
{

    public function uploadImage(){

        $path = PATH_SITE.UPLOAD_FOLDER.PRODUCTS_IMAGES;

        $thumb_path= PATH_SITE.UPLOAD_FOLDER.PRODUCTS_IMAGES_THUMBS;

        $error =  $this->checkUploadFileErrors();
        if(!empty($error)) return $error;

            $name = $this->resizeImage($_FILES['file'], $thumb_path, PRODUCT_IMAGES_H);

            if(!@copy($_FILES['file']['tmp_name'], $path.$name)) {
                return $response =["message"=>"<span class='image-upload--failed'>". smth_is_wrong()." </span>", "error" => true];
            }
            else {
                $_SESSION['images'][] = $name;

                $response=["message"=>"<span class='image-upload--succeded'>".succeeded_upload()."</span>", "success"=>true, "image"=>$name,'path'=>'/public'.UPLOADS.PRODUCTS_IMAGES_THUMBS ];
                chmod ($path.$name , 0777);
            }



        return $response;
    }



/*    public function deleteImage()
    {
        $avatar = @ $_SESSION['image'];
        @ unlink ( PATH_SITE.UPLOAD_FOLDER.'productsImages/'.$_SESSION['image']);
        @ unlink ( PATH_SITE.UPLOAD_FOLDER.'productsImages/thumbs/'.$_SESSION['image']);
        unset ( $_SESSION['image']);
        $response= ["message"=>"<span class='image-delete--succeded'>". file_deleted() ."</span>", "image"=> $avatar];

        return $response;
    }*/







}