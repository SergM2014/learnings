<?php

namespace App\Models;


use App\Core\HihgLevelDependacy\Prozess_Image;

use function  \succeededUpload;
use function \smthIsWrong;
use function \fileDeleted;

class Images extends Prozess_Image
{

    public function uploadAvatar(){

        $path = PATH_SITE.UPLOAD_FOLDER.AVATARS_IMAGES;

        $error =  $this->checkUploadFileErrors();
        if(!empty($error)) return $error;

        $name = $this->resizeImage($_FILES['file'], $path, AVATAR_IMAGES_EXTENT);

        // Загрузка файла и вывод сообщения
        if($name) {
            unset($_FILES['file']);
            $_SESSION['avatar'] = $name;
            $response=["message"=>"<span class='image-upload--succeded'>".succeededUpload()."</span>", "success"=>true, "image"=> @$_SESSION['avatar']];
            chmod ($path.$name , 0777);
        }
        else {
            return $response =["message"=>"<span class='image-upload--failed'>". smthIsWrong()." </span>", "error" => true];
        }

        return $response;
    }


    public function deleteAvatar ()
    {
        $avatar = @ $_SESSION['avatar'];
        //@ unlink ( PATH_SITE.UPLOAD_FOLDER.'avatars/'.$_SESSION['avatar']);
        unset ( $_SESSION['avatar']);
        $response= ["message"=>"<span class='image-delete--succeded'>". fileDeleted() ."</span>", "image"=> $avatar];

        return $response;
    }


    public function uploadLessonIcon(){

        $path = PATH_SITE.UPLOAD_FOLDER.LESSONS_ICONS_IMAGES;


        $error =  $this->checkUploadFileErrors();
        if(!empty($error)) return $error;

        $name = $this->resizeImage($_FILES['file'], $path, ICONS_IMAGES_EXTENT);

        // Загрузка файла и вывод сообщения
        if($name) {
            unset($_FILES['file']);
            $_SESSION['lessonsIcon'] = $name;
            $response=["message"=>"<span class='image-upload--succeded'>".succeededUpload()."</span>", "success"=>true, "image"=> @$_SESSION['lessonsIcon']];
            chmod ($path.$name , 0777);
        }
        else {
            return $response =["message"=>"<span class='image-upload--failed'>". smthIsWrong()." </span>", "error" => true];
        }


        return $response;
    }


    public function deleteLessonsIcon ()
    {
        $avatar = @ $_SESSION['lessonsIcon'];
//@ unlink ( PATH_SITE.UPLOAD_FOLDER.'lessonsIcons/'.$_SESSION['lessonsIcon']);
        unset ( $_SESSION['lessonsIcon']);
        $response= ["message"=>"<span class='image-delete--succeded'>". fileDeleted() ."</span>", "image"=> $avatar];

        return $response;
    }


    public function uploadSerieIcon(){

        $path = PATH_SITE.UPLOAD_FOLDER.SERIES_ICONS_IMAGES;


        $error =  $this->checkUploadFileErrors();
        if(!empty($error)) return $error;

        $name = $this->resizeImage($_FILES['file'], $path, ICONS_IMAGES_EXTENT);

        // Загрузка файла и вывод сообщения
        if($name) {
            unset($_FILES['file']);
            $_SESSION['serieIcon'] = $name;
            $response=["message"=>"<span class='image-upload--succeded'>".succeededUpload()."</span>", "success"=>true, "image"=> @$_SESSION[$_POST['action']]];
            chmod ($path.$name , 0777);
        }
        else {
            return $response =["message"=>"<span class='image-upload--failed'>". smthIsWrong()." </span>", "error" => true];
        }

        return $response;
    }


    public function deleteSerieIcon ()
    {
        $avatar = @ $_SESSION['serieIcon'];
//@ unlink ( PATH_SITE.UPLOAD_FOLDER.'seriesIcons/'.$_SESSION['serieIcon']);
        unset ( $_SESSION['serieIcon']);

        $response= ["message"=>"<span class='image-delete--succeded'>". fileDeleted() ."</span>", "image"=> $avatar];

        return $response;
    }






}