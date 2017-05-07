<?php

namespace App\Models;

use App\Core\DataBase;
use Lib\LangService;

class Category extends DataBase
{


    public function getAll()
    {
        $sql= "SELECT `c`.`id`, `c`.`title`, COUNT(`s`.`id`) AS `count_series` FROM `categories` `c` LEFT JOIN `series` `s` ON `c`.`id` = `s`.`category_id` GROUP BY `c`.`id`";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getOneCategory()
    {
        $id = $_GET['id'];

        $sql= "SELECT `c`.`id`, `c`.`title`, COUNT(`s`.`id`) AS `count_series` FROM `categories` `c` LEFT JOIN `series` `s`
                ON `c`.`id` = `s`.`category_id`  WHERE `c`.`id`=?  GROUP BY `c`.`id`";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result;
    }

    public function getAmountOfExtraLessons($categoryId = null )
    {
        $id = $categoryId?? $_GET['id'];
        $sql= "SELECT COUNT(`id`) AS `number` FROM `lessons` WHERE `serie_id` IS NULL AND `category_id`=? GROUP BY `category_id`";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchColumn();

        return $result;
    }

    public function getSeriesWithLessons()
    {
        $id = $_GET['id'];
        $sql = "SELECT `s`.`id`, `s`.`title`, `s`.`icon`, `s`.`upgrading_skill`, COUNT(`l`.`id`) AS `lessons_count` 
                FROM `series` `s` LEFT JOIN `lessons` `l` ON `s`.`id`= `l`.`serie_id` WHERE `s`.`category_id`=? GROUP BY `s`.`id`";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getExtraLessons($categoryId = null )
    {
        $id = $categoryId?? $_GET['id'];
        $sql = "SELECT `id`, `title`, `icon`, `file`, `free_status` FROM `lessons` WHERE  `category_id`=? AND `serie_id` IS NULL";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getOneSimplifiedCategory()
    {
        $id = $_GET['id']?? @$_POST['categoryId'];

        $sql= "SELECT `id`, `title` FROM `categories`  WHERE `id`= ? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result;
    }


    public function saveCategory($title)
    {
        $translitedInLatin= LangService::translite_in_Latin($title);

        $sql = "INSERT INTO `categories` ( `title`, `eng_translit_title`) VALUES(?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $title, \PDO::PARAM_STR);
        $stmt->bindValue(2, $translitedInLatin, \PDO::PARAM_STR);

        $stmt->execute();

    }

    public function updateCategory($title)
    {
        $translitedInLatin= LangService::translite_in_Latin($title);

        $sql = "UPDATE `categories` SET  `title`=?, `eng_translit_title`= ? WHERE `id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $title, \PDO::PARAM_STR);
        $stmt->bindValue(2, $translitedInLatin, \PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['categoryId'], \PDO::PARAM_INT);

        $stmt->execute();
    }


}