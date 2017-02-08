<?php

namespace App\Models;

use App\Core\DataBase;

class Testemonial extends DataBase
{

    public function getAll()
    {
        $sql= "SELECT `id`, `testimonial`, `user_id` FROM `testimonials` ";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetchAll();

        return $result;

    }

    public function getRandomItems($number = 6)
    {
        $items = $this->getAll();

        return $this->getAccidentalItems($number, $items);
    }


}