<?php

namespace App\Models;

use App\Core\DataBase;
use Lib\LangService;
use function  categoryHasLessons;
use function  categoryDeleted;

class Category extends DataBase
{


    public static function getAll()
    {
        $sql= "SELECT `c`.`id`, `c`.`title`, COUNT(`s`.`id`) AS `count_series` FROM `categories` `c` LEFT JOIN `series` `s` ON `c`.`id` = `s`.`category_id` GROUP BY `c`.`id`";
        $stmt = self::conn()->query($sql);
        $result = $stmt->fetchAll();

        return $result;
    }

    public static function getOneCategory()
    {
        $id = $_GET['id'];

        $sql= "SELECT `c`.`id`, `c`.`title`, COUNT(`s`.`id`) AS `count_series` FROM `categories` `c` LEFT JOIN `series` `s`
                ON `c`.`id` = `s`.`category_id`  WHERE `c`.`id`=?  GROUP BY `c`.`id`";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result;
    }

    public static function getAmountOfExtraLessons($categoryId = null )
    {
        $id = $categoryId?? $_GET['id'];
        $sql= "SELECT COUNT(`id`) AS `number` FROM `lessons` WHERE `serie_id` IS NULL AND `category_id`=? GROUP BY `category_id`";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchColumn();

        return $result;
    }

    public static function getSeriesWithLessons()
    {
        $id = $_GET['id'];
        $sql = "SELECT `s`.`id`, `s`.`title`, `s`.`icon`, `s`.`upgrading_skill`, COUNT(`l`.`id`) AS `lessons_count` 
                FROM `series` `s` LEFT JOIN `lessons` `l` ON `s`.`id`= `l`.`serie_id` WHERE `s`.`category_id`=? GROUP BY `s`.`id`";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function getExtraLessons($categoryId = null )
    {
        $id = $categoryId?? $_GET['id'];
        $sql = "SELECT `id`, `title`, `icon`, `file`, `free_status` FROM `lessons` WHERE  `category_id`=? AND `serie_id` IS NULL";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function getOneSimplifiedCategory()
    {
        $id = $_GET['id']?? @$_POST['categoryId'];

        $sql= "SELECT `id`, `title` FROM `categories`  WHERE `id`= ? ";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result;
    }


    public static function saveCategory($title)
    {
        $translitedInLatin= LangService::translite_in_Latin($title);

        $sql = "INSERT INTO `categories` ( `title`, `eng_translit_title`) VALUES(?, ?)";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $title, \PDO::PARAM_STR);
        $stmt->bindValue(2, $translitedInLatin, \PDO::PARAM_STR);

        $stmt->execute();

    }

    public static function updateCategory($title)
    {
        $translitedInLatin= LangService::translite_in_Latin($title);

        $sql = "UPDATE `categories` SET  `title`=?, `eng_translit_title`= ? WHERE `id`=?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $title, \PDO::PARAM_STR);
        $stmt->bindValue(2, $translitedInLatin, \PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['categoryId'], \PDO::PARAM_INT);

        $stmt->execute();
    }


    public static function delete()
    {
        $sql = "SELECT COUNT(`id`) FROM `lessons` WHERE `category_id` = ?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();
        $foundedLessons = (int)$stmt->fetchColumn();

        $sql = "SELECT COUNT(`id`) FROM `series` WHERE `category_id` = ?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();
        $foundedSeries = (int)$stmt->fetchColumn();


        if($foundedSeries >0 ) {
            $response= ["message"=> categoryHasSeries() , "fail"=> true, "categoryId"=> (int)$_POST['id'] ];
            return $response;
        }


        if($foundedLessons >0 ) {
            $response= ["message"=> categoryHasLessons() , "fail"=> true, "categoryId"=> (int)$_POST['id'] ];
            return $response;
        }


        if(DEBUG_MODE){
            $response= ["message"=> categoryDeleted() , "success"=> true, "categoryId"=> (int)$_POST['id'] ];
            return $response;
        }

        if($foundedLessons === 0 OR $foundedSeries === 0 ){
            $sql = "DELETE FROM `categories` WHERE `id`= ?";
            $stmt = self::conn()->prepare($sql);
            $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
            $stmt->execute();
            $response= ["message"=> categoryDeleted() , "success"=> true, "categoryId"=> (int)$_POST['id'] ];
            return $response;
        }


        $response= ["message"=> smthWentWrong() , "fail"=> true, "categoryId"=> (int)$_POST['id'] ];
        return $response;
    }


}