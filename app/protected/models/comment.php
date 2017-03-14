<?php

namespace App\Models;

use App\Core\DataBase;

class Comment extends DataBase
{


    public function getCommentsOfOneLesson()
    {
        $id= $_GET['id'];
        $sql= "SELECT `id`, `comment`, `user_id` FROM `comments` WHERE `lesson_id`= ? AND `published`='1'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    public function saveComment($comment)
    {
        $sql = "INSERT INTO `comments` (`comment`, `lesson_id`, `user_id`) VALUES(?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $comment, \PDO::PARAM_STR);
        $stmt->bindValue(2, $_POST['lessonId'], \PDO::PARAM_INT);
        $stmt->bindValue(3, $_SESSION['user']['id'], \PDO::PARAM_INT);

        if($stmt->execute()) return true;
        return false;
    }




}