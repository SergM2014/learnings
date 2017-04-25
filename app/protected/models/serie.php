<?php

namespace App\Models;

use App\Core\DataBase;

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

    public function printOutSerieTreeMenu()
    {
        $print = '';
        $categories = $this->getAllSeries();
        foreach ($categories as $category){
            $print.= "<li data-category-id= {$category->category_id}><span class='category-item tree-branch'>{$category->category_title}</span>";
            $ids = explode(',', $category->serie_ids);
            $titles = explode(',', $category->serie_titles);
            $length = count($ids);

            if($ids){
                $print.= "<ul>";
                for($i=0; $i<$length; $i++){
                    $print.= "<li data-serie-id={$ids[$i]}><span class='serie-item tree-branch'>{$titles[$i]}</span></li>";
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


}