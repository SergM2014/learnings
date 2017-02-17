<?php

namespace App\Models;
use App\Core\DataBase;


class SignUp extends DataBase
{
    public function getAdminUser()
    {

        if( @!$_POST['login'] OR !$_POST['password']) return;
        $sql = "SELECT `login` , `password`, `role_title`, `upgrading_status` FROM `users` WHERE `login`=? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['login'], \PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        if( password_verify( $_POST['password'], $user->password ) ) {
            $_SESSION['admin'] ['enter'] = true;
            $_SESSION['admin']['login'] = $user->login;
            $_SESSION['admin']['role_title'] = $user->role_title;
            $_SESSION['admin']['upgrading_status'] = $user->upgrading_status;
        }

    }
    public function getLoopCounter()
    {
        $p = @ $_POST['p']? : '1';
        $counter = (int)($p-1)*AMOUNTONPAGEADMIN +1;
        return $counter;
    }

    public  function removeUnnecessaryImages()
    {
        $this->cleanDirectory(PRODUCTS_IMAGES, 'images');
        $this->cleanDirectory(PRODUCTS_IMAGES_THUMBS, 'images');
        $this->cleanDirectory(SLIDER_IMAGES, 'slider');
        $this->cleanDirectory(CAROUSEL_IMAGES, 'carousel');
        $this->cleanDirectory(AVATARS_IMAGES, 'comments', 'avatar');
    }

    private function getDirectoryImages($directory)
    {
        $extentionsArray = ['jpg','png','jpeg','gif'];
        $productImagesArray = [];

        $dir = new \DirectoryIterator(PATH_SITE.UPLOAD_FOLDER.$directory);

        foreach ($dir as $file){
            if ($file->isFile()) {
                $ext = $file->getExtension();
                if(in_array($ext, $extentionsArray)){
                    $productImagesArray[] = $file->getFilename();
                }
            }
        }
        return $productImagesArray;
    }

    private function cleanDirectory($folder, $table, $column = 'image')
    {
        $productImagesArray = $this->getDirectoryImages($folder);

        $sql = "SELECT `$column` FROM `$table`";
        $result = $this->conn->query($sql);
        $res = $result->fetchAll();

        $productImagesDbArray =[];

        foreach ($res as $one){
            $productImagesDbArray[] =$one->$column;
        }
        $arrayDiff = array_diff($productImagesArray, $productImagesDbArray);
        foreach($arrayDiff as $image){
            @unlink(PATH_SITE.UPLOAD_FOLDER.$folder.$image);

        }
    }

    public function getUsers()
    {
        $sql ="SELECT `id`, `login`, `role_title`, `upgrading_status` FROM `users`";
        $result = $this->conn->query($sql);
        $users = $result->fetchAll();

        return $users;
    }

    public function storeUser()
    {
        $status = $this->getUserUpgradingStatus();

        $password= password_hash($_POST['user_password'], PASSWORD_DEFAULT);


        $sql = "INSERT INTO `users` (`login`, `password`, `role_title`, `upgrading_status`) VALUES (?, ?, ?, ?)";
        $stmt =$this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['user_name'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $password, \PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['user_role'], \PDO::PARAM_STR);
        $stmt->bindValue(4, $status, \PDO::PARAM_INT);
        $stmt->execute();

        $id = $this->conn->lastInsertId();
        unset ($_SESSION['makeUser']);
        return $id;
    }


    public function getOneUser()
    {
        $id = $_GET['id']?? $_POST['id'];

        $sql= "SELECT `id`, `login`, `password`, `role_title`, `upgrading_status` FROM `users` WHERE `id` =?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    public function updateUser()
    {
        $status = $this->getUserUpgradingStatus();


        $sql = "UPDATE `users` SET `login`=?,  `role_title`=?, `upgrading_status`=? WHERE `id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['user_name'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $_POST['user_role'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $status, \PDO::PARAM_INT);
        $stmt->bindValue(4, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();

        if(!empty($_POST['user_password'])){
            $password= password_hash($_POST['user_password'], PASSWORD_DEFAULT);

            $sql = "UPDATE `users` SET `password`=? WHERE `id`=?";
            $stmt = $this->conn->prepare($sql);
            $stmt -> bindValue(1, $password, \PDO::PARAM_STR);
            $stmt -> bindValue(2, $_POST['id'], \PDO::PARAM_INT);
            $stmt -> execute();
        }
        unset ($_SESSION['editUser']);
    }

    private function getUserUpgradingStatus()
    {
        switch($_POST['user_role'])
        {
            case 'superadmin':
                $status= 3; break;
            case 'admin':
                $status=2;break;

            default:
                $status=1;
        }
        return $status;
    }

    public function deleteUser()
    {

        $sql= "DELETE FROM `users` WHERE `id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();

        unset($_SESSION['deleteUser']);
    }

}