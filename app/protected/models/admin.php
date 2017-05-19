<?php

namespace App\Models;



use App\Core\DataBase;
use function \userDeleted;
use function \smthWentWrong;

class AdminModel extends DataBase
{



    public static function getAdminUser( )
    {
        if (@!$_POST['login'] OR @!$_POST['password']) return;
        $sql = "SELECT `login` , `password`, `upgrading_status`, `token` FROM `admins` WHERE `login`= ? ";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $_POST['login'], \PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        if (password_verify($_POST['password'], @$user->password)) {
            $_SESSION['admin']['login'] = $user->login;
            $_SESSION['admin']['upgrading_status'] = $user->upgrading_status;
            $_SESSION['admin']['token'] = $user->token;
        }
    }


    public static function getTableCounter()
    {
        $p = $_GET['p']?? 1;
        $start = ($p-1)*AMOUNTONPAGEADMIN+1;
        return $start;
    }


    public static function all()
    {
        $sql= "SELECT `id`, `avatar`, `login`, `email`, `role_title`, `upgrading_status`, `token` FROM `admins` ORDER BY `upgrading_status` DESC";
        $stmt = self::conn()->query($sql);
        $users = $stmt->fetchAll();

        return $users;
    }


    public static function getOneUser()
    {
        $id = $_GET['id']?? @$_POST['userId'];
        $sql= "SELECT `id`, `avatar`, `login`, `email`, `role_title`, `upgrading_status`, `token` FROM `admins` WHERE `id`= ?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch();

        if(isset($_POST['role'])) { $user->upgrading_status = $_POST['role']; }

        return $user;

    }


    public static function updateUser(array $input)
    {
        extract($input);

        $sql = "UPDATE `admins` SET `login`= ?, `email`= ?  WHERE `id`= ?";
        $stmt =self::conn()->prepare($sql);
        $stmt->bindValue(1, $login, \PDO::PARAM_STR);

        $stmt->bindValue(2, $_POST['email'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['userId'], \PDO::PARAM_INT);


        if(!$stmt->execute()) return  false;

        if($_POST['password'] !=''){

            $password= password_hash($password, PASSWORD_DEFAULT);

            $sql = "UPDATE `users` SET `password` = ? ";
            $stmt = self::conn()->prepare($sql);
            $stmt->bindValue(1, $password, \PDO::PARAM_INT);

            if(!$stmt->execute()) return  false;
        }


        if(@$_SESSION['avatar']){
            if($_SESSION['avatar'] == 'delete') $_SESSION['avatar'] = null;
            $sql = "UPDATE `admins` SET `avatar` = ? WHERE `id`= ?";
            $stmt = self::conn()->prepare($sql);
            $stmt->bindValue(1, $_SESSION['avatar'], \PDO::PARAM_STR);
            $stmt->bindValue(2, $_POST['userId'], \PDO::PARAM_INT);
            if( $stmt->execute()) unset($_SESSION['avatar']);
        }

    }


    public static function delete()
    {
        if(DEBUG_MODE){
            $response= ["message"=> userDeleted() , "success"=> true, "userId"=> (int)$_POST['id'] ];
            return $response;
        }

        $sql = "DELETE FROM `admins` WHERE `id` = ?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        if($stmt->execute())  {
            $response= ["message"=> userDeleted() , "success"=> true, "userId"=> (int)$_POST['id'] ];
            return $response;
        }

        $response= ["message"=> smthWentWrong() , "fail"=> true, "userId"=> (int)$_POST['id'] ];
        return $response;
    }



}