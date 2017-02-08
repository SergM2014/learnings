<?php

namespace App\Models;

use App\Core\DataBase;

class Lesson extends DataBase
{

    public function getAll()
    {
        $sql= "SELECT `id`, `title`, `icon`, `series_id`, `link`, `free_status` FROM `lessons`";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetchAll();

        return $result;

    }

    public function getRandomItems($number = 12)
    {
        $items = $this->getAll();

       return $this->getAccidentalItems($number, $items);
    }


}