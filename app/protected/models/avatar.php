<?php

namespace App\Models;

use App\Core\Prozess_Image;

use function \succeeded_upload;
use function \smth_is_wrong;
use function \file_deleted;

class Avatar extends Prozess_Image
{

    public function uploadAvatar(){

        $path = PATH_SITE.UPLOAD_FOLDER.AVATARS_IMAGES;
        $tmp_path= PATH_SITE.UPLOAD_FOLDER.'tmp/';

        $error =  $this->checkUploadFileErrors();
        if(!empty($error)) return $error;

            $name = $this->resizeImage($_FILES['file'], $tmp_path, AVATAR_IMAGES_H);

            // Загрузка файла и вывод сообщения
            if(!@copy($tmp_path.$name, $path.$name)) {
                return $response =["message"=>"<span class='avatar-upload--failed'>". smth_is_wrong()." </span>", "error" => true];
            }
            else {

                $_SESSION[$_POST['action']]= $name;


                $response=["message"=>"<span class='avatar-upload--succeded'>".succeeded_upload()."</span>", "success"=>true, "bild"=> $_SESSION[$_POST['action']]];
                chmod ($path.$name , 0777);
            }
            // Удаляем временный файл a
            unlink(PATH_SITE.UPLOAD_FOLDER.'tmp/' . $name);


        return $response;
    }





    public function deleteAvatar()
    {
        $avatar = @ $_SESSION['avatar'];
        @ unlink ( PATH_SITE.UPLOAD_FOLDER.'avatars/'.$_SESSION['avatar']);
        unset ( $_SESSION['avatar']);
        $response= ["message"=>"<span class='avatar-delete--succeded'>". file_deleted() ."</span>", "bild"=> $avatar];

        return $response;
    }







}