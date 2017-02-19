<?php

namespace App\Models;

use App\Core\DataBase;
use Lib\CheckFieldsService;

use function \emptyField;
use function \notEqualRepeatedPassword;
use function \notApropriateLength;
use function \wrongEmail;
use function \repeatedLogin;


class CheckForm extends DataBase
{
    use CheckFieldsService;


    public function checkIfNotEmpty($fields, $errors)
    {
        foreach ($fields as $key => $field ){
           if(empty($field)){
               $errors->$key = emptyField();
           }
        }
    }

    public function comparePasswordFields($field1, $field2, $errors)
    {
        if($field1 != $field2) {
            $errors->password2 = $errors->password2 ?? notEqualRepeatedPassword();
        }
    }


    public function checkLength(array $fields, $length, $errors)
    {
        foreach ($fields as $key => $field){
            if($key == 'email') continue;
            if(strlen($field) < $length ) $errors->$key = $errors->$key ?? notApropriateLength();
        }
    }

    public function checkIfEmail($errors)
    {
        if(!filter_var(@$_POST['email'], FILTER_VALIDATE_EMAIL)) { $errors->email = $errors->email ?? wrongEmail();}

    }

    public function ifUniqueLogin(array $income, $errors)
    {
        $sql = "SELECT `id` FROM `users` WHERE `login`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $income['login']);
        $stmt->execute();
        $id = $stmt->fetchColumn();
        if($id)  $errors->login = $errors->login ?? repeatedLogin();
    }





}