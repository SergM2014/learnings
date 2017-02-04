<?php

namespace App\Models;

use App\Core\DataBase;
use Lib\CheckFieldsService;
use Lib\HelperService;
use function \empty_field;
use function \wrong_email;
use function \wrong_captcha;
use function \empty_message;

use function \passwordsDoNotMatch;
use function \tooSmallPassword;

class CheckForm extends DataBase
{
    use CheckFieldsService;

    /**
     *
     *check if the income array after cleaning is not empty
     *
     * @return array
     */
    private function checkIfNotEmpty()
    {
        $data= HelperService::cleanInput($_POST, 'message');
        $error=[];
        if(empty($data['name'])) $error['name']= empty_field();
        if(empty($data['email'])) $error['email']= empty_field();
        if(empty($data['message'])) $error['message']= empty_message();
        if(empty($data['captcha'])) $error['captcha']= empty_field();

        return $error;
    }

    public function checkFields()
    {
        $error = $this->checkIfNotEmpty();
        if(!filter_var(@$_POST['email'], FILTER_VALIDATE_EMAIL)) $error['email']= wrong_email();
        if($_SESSION['phrase'] != $_POST['captcha']) $error['captcha'] = wrong_captcha();
        return $error;
    }

    public function insertMessage()
    {
        $data= HelperService::cleanInput($_POST, 'message');
        $data['message'] = $this->stripTags($_POST['message']);
        $sql = "INSERT INTO `messages` (`name`, `email`, `phone`, `message`) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $data['name'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $data['email'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $data['phone'], \PDO::PARAM_STR);
        $stmt->bindValue(4, $data['message'], \PDO::PARAM_STR);
        $stmt->execute();
    }

    public function insertComment()
    {
        $data= HelperService::cleanInput($_POST, 'message');
        $data['message'] = $this->stripTags($_POST['message']);



        $sql = "INSERT INTO `comments` (`product_id`, `avatar`, `name`, `email`, `comment`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->bindValue(2, @ $_SESSION['avatar']);
        $stmt->bindValue(3, $data['name'], \PDO::PARAM_STR);
        $stmt->bindValue(4, $data['email'], \PDO::PARAM_STR);
        $stmt->bindValue(5, $data['message'], \PDO::PARAM_STR);
        $stmt->execute();

        unset ($_SESSION['avatar']);

    }

    public function ifMessageNotEmpty()
    {
        if(empty($_POST['message'])) return ["message_error" => empty_message()];
    }


    public function  checkIfNotEmptyList(...$args)
    {
        $emptyErrors = [];
        foreach ($args as $arg){
            if(isset($_POST[$arg])) { if(!strlen($_POST[$arg])) $emptyErrors[$arg]= empty_field(); }
        }

        if(empty($emptyErrors)) return;
        return $emptyErrors;

    }

    public function deal2PasswordsFields()
    {
        if(strlen($_POST['user_password'])<6) {
           return ['user_password' => tooSmallPassword()];

        }
        if($_POST['user_password'] != $_POST['user_password2']) {
            return ['user_password2' => passwordsDoNotMatch()];

        }

    }



}