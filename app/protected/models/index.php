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

        $sql =" SELECT `l`.`id`, `l`.`title`, `c`.`title` AS `category_title`, `s`.`title` AS `serie_title` 
                FROM `lessons` `l` JOIN `categories` `c` ON `l`.`category_id` = `c`.`id`
                JOIN `series` `s` ON  `l`.`serie_id` = `s`.`id`
                WHERE MATCH (`l`.`title`) AGAINST (:search IN BOOLEAN  MODE)  OR MATCH(`c`.`title`) AGAINST (:search IN BOOLEAN MODE)
                 OR MATCH (`s`.`title`)  AGAINST (:search IN BOOLEAN MODE) LIMIT 0,7";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':search',  "$search*", \PDO::PARAM_STR);

        $stmt->execute();
        $searchResults = $stmt->fetchAll();

        return $searchResults;
     }



 }
