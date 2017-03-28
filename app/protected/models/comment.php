<?php

namespace App\Models;



use App\Core\DataBase;
use function \responsegivvenComment;

class Comment extends DataBase
{
    public $commentsOfLesson;

    public function __construct()
    {
        parent::__construct();
        if(@$_GET['id']){
            $id= $_GET['id'];
            $sql= "SELECT `c`.`id`, `c`.`comment`, `c`.`parent_id`, `c`.`user_id`, `c`.`added_at`, `u`.`avatar`, `u`.`login` FROM 
            `comments` `c` JOIN `users` `u` ON `u`.`id` = `c`.`user_id` WHERE `c`.`lesson_id`= ? AND `c`.`published`='1' GROUP BY `c`.`id`";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $id, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll();

            $this->commentsOfLesson = $result;


        }


    }


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
        $sql = "INSERT INTO `comments` (`comment`, `lesson_id`,`parent_id`, `user_id`) VALUES(?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $comment, \PDO::PARAM_STR);
        $stmt->bindValue(2, $_POST['lessonId'], \PDO::PARAM_INT);
        $stmt->bindValue(3, $_POST['parentId'], \PDO::PARAM_INT);
        $stmt->bindValue(4, $_SESSION['user']['id'], \PDO::PARAM_INT);

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


    /**
     * bild tree structure of comments
     *
     * @param int $parent
     * @return string
     */
    public function getCommentsTreeStructure($parent = 0)
    {
        //translation of
        $responseGivvencomment = responseGivvenComment();
        $print ='';

        foreach($this->commentsOfLesson as $comment){
            if($comment->parent_id == $parent){

                $avatarImg = $comment->avatar? '/uploads/avatars/'.$comment->avatar : '/img/noavatar.jpg';

                $print.= "<li><article ='lesson-comments__article'>";
                $print.= "<img class='lesson-comments__avatar' src='{$avatarImg}' alt=''>";
                $print.= "<span class='lesson-comments__login'> {$comment->login} </span>";
                $print.= "<time class='lesson-comments__time'>{$comment->added_at}</time>";
                $print.= "<div class='lesson-comments__text'>{$comment->comment}</div>";

                if(loggedInUser()){
                    $print .= "<div class='lesson-comments__response-link-container'>
                        <a href='#addComment' class='lesson-comments__response-link-btn' data-comment-id='{$comment->id}' >{$responseGivvencomment}</a>
                    </div>";
                }
                foreach( $this->commentsOfLesson as $subComment){
                    if($subComment->parent_id == $comment->id){ $flag = true; break; }
                }

                if( isset($flag) ){
                    $print.= "<ul class='lesson-comments__children-container'>";
                    $print.= $this->getCommentsTreeStructure($comment->id);
                    $print.= "</ul>";
                    $print.= "</article></li>";
                    $flag = null;
                } else {
                    $print.= "</article></li>";
                }

            }
        }
        return $print;
    }




}