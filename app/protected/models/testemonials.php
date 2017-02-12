<?php

namespace App\Models;

use App\Core\DataBase;

class Testemonial extends DataBase
{

    public function getAll()
    {
        $sql= "SELECT `t`.`id`, `t`.`name`, `t`.`avatar` AS `first_avatar`, `t`.`testimonial`, `t`.`time`, `u`.`avatar`
                      AS `second_avatar`  FROM `testimonials` `t` LEFT JOIN `users` `u` ON `t`.`user_id`= `u`.`id`  ";
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