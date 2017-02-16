<?php

namespace App\Models;

use App\Core\DataBase;

class Comment extends DataBase
{


    public function getCommentsOfOneLesson()
    {
        $id= $_GET['id'];
        $sql= "SELECT `id`, `avatar_path`, `comment`, `user_id` FROM `comments` WHERE `lesson_id`= ? AND `published`='1'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }




}