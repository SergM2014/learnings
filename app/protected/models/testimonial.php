<?php

namespace App\Models;

use App\Core\DataBase;

use function \testimonialIsPublished;
use function \testimonialIsUnpublished;
use function \yes;
use function \no;

class Testimonial extends DataBase
{

    protected static function getOrder()
    {
        $order = '';

        switch(@$_GET['order']){
            case 'new_first':
                    $order = ' ORDER BY `t`.`added_at` DESC ';
                break;

            case 'old_first':
                $order = ' ORDER BY `t`.`added_at` ASC ';
                break;

            case 'AZ':
                $order = ' ORDER BY `u`.`login` DESC ';
                break;

            case 'ZA':
                $order = ' ORDER BY `u`.`login` ASC ';
                break;

            default :
                $order = ' ORDER BY `t`.`added_at` DESC ';
        }

        return $order;
    }

    public static function getAll($admin= false)
    {
        $order = self::getOrder();

        if($admin) {$constraint = ''; } else {$constraint = " WHERE `t`.`published`= '1' "; }

        $sql= "SELECT `t`.`id`, `u`.`login`, `u`.`avatar`, `t`.`testimonial`, `t`.`published`, `t`.`changed`, `t`.`added_at`  FROM `testimonials` `t`
                LEFT JOIN `users` `u` ON `t`.`user_id`= `u`.`id` $constraint $order ";
        $stmt = self::conn()->query($sql);
        $result = $stmt->fetchAll();

        return $result;

    }

    public static function getRandomItems($number = 6)
    {
        $items = self::getAll();

        return self::getAccidentalItems($number, $items);
    }

    public static function saveTestimonial( $testimonial)
    {
        $sql ="INSERT INTO `testimonials` (`testimonial`, `user_id`, `published`, `changed`) VALUES (?, ?, '0', '0')";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $testimonial, \PDO::PARAM_STR);
        $stmt->bindValue(2, $_SESSION['user']['id'], \PDO::PARAM_INT);
        $stmt->execute();
    }


    public static function countPages($admin = false)
    {
        $amountOnPage = @$admin ? AMOUNTONPAGEADMIN : AMOUNTONPAGE;
        $sql = "SELECT COUNT(`id`) FROM `testimonials`";
        $stmt = self::conn()->query($sql);
        $result = $stmt->fetchColumn();
        $pages = ceil($result / $amountOnPage);

        return $pages;

    }

    public static function getOneTestimonial()
    {
        $id= $_GET['id']?? $_POST['testimonialId'];

        $sql= "SELECT `t`.`id`, `u`.`login`, `u`.`avatar`, `t`.`testimonial`, `t`.`published`, `t`.`changed`, `added_at`  FROM `testimonials` `t`
                LEFT JOIN `users` `u` ON `t`.`user_id`= `u`.`id` WHERE `t`.`id` = ?  ";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt ->execute();
        $testimonial = $stmt->fetch();
//for radio input published/unpublished
        if(isset($_POST['published'])) $testimonial->published = $_POST['published'];

        return $testimonial;
    }

    public static function updateTestimonial($testimonial)
    {
        $sql = "UPDATE  `testimonials` SET `testimonial`=?, `published`=?, `changed` = '1' WHERE `id` = ? ";
        $stmt = self::conn()->prepare($sql);
        $stmt -> bindValue(1, $_POST['testimonial'], \PDO::PARAM_STR);
        $stmt -> bindValue(2, $_POST['published'], \PDO::PARAM_INT);
        $stmt -> bindValue(3, $_POST['testimonialId'], \PDO::PARAM_INT);
        $stmt -> execute();

    }


    public static function publish()
    {
        $sql = "UPDATE `testimonials` SET `published`= '1'  WHERE `id`=?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();

        $response= ["message"=> testimonialIsPublished() , "success"=> true, "testimonialId"=> (int)$_POST['id'], "response"=>yes() ];

        return $response;
    }


    public static function unpublish()
    {
        $sql = "UPDATE `testimonials` SET `published`= '0'  WHERE `id`= ?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();

        $response= ["message"=> testimonialIsUnpublished() , "success"=> true, "testimonialId"=> (int)$_POST['id'], "response" =>no() ];

        return $response;
    }
}