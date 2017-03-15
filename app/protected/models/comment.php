<?php

namespace App\Models;



use App\Core\DataBase;


class Comment extends DataBase
{


    public function getCommentsOfOneLesson()
    {
        $id= $_GET['id'];
        $sql= "SELECT `c`.`id`, `c`.`comment`, `c`.`user_id`, `c`.`added_at`, `u`.`avatar`, `u`.`login` FROM 
          `comments` `c` JOIN `users` `u` ON `u`.`id` = `c`.`user_id` WHERE `c`.`lesson_id`= ? AND `c`.`published`='1'";
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

    public function getOneComment()
    {
        $sql= "SELECT `c`.`id`, `c`.`comment`, `c`.`user_id`, `c`.`added_at`, `u`.`avatar`, `u`.`login` FROM 
          `comments` `c` JOIN `users` `u` ON `u`.`id` = `c`.`user_id` WHERE `c`.`id`= ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['commentId'], \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }




}