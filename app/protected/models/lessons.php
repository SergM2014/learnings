<?php

namespace App\Models;

use App\Core\DataBase;
use Lib\CheckFieldsService;
use function \lessonIsDeleted;

class Lesson extends DataBase
{

    use CheckFieldsService;

//    public function getAll($admin = false, $p = 1)
//    {
//        $amountOnPage= @$admin? AMOUNTONPAGEADMIN: AMOUNTONPAGE;
//        $page = $_GET['p']?? $p;
//        $start = ($page-1)*$amountOnPage;
//
//        $sql= "SELECT `id`, `title`, `icon`, `excerpt`, `serie_id`, `file`, `free_status` FROM `lessons` LIMIT ?, ? ";
//        $stmt = $this->conn->prepare($sql);
//        $stmt->bindValue(1, $start, \PDO::PARAM_INT);
//        $stmt->bindValue(2, $amountOnPage, \PDO::PARAM_INT);
//        $stmt->execute();
//        $lessons = $stmt->fetchAll();
//
//        return $lessons;
//    }


    public function getAll($admin = false, $p = 1)
    {
        $amountOnPage= @$admin? AMOUNTONPAGEADMIN: AMOUNTONPAGE;
        $page = $_GET['p']?? $p;
        $start = ($page-1)*$amountOnPage;

        $sql= "SELECT `l`.`id`, `l`.`title`, `l`.`icon`, `l`.`excerpt`, `l`.`serie_id`, `l`.`file`, `l`.`free_status`,
              COUNT(`c`.`id`) AS `comments_number`, `cat`.`title` AS `category_title`, `s`.`title` AS `serie_title` FROM `lessons` `l`
               LEFT JOIN `comments` `c` ON `l`.`id` = `c`.`lesson_id` JOIN `categories` `cat` 
                ON `l`.`category_id`= `cat`.`id` LEFT JOIN `series` `s` ON `l`.`serie_id` = `s`.`id` GROUP BY `l`.`id`  LIMIT ?, ?  ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $start, \PDO::PARAM_INT);
        $stmt->bindValue(2, $amountOnPage, \PDO::PARAM_INT);
        $stmt->execute();
        $lessons = $stmt->fetchAll();

