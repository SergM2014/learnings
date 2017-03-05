<?php

namespace App\Core\HihgLevelDependacy;


use function \restrictedFileType;
use function \tooBigFile;

class Prozess_Image
{
    protected function resizeImage($file, $thumb_path, $height, $width = null)
    {

        $file['name'] = strtolower($file['name']);
        $arr = explode('.', $file['name']);
        $file['name'] = $arr[0].'_'.time().'.'.$arr[1];


        // Качество изображения по умолчанию
        $quality = 75;

        // Cоздаём исходное изображение на основе исходного файла
        if ($file['type'] == 'image/jpeg')
            $source = imagecreatefromjpeg($file['tmp_name']);
        elseif ($file['type'] == 'image/png')
            $source = imagecreatefrompng($file['tmp_name']);
        elseif ($file['type'] == 'image/gif')
            $source = imagecreatefromgif($file['tmp_name']);
        else
            return false;

        // Определяем ширину и высоту изображения
        $w_src = imagesx($source);
        $h_src = imagesy($source);

        $h = $height;

        $w = $width;

        $baseOriginSide = $h_src;
        $baseThumbSide = $h;


        if($w) {
            $correlation = $w / $h;

            $baseOriginSide = $correlation > 2.5 ? $w_src : $h_src;
            $baseThumbSide = $correlation > 2.5 ? $w : $h;
        }

        if($baseOriginSide >$baseThumbSide){

            // Вычисление пропорций відносно оригінального розміру і розміру мініатюри
            $ratio = $baseOriginSide/$baseThumbSide;

            $w_dest = round($w_src / $ratio);
            $h_dest = round($h_src / $ratio);

            // Создаём пустую картинку
            $dest = imagecreatetruecolor($w_dest, $h_dest);

            // Копируем старое изображение в новое с изменением параметров
            imagecopyresampled($dest, $source, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);

            // Вывод картинки и очистка памяти
            imagejpeg($dest, $thumb_path. $file['name'], $quality);
            imagedestroy($dest);
            imagedestroy($source);
            chmod ($thumb_path . $file['name'] , 0777);

            return $file['name'];
        } else {
            // Вывод картинки и очистка памяти
            //output image into browser or file
            imagejpeg($source, $thumb_path. $file['name'], $quality);
            imagedestroy($source);
            chmod ($thumb_path . $file['name'] , 0777);

            return $file['name'];
        }
    }


    protected function checkUploadFileErrors()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST' OR !in_array(strtolower($_FILES['file']['type']), IMAGE_TYPES))

            return $response =["message"=>"<span class='image-upload--failed'>".restrictedFileType(). "</span>", "error"=>true];

        // Проверяем размер файла
        if ($_FILES['file']['size'] > IMAGE_SIZE)

            return $response =["message"=>"<span class='image-upload--failed'>". tooBigFile().$_FILES['file']['size']."</span>", "error" => true];
    }







}