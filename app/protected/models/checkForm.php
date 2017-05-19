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
use function \noCategoryAndSerie;
use function \noFile;


class CheckForm extends DataBase
{
    use CheckFieldsService;


    protected static function checkIfNotEmpty(array $fields, $errors)
    {

        foreach ($fields as $key => $field ){
           if(empty($field)){
               $errors->$key = emptyField();
           }
        }
    }




    protected static function checkFieldsLength(array $fields, $length, $errors)
    {
        foreach ($fields as $key => $field){
            if($key == 'email') continue;
            if(strlen($field) < $length ) $errors->$key = $errors->$key ?? notApropriateLength();
        }
    }

    protected static function checkIfEmail($errors)
    {
        if(!filter_var(@$_POST['email'], FILTER_VALIDATE_EMAIL)) { $errors->email = $errors->email ?? wrongEmail();}

    }

    protected static function checkCaptcha($inputs, $errors)
    {
        if($_SESSION['phrase']!= $inputs['captcha']) { $errors->captcha = $errors->captcha ?? wrongCaptcha(); }
    }

    protected static function ifUniqueLogin(array $income, $errors)
    {
        $sql = "SELECT `id` FROM `users` WHERE `login`=?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $income['login']);
        $stmt->execute();
        $id = $stmt->fetchColumn();
        if($id)  $errors->login = $errors->login ?? repeatedLogin();
    }



    public static function checkSignUpErrors($inputs)
    {
        $errors = new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);
        self::ifUniqueLogin($inputs, $errors);
        self::comparePasswordFields($inputs['password'], $inputs['password2'], $errors);
        self::checkFieldsLength($inputs, 6, $errors);
        self::checkIfEmail($errors);

        return (array)$errors;
   }


    protected static function comparePasswordFields($field1, $field2, $errors)
    {
        if($field1 != $field2) {
            $errors->password2 = $errors->password2 ?? notEqualRepeatedPassword();
        }
    }


   public static function checkUpdateUserErrors($inputs)
   {
       $errors = new \stdClass();

       self::checkIfNotEmpty(['login' => $inputs['login'], 'email' => $inputs['email']], $errors);

       @self::comparePasswordFields($inputs['password'], $inputs['password2'], $errors);

       if(@$inputs['password'] == '') $inputs = [ 'login' => $inputs['login'], 'email' => $inputs['email'] ];

       self::checkFieldsLength($inputs, 6, $errors);
       self::checkIfEmail($errors);

       return (array)$errors;
   }

   public static function checkAddCommentForm($inputs)
   {
        $errors =  new \stdClass();

       self::checkIfNotEmpty($inputs, $errors);

       self::checkCaptcha($inputs, $errors);

      return (array)$errors;

   }

   public static function checkAddTestimonialForm($inputs)
   {
       $errors =  new \stdClass();

       self::checkIfNotEmpty($inputs, $errors);

       self::checkCaptcha($inputs, $errors);


       return (array)$errors;

   }


    protected static function checkCategory($errors)
    {
        if(!$_POST['category']) { $errors->category = $errors->category ?? noCategoryAndSerie();}

    }


    protected static function checkDownloadedFile($errors)
    {
        if (@!$_SESSION['downloadFile']) {
            $errors->downloadFile = $errors->downloadFile ?? noFile();
        }

    }
    protected static function checkLessonsIcon($errors)
    {
        if (@!$_SESSION['lessonsIcon']) {
            $errors->lessonsIcon = $errors->lessonsIcon ?? noFile();
        }

    }


    public static function checkLessonForm($inputs)
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);
        self::checkCategory($errors);
        self::checkDownloadedFile($errors);
        self::checkLessonsIcon($errors);

        return (array)$errors;
    }


    protected static function checkSerieIcon($errors)
    {
        if (@!$_SESSION['serieIcon'] OR $_SESSION['serieIcon'] == 'delete') {
            $errors->serieIcon = $errors->serieIcon ?? noFile();
        }

    }


    public static function checkSerieForm($inputs)
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);
        self::checkSerieIcon($errors);

        return (array)$errors;
    }


    public static function checkCategoryForm($inputs)
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);

        return (array)$errors;
    }


    public static function checkTestimonialForm($inputs)
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);

        return (array)$errors;
    }

    public static function checkCommentForm($inputs)
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);

        return (array)$errors;
    }

    public static function checkSubscriptionPlanForm($inputs)
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);

        return (array)$errors;
    }

    public static function checkUpdateFormUser($inputs)
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);
        self::checkIfEmail($errors);

        return (array)$errors;
    }





}