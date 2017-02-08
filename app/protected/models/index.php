<?php

namespace App\Models;

use App\Core\DataBase;
use Gregwar\Captcha\CaptchaBuilder;



 class Index extends DataBase
 {



     public function printCaptcha()
     {
         $builder = new CaptchaBuilder;
         $builder->build();
         $_SESSION['phrase'] = $builder->getPhrase();
         return $builder;
     }

     public function getPlanDescription($language)
     {
         $sql = "SELECT plan_description_$language FROM background";
         $stmt = $this->conn->query($sql);
         $planDescription = $stmt->fetchColumn();
         return $planDescription;
     }



 }
