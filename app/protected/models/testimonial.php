<?php

namespace App\Models;

use App\Core\DataBase;

class Testimonial extends DataBase
{

    public function getAll()
    {
        $sql= "SELECT `t`.`id`, `u`.`login`, `u`.`avatar`, `t`.`testimonial`, `t`.`added_at`  FROM `testimonials` `t`
                LEFT JOIN `users` `u` ON `t`.`user_id`= `u`.`id` WHERE `t`.`published`= '1' ";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetchAll();

        return $result;

    }

    public function getRandomItems($number = 6)
    {
        $items = $this->getAll();

        return $this->getAccidentalItems($number, $items);
    }

    public function saveTestimonial()
    {

    }




}