<?php

namespace App\Models;



use App\Core\DataBase;
use function \responsegivvenComment;
use function \commentIsPublished;
use function \commentIsUnpublished;
use function \yes;
use function \no;

class Comment extends DataBase
{
    public $commentsOfLesson;

    public function __construct()
    {

        if(@$_GET['id']){
            $id= $_GET['id'];
            $sql= "SELECT `c`.`id`, `c`.`comment`, `c`.`parent_id`, `c`.`user_id`, `c`.`added_at`, `u`.`avatar`, `u`.`login` FROM 
            `comments` `c` JOIN `users` `u` ON `u`.`id` = `c`.`user_id` WHERE `c`.`lesson_id`= ? AND `c`.`published`='1' GROUP BY `c`.`id`";
            $stmt = self::conn()->prepare($sql);
            $stmt->bindValue(1, $id, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll();

            $this->commentsOfLesson = $result;


        }


    }


    public static function getCommentsOfOneLesson()
    {
        $id= $_GET['id'];
        $sql= "SELECT `c`.`id`, `c`.`comment`, `c`.`user_id`, `c`.`added_at`, `u`.`avatar`, `u`.`login` FROM 
          `comments` `c` JOIN `users` `u` ON `u`.`id` = `c`.`user_id` WHERE `c`.`lesson_id`= ? AND `c`.`published`='1'";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    public static function saveComment($comment)
    {
        $sql = "INSERT INTO `comments` (`comment`, `lesson_id`,`parent_id`, `user_id`) VALUES(?, ?, ?, ?)";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $comment, \PDO::PARAM_STR);
        $stmt->bindValue(2, $_POST['lessonId'], \PDO::PARAM_INT);
        $stmt->bindValue(3, $_POST['parentId'], \PDO::PARAM_INT);
        $stmt->bindValue(4, $_SESSION['user']['id'], \PDO::PARAM_INT);

        if($stmt->execute()) return true;
        return false;
    }

    public static function getOneComment()
    {
        $id= $_POST['commentId']?? @$_GET['id'];

        $sql= "SELECT `c`.`id`, `c`.`comment`, `c`.`user_id`, `c`.`added_at`, `u`.`avatar`, `u`.`login` FROM 
          `comments` `c` JOIN `users` `u` ON `u`.`id` = `c`.`user_id` WHERE `c`.`id`= ?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
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


    public static function getAll($admin = null, $p=1 )
    {
        switch(@$_GET['order']) {
            case 'new_first':
                $order = ' `parent_c`.`added_at` DESC ';
                break;
            case 'old_first':
                $order = ' `parent_c`.`added_at` ASC ';
                break;
            case 'AZ':
                $order = ' `u`.`login` DESC ';
                break;
            case 'ZA':
                $order = ' `u`.`login` DESC ';
                break;
            case 'more_responses':
                $order = ' `most_commented` DESC ';
                break;
            case 'less_responses':
                $order = ' `most_commented` ASC ';
                break;

            default:
                $order = ' `parent_c`.`added_at` DESC ';
        }


        $amountOnPage= @$admin? AMOUNTONPAGEADMIN: AMOUNTONPAGE;
        $page = $_GET['p']?? $p;
        $start = ($page-1)*$amountOnPage;

        $sql= "SELECT `parent_c`.`id`, `u`.`login`, `u`.`avatar`, COUNT(`c`.`id`) AS `most_commented`, `parent_c`.`comment`, 
                `parent_c`.`published`, `parent_c`.`changed`, `parent_c`.`added_at`, `l`.`title`  FROM `comments` `parent_c`
                LEFT JOIN `users` `u` ON `parent_c`.`user_id`= `u`.`id` LEFT JOIN `lessons` `l` ON `l`.`id` = 
                `parent_c`.`lesson_id` LEFT JOIN `comments` `c` ON `c`.`parent_id`= `parent_c`.`id`
                 GROUP BY `parent_c`.`id` ORDER BY $order LIMIT ?, ? ";

        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $start, \PDO::PARAM_INT);
        $stmt->bindValue(2, $amountOnPage, \PDO::PARAM_INT);
        $stmt->execute();
        $comments = $stmt->fetchAll();

        return $comments;

    }

    public static function countPages($admin = false)
    {
        $amountOnPage = @$admin ? AMOUNTONPAGEADMIN : AMOUNTONPAGE;
        $sql = "SELECT COUNT(`id`) FROM `comments`";
        $stmt = self::conn()->query($sql);
        $result = $stmt->fetchColumn();
        $pages = ceil($result / $amountOnPage);

        return $pages;
    }

    public static function updateComment($comment)
    {
        $sql = "UPDATE `comments` SET `comment`= ? , `changed`='1' WHERE `id`= ? ";

        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $comment, \PDO::PARAM_STR );
        $stmt->bindValue(2, $_POST['commentId'], \PDO::PARAM_INT);
        $stmt->execute();

    }


    public static function publish()
    {
        $sql = "UPDATE `comments` SET `published`= '1'  WHERE `id`=?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();

        $response= ["message"=> commentIsPublished() , "success"=> true, "commentId"=> (int)$_POST['id'], "response"=>yes() ];

        return $response;
    }


    public static function unpublish()
    {
        $sql = "UPDATE `comments` SET `published`= '0'  WHERE `id`= ?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();

        $response= ["message"=> commentIsUnpublished() , "success"=> true, "commentId"=> (int)$_POST['id'], "response" =>no() ];

        return $response;
    }




}