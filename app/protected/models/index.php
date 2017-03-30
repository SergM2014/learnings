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


     public function getSearchResults()
     {
         $search = $_POST['searchField'];

        $sql =" SELECT `l`.`id`, `l`.`title` FROM `lessons` `l`
                WHERE MATCH (`l`.`title`) AGAINST (? IN BOOLEAN  MODE) LIMIT 0,7";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, "$search*", \PDO::PARAM_INT);
        $stmt->execute();
        $searchResults = $stmt->fetchAll();

        return $searchResults;
     }



 }
