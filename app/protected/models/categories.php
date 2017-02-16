<?php

namespace App\Models;

use App\Core\DataBase;

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

    public function getAmountOfExtraLessons()
    {
        $id = $_GET['id'];
        $sql= "SELECT COUNT(`id`) AS `number` FROM `lessons` WHERE `series_id` IS NULL AND `category_id`=? GROUP BY `category_id`";
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
                FROM `series` `s` LEFT JOIN `lessons` `l` ON `s`.`id`= `l`.`series_id` WHERE `s`.`category_id`=? GROUP BY `s`.`id`";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getExtraLessons()
    {
        $id = $_GET['id'];
        $sql = "SELECT `id`, `title`, `icon`, `link`, `free_status` FROM `lessons` WHERE  `category_id`=? AND `series_id` IS NULL";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }


}