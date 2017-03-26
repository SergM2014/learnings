<?php

namespace App\Models;

use App\Core\DataBase;

class Serie extends DataBase
{

    public function getSerieLessons()
    {
        $sql = "SELECT `id`, `title`, `icon`, `serie_id`, `category_id`, `file`, `free_status` FROM `lessons` WHERE `serie_id`= ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_GET['id'], \PDO::PARAM_INT);
        $stmt->execute();

        $lessons = $stmt->fetchAll();

        return $lessons;
    }

    public function getSerieLessonsAmount()
    {
        $sql = "SELECT COUNT(`id`) FROM `lessons` WHERE `serie_id`= ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_GET['id'], \PDO::PARAM_INT);
        $stmt->execute();

        $lessonsAmount = $stmt->fetchColumn();

        return $lessonsAmount;
    }

    /**
     * return categoryId value from array of lessons
     *
     * @param $array
     * @return mixed
     */
    public function  getCategoryId($array)
    {
        $categoryId = $array[0]->category->id;
        return $categoryId;
    }


}