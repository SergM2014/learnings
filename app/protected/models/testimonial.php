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

    public function saveTestimonial( $testimonial)
    {
        $sql ="INSERT INTO `testimonials` (`testimonial`, `user_id`, `published`, `changed`) VALUES (?, ?, '0', '0')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $testimonial, \PDO::PARAM_STR);
        $stmt->bindValue(2, $_SESSION['user']['id'], \PDO::PARAM_INT);
        $stmt->execute();
    }




}