        return $lessons;
    }


    public function countPages($admin = false)
    {
        $amountOnPage= @$admin? AMOUNTONPAGEADMIN: AMOUNTONPAGE;
        $sql= "SELECT COUNT(`id`) FROM `lessons`";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetchColumn();
        $pages = ceil($result/$amountOnPage);

         return $pages;
    }


    public function getRandomItems($number = 12)
    {
        $items = $this->getAll();

       return $this->getAccidentalItems($number, $items);
    }

    public function getRelatedLessons()
    {
        $id = $_GET['id'];

        $sql = "SELECT `category_id`, `serie_id` FROM `lessons` WHERE `id`=?";
        $stmt = $this->conn -> prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        extract($result);

            $sql= "SELECT `id`, `title`, `icon`, `category_id` , `file`, `free_status` FROM `lessons` WHERE `serie_id` =? AND `id`!= ? ORDER BY `id`";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $serie_id, \PDO::PARAM_INT);
            $stmt->bindValue(2, $id, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll();

        $sql= "SELECT `id`, `title`, `icon`, `category_id` , `file`, `free_status` FROM `lessons` WHERE `category_id` =? AND `id`!= ? ORDER BY `id`";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $category_id, \PDO::PARAM_INT);
        $stmt->bindValue(2, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result2 = $stmt->fetchAll();

        $array = array_merge($result, $result2);
        $array = array_unique($array, SORT_REGULAR);

        return $array;
    }


    public function getOneLesson()
    {
        $id =  $_GET['id']?? $_POST['lessonId'];
        $sql= "SELECT `id`, `title`, `icon`, `category_id`, `serie_id`, `excerpt`, `file`, `free_status` FROM `lessons` WHERE `id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt ->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    public function getOneLessonforPreview()
    {
        $id = $_POST['lessonId'];
        $sql= "SELECT `id`, `title`, `icon`,  `excerpt`  FROM `lessons` WHERE `id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt ->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result;
    }


    public function uploadFile()
    {

        $error = $this->checkUploadsFileErrors();

        if($error) return $error;

        $path = PATH_SITE.UPLOAD_FOLDER.LESSONS_FOLDER;


        $newname = $path.$_FILES['downloadFile']['name'];

        move_uploaded_file($_FILES['downloadFile']['tmp_name'], $newname);


        // Загрузка файла и вывод сообщения
        if( file_exists($newname)) {
            $_SESSION['downloadFile'] = $newname;
            $response=["message"=>"<span class='image-upload--succeded'>".succeededUpload()."</span>", "success"=>true, "image"=> @$_SESSION[$_POST['action']]];
            chmod ($newname , 0777);
        }
        else {
            return $response =["message"=>"<span class='image-upload--failed'>". smthIsWrong()." </span>", "error" => true];
        }


        return $response;
    }

    protected function checkUploadsFileErrors()
    {

        if(empty($_FILES) OR $_FILES['downloadFile']['size']== 0  OR $_FILES['downloadFile']['size'] > LESSON_SIZE) return $response =["message"=>"<span class='image-upload--failed'>".  tooBigFile()."</span>", "error" => true];

        if(!is_uploaded_file($_FILES['downloadFile']['tmp_name'])) return $response =["message"=>"<span class='image-upload--failed'>". smthIsWrong()."</span>", "error" => true];

        if (!in_array(strtolower($_FILES['downloadFile']['type']), VIDEO_TYPES))  return $response =["message"=>"<span class='image-upload--failed'>".restrictedFileType(). "</span>", "error"=>true];

        return  null;
    }


    public function deleteFile ()
    {
        if (@$_POST['deleteFile'] == true) {

            $_SESSION['downloadFile'] = 'delete';

            return;
        }

        $file = @ $_SESSION['downloadFile'];
        //@ unlink (ROOT.'uploads/video/'.basename($_SESSION['downloadFile']));
        unset ( $_SESSION['downloadFile']);
        $response= ["message"=>"<span class='image-delete--succeded'>". fileDeleted() ."</span>", "image"=> basename($file)];

        return $response;
    }


    public function saveLesson($excerpt)
    {
        $serieId = is_null($_POST['serie'])? null: (int)$_POST['serie'];

        if($serieId) {
            $this->persistWithSerie($excerpt, $serieId);
        } else {
            $this->persistWithoutSerie($excerpt);
        }

        unset($_SESSION['lessonsIcon']);
        unset($_SESSION['downloadFile']);
    }


    private function persistWithSerie($excerpt, $serieId)
    {

        $inputs = self::escapeInputs('title');

        $sql = "INSERT INTO `lessons`(`title`, `icon`, `category_id`, `serie_id`, `excerpt`, `file`, `free_status`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $inputs['title'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $_SESSION['lessonsIcon'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['category'], \PDO::PARAM_INT);
        $stmt->bindValue(4, $serieId);
        $stmt->bindValue(5, $excerpt, \PDO::PARAM_STR);
        $stmt->bindValue(6, basename($_SESSION['downloadFile']), \PDO::PARAM_STR);
        $stmt->bindValue(7, $_POST['free_status'], \PDO::PARAM_INT);
        $stmt->execute();


    }

    private function persistWithoutSerie($excerpt)
    {
        $inputs = self::escapeInputs('title');

        $sql = "INSERT INTO `lessons`(`title`, `icon`, `category_id`,  `excerpt`, `file`, `free_status`) VALUES (?, ?, ?, ?, ?, ? )";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $inputs['title'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $_SESSION['lessonsIcon'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['category'], \PDO::PARAM_INT);
        $stmt->bindValue(4, $excerpt, \PDO::PARAM_STR);
        $stmt->bindValue(5, basename($_SESSION['downloadFile']), \PDO::PARAM_STR);
        $stmt->bindValue(6, $_POST['free_status'], \PDO::PARAM_INT);
        $stmt->execute();
    }


    public function updateLesson($excerpt)
    {
        $serieId = is_null($_POST['serie'])? null: (int)$_POST['serie'];

        if($serieId) {
            $this->updatetWithSerie($excerpt, $serieId);
        } else {
            $this->updateWithoutSerie($excerpt);
        }

        unset($_SESSION['lessonsIcon']);
        unset($_SESSION['downloadFile']);
    }


    private function updatetWithSerie($excerpt, $serieId)
    {

        $inputs = self::escapeInputs('title');

        $sql = "UPDATE `lessons` SET `title`=?, `icon`=?, `category_id`=?, `serie_id`=?, `excerpt`=?, `file`=?, `free_status`=? WHERE `id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $inputs['title'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $_SESSION['lessonsIcon'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['category'], \PDO::PARAM_INT);
        $stmt->bindValue(4, $serieId);
        $stmt->bindValue(5, $excerpt, \PDO::PARAM_STR);
        $stmt->bindValue(6, basename($_SESSION['downloadFile']), \PDO::PARAM_STR);
        $stmt->bindValue(7, $_POST['free_status'], \PDO::PARAM_INT);
        $stmt->bindValue(8, $_POST['lessonId'], \PDO::PARAM_INT);
        $stmt->execute();

    }


    private function updateWithoutSerie($excerpt)
    {

        $inputs = self::escapeInputs('title');

        $sql = "UPDATE `lessons` SET `title`=?, `icon`=?, `category_id`=?,  `excerpt`=?, `file`=?, `free_status`=? WHERE `id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $inputs['title'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $_SESSION['lessonsIcon'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['category'], \PDO::PARAM_INT);

        $stmt->bindValue(4, $excerpt, \PDO::PARAM_STR);
        $stmt->bindValue(5, basename($_SESSION['downloadFile']), \PDO::PARAM_STR);
        $stmt->bindValue(6, $_POST['free_status'], \PDO::PARAM_INT);
        $stmt->bindValue(7, $_POST['lessonId'], \PDO::PARAM_INT);
        $stmt->execute();

    }

    public function getFullOneLesson()
    {
        $id =  $_GET['id']?? $_POST['lessonId'];
        $sql= "SELECT `l`.`id`, `l`.`title`, `l`.`icon`, `l`.`category_id`, `l`.`serie_id`, `l`.`excerpt`, `l`.`file`,
              `l`.`free_status`, `c`.`title` AS `category_title` FROM `lessons` `l` JOIN `categories` `c` ON 
              `l`.`category_id`= `c`.`id`   WHERE `l`.`id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt ->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();


        if($result->serie_id){
            $sql = "SELECT `title` AS `serie_title` FROM `series` WHERE `id`= $result->serie_id";
            $stmt= $this->conn->query($sql);
            $stmt->execute();
            $serieTitle = $stmt->fetchColumn();
            $result->serie_title= $serieTitle;
        }


        return $result;
    }


    public function deleteLesson()
    {
        /*$sql= "DELETE FROM `lessons` WHERE `id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();*/
        $response= ["message"=> lessonIsDeleted() , "success"=> true, "lessonId"=> (int)$_POST['id'] ];

        return $response;
    }


}