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
        $tmp_path= PATH_SITE.UPLOAD_FOLDER.'tmp/';

        $error =  $this->checkUploadFileErrors();
        if(!empty($error)) return $error;

        $name = $this->resizeImage($_FILES['file'], $tmp_path, AVATAR_IMAGES_H);

        // Загрузка файла и вывод сообщения
        if(!@copy($tmp_path.$name, $path.$name)) {
            return $response =["message"=>"<span class='image-upload--failed'>". smthIsWrong()." </span>", "error" => true];
        }
        else {
            $_SESSION['avatar'] = $name;

            $response=["message"=>"<span class='image-upload--succeded'>".succeededUpload()."</span>", "success"=>true, "image"=> @$_SESSION[$_POST['action']]];
            chmod ($path.$name , 0777);
        }
        // Удаляем временный файл a
        unlink(PATH_SITE.UPLOAD_FOLDER.'tmp/' . $name);

        return $response;
    }





    public function deleteAvatar ()
    {
        if ($_POST['deleteAvatarInSession'] == true) {
//var_dump($_SESSION);
            $_SESSION['avatar'] = 'delete';
var_dump($_SESSION['avatar']);
            return;
        }

        $avatar = @ $_SESSION['avatar'];
        @ unlink ( PATH_SITE.UPLOAD_FOLDER.'avatars/'.$_SESSION['avatar']);
        unset ( $_SESSION['avatar']);
        $response= ["message"=>"<span class='image-delete--succeded'>". fileDeleted() ."</span>", "image"=> $avatar];

        return $response;
    }






}