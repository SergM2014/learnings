<?php

namespace App\Models;

use App\Core\DataBase;
use Gregwar\Captcha\CaptchaBuilder;



 class DB_Index extends DataBase
 {

    public function getSlider()
    {
        $sql = "SELECT `image`, `url`, `title` FROM `slider`";
        $result = $this->conn->query($sql);
        $carousel = $result->fetchAll();
        return $carousel;
    }

     //get results for carousel
     public function getCarousel()
     {
         $sql = "SELECT `image`, `url` FROM `carousel` ";
         $result = $this->conn->query($sql);
         $carousel = $result->fetchAll();
         return $carousel;

     }

     public function getAboutUsInfo()
     {
        $sql= "SELECT `aboutUs` FROM `background` WHERE `id`= 1";
         $result = $this->conn->query($sql);
         $aboutUs = $result->fetch();

         return $aboutUs->aboutUs;
     }

     public function getDownloads()
     {
         $sql= "SELECT `downloads` FROM `background` WHERE `id` = 1";
         $result = $this->conn->query($sql);
         $result = $result->fetch();

         return $result->downloads;
     }

     public function getContactsInfo()
     {
         $sql= "SELECT `contacts` FROM `background` WHERE `id` = 1";
         $result = $this->conn->query($sql);
         $result = $result->fetch();
         return $result->contacts;
     }

     public function printCaptcha()
     {
         $builder = new CaptchaBuilder;
         $builder->build();
         $_SESSION['phrase'] = $builder->getPhrase();
         return $builder;
     }



 }
