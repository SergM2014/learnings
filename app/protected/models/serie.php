<?php

namespace App\Models;

use App\Core\DataBase;
use Lib\LangService;

use function serieHasLessons;
use function serieDeleted;
use function smthWentWrong;

class Serie extends DataBase
{

    public function getSerieLessons()
    {
        $sql = "SELECT `id`, `title`, `icon`, `serie_id`, `category_id`, `file`, `free_status` FROM `lessons` WHERE `serie_id`= ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_GET['id'], \PDO::PARAM_INT);
        $stmt->execute();

        $lessons = $stmt->fetchAll();

        return $lessons;
    }

    public function getSerieLessonsAmount()
    {
        $sql = "SELECT COUNT(`id`) FROM `lessons` WHERE `serie_id`= ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_GET['id'], \PDO::PARAM_INT);
        $stmt->execute();

        $lessonsAmount = $stmt->fetchColumn();

        return $lessonsAmount;
    }

    /**
     * return categoryId value from array of lessons
     *
     * @param $array
     * @return mixed
     */
    public function  getCategoryId($array)
    {
        $categoryId = $array[0]->category_id;
        return $categoryId;
    }


    public function getAllSeries()
    {
        $sql= "SELECT GROUP_CONCAT(`s`.`id`) AS `serie_ids`, `s`.`category_id`, GROUP_CONCAT(`s`.`title`) AS `serie_titles`, `c`.`title` AS `category_title`  FROM `series` `s`
                JOIN `categories` `c` ON `s`.`category_id`= `c`.`id` GROUP BY `category_id` ";
        $stmt = $this->conn->query($sql);
        $series = $stmt->fetchAll();

        return $series;
    }

    public function printOutSerieTreeMenu($categoryAndSerieSection = null )
    {
        $identifier = $categoryAndSerieSection? 'data-category-serie-id': 'data-category-id';
        $classIdentifier = $categoryAndSerieSection? 'admin-section': '';

        $print = '';
        $categories = $this->getAllSeries();
        foreach ($categories as $category){
            $print.= "<li $identifier = {$category->category_id}><span class='category-item tree-branch $classIdentifier'>{$category->category_title}</span>";
            $ids = explode(',', $category->serie_ids);
            $titles = explode(',', $category->serie_titles);
            $length = count($ids);

            if($ids){
                $print.= "<ul>";
                for($i=0; $i<$length; $i++){
                    $print.= "<li data-serie-id={$ids[$i]}><span class='serie-item tree-branch $classIdentifier'>{$titles[$i]}</span></li>";
                }
                $print.= "</ul>";
            }

            $print.= "</li>";

        }

        return $print;
    }


    public function printSerieDropDownList()
    {
        $constraint = @$_GET['category_and_serie'];

        $print = '';
        $categories = $this->getAllSeries();
        foreach ($categories as $category) {
            $print .= "<option value='{$category->category_title}'";
            $selected = (@ $constraint  == $category->category_title)? 'selected':'';
            $print .= " $selected >{$category->category_title}</option>";
            $ids = explode(',', $category->serie_ids);
            $titles = explode(',', $category->serie_titles);
            $length = count($ids);

            if ($ids) {
                for ($i = 0; $i < $length; $i++) {
                    $print .= "<option value='{$ids[$i]}'";
                    $selected = (@ $constraint  == $ids[$i])? 'selected' : '';
                    $print .= " $selected >--{$titles[$i]}</option>";
                }
            }
        }


        return $print;

    }


    public function getOneSerie()
    {
        $id= $_POST['serieId']?? $_GET['id'];

        $sql = "SELECT `id`, `category_id`, `title`, `icon`, `upgrading_skill` FROM `series` WHERE `id`=? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $serie = $stmt->fetch();

        return $serie;
    }



    public function updateSerie($title)
    {
        $id = $_POST['serieId'];

        $translitedInLatin= LangService::translite_in_Latin($title);

        $sql = "UPDATE `series` SET `title` = ?, `eng_translit_title`=?, `icon`= ?, `upgrading_skill` = ?  WHERE `id`= ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $title, \PDO::PARAM_STR);
        $stmt->bindValue(2, $translitedInLatin, \PDO::PARAM_STR);
        $stmt->bindValue(3, $_SESSION['serieIcon'], \PDO::PARAM_STR);
        $stmt->bindValue(4,$_POST['upgradingSkill'], \PDO::PARAM_INT);
        $stmt->bindValue(5,$id, \PDO::PARAM_INT);
        $stmt->execute();

        unset($_SESSION['serieIcon']);
    }

    public function delete()
    {
        $sql = "SELECT COUNT(`id`) FROM `lessons` WHERE `serie_id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();
        $foundedLessons = (int)$stmt->fetchColumn();
          if($foundedLessons >0 ) {
              $response= ["message"=> serieHasLessons() , "fail"=> true, "serieId"=> (int)$_POST['id'] ];
              return $response;
          }


        if(DEBUG_MODE){
            $response= ["message"=> serieDeleted() , "success"=> true, "serieId"=> (int)$_POST['id'] ];
            return $response;
        }

          if($foundedLessons === 0 ){
              $sql = "DELETE FROM `series` WHERE `id`= ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
                $stmt->execute();
              $response= ["message"=> serieDeleted() , "success"=> true, "serieId"=> (int)$_POST['id'] ];
              return $response;
          }


        $response= ["message"=> smthWentWrong() , "fail"=> true, "serieId"=> (int)$_POST['id'] ];
        return $response;
    }


    public function saveSerie($title)
    {
        $id = $_POST['parentId'];

        $translitedInLatin= LangService::translite_in_Latin($title);

        $sql = "INSERT INTO `series` (`category_id`, `title`, `eng_translit_title`, `icon`, `upgrading_skill`) VALUES(?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1,$id, \PDO::PARAM_INT);
        $stmt->bindValue(2, $title, \PDO::PARAM_STR);
        $stmt->bindValue(3, $translitedInLatin, \PDO::PARAM_STR);
        $stmt->bindValue(4, $_SESSION['serieIcon'], \PDO::PARAM_STR);
        $stmt->bindValue(5, $_POST['upgradingSkill'], \PDO::PARAM_INT);

        $stmt->execute();

        unset($_SESSION['serieIcon']);
    }

}