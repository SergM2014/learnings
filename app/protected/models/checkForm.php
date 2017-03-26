<?php

namespace App\Models;

use App\Core\DataBase;
use Lib\CheckFieldsService;


use function \emptyField;
use function \notEqualRepeatedPassword;
use function \notApropriateLength;
use function \wrongEmail;
use function \repeatedLogin;
use function \wrongCaptcha;


class CheckForm extends DataBase
{
    use CheckFieldsService;


    protected function checkIfNotEmpty(array $fields, $errors)
    {

        foreach ($fields as $key => $field ){
           if(empty($field)){
               $errors->$key = emptyField();
           }
        }
    }

    protected function comparePasswordFields($field1, $field2, $errors)
    {
        if($field1 != $field2) {
            $errors->password2 = $errors->password2 ?? notEqualRepeatedPassword();
        }
    }


    protected function checkFieldsLength(array $fields, $length, $errors)
    {
        foreach ($fields as $key => $field){
            if($key == 'email') continue;
            if(strlen($field) < $length ) $errors->$key = $errors->$key ?? notApropriateLength();
        }
    }

    protected function checkIfEmail($errors)
    {
        if(!filter_var(@$_POST['email'], FILTER_VALIDATE_EMAIL)) { $errors->email = $errors->email ?? wrongEmail();}

    }

    protected  function checkCaptcha($inputs, $errors)
    {
        if($_SESSION['phrase']!= $inputs['captcha']) { $errors->captcha = $errors->captcha ?? wrongCaptcha(); }
    }

    protected function ifUniqueLogin(array $income, $errors)
    {
        $sql = "SELECT `id` FROM `users` WHERE `login`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $income['login']);
        $stmt->execute();
        $id = $stmt->fetchColumn();
        if($id)  $errors->login = $errors->login ?? repeatedLogin();
    }



    public function checkSignUpErrors($inputs)
    {
        $errors = new \stdClass();

        $this->checkIfNotEmpty($inputs, $errors);
        $this->ifUniqueLogin($inputs, $errors);
        $this->comparePasswordFields($inputs['password'], $inputs['password2'], $errors);
        $this->checkFieldsLength($inputs, 6, $errors);
        $this->checkIfEmail($errors);

        return (array)$errors;
   }



   public function checkUpdateUserErrors($inputs)
   {
       $errors = new \stdClass();

       $this->checkIfNotEmpty(['login' => $inputs['login'], 'email' => $inputs['email']], $errors);

       $this->comparePasswordFields($inputs['password'], $inputs['password2'], $errors);

       if($inputs['password'] == '') $inputs = [ 'login' => $inputs['login'], 'email' => $inputs['email'] ];

       $this->checkFieldsLength($inputs, 6, $errors);
       $this->checkIfEmail($errors);

       return (array)$errors;
   }

   public function checkAddCommentForm($inputs)
   {
        $errors =  new \stdClass();

        $this->checkIfNotEmpty($inputs, $errors);

        $this->checkCaptcha($inputs, $errors);

      return (array)$errors;

   }

   public function checkAddTestimonialForm($inputs)
   {
       $errors =  new \stdClass();

       $this->checkIfNotEmpty($inputs, $errors);

       $this->checkCaptcha($inputs, $errors);


       return (array)$errors;

   }





}