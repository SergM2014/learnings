<?php

namespace App\Models;

use App\Core\DataBase;

class Lesson extends DataBase
{

    public function getAll()
    {
        $sql= "SELECT `id`, `title`, `icon`, `serie_id`, `file`, `free_status` FROM `lessons`";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetchAll();

        return $result;

    }

    public function getRandomItems($number = 12)
    {
        $items = $this->getAll();

       return $this->getAccidentalItems($number, $items);
    }

    public function getRelatedLessons()
    {
        $id = $_GET['id'];

        $sql = "SELECT `category_id`, `serie_id` FROM `lessons` WHERE `id`=?";
        $stmt = $this->conn -> prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        extract($result);

            $sql= "SELECT `id`, `title`, `icon`, `category_id` , `file`, `free_status` FROM `lessons` WHERE `serie_id` =? AND `id`!= ? ORDER BY `id`";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $serie_id, \PDO::PARAM_INT);
            $stmt->bindValue(2, $id, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll();

        $sql= "SELECT `id`, `title`, `icon`, `category_id` , `file`, `free_status` FROM `lessons` WHERE `category_id` =? AND `id`!= ? ORDER BY `id`";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $category_id, \PDO::PARAM_INT);
        $stmt->bindValue(2, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result2 = $stmt->fetchAll();

        $array = array_merge($result, $result2);
        $array = array_unique($array, SORT_REGULAR);

        return $array;
    }


    public function getOneLesson()
    {
        $id = $_GET['id'];
        $sql= "SELECT `id`, `title`, `icon`, `category_id`, `serie_id`, `file`, `free_status` FROM `lessons` WHERE `id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt ->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }


}