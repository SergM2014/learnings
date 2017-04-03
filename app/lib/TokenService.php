<?php

namespace Lib;

use function  \smthWentWrong;

class TokenService
{
    /**
     *
     * printing of the giving token
     *
     * @param $action
     */
    public static function printTocken($action )
    {
        if (DEBUG_MODE) { $period = 300; } else { $period = 86400; }//aбо доба або 5min

        if (!isset($_SESSION['_token']['time']) OR ($_SESSION['_token']['time'] + $period < time()) ) {

            self::fire();
        }

        $_token = $_SESSION['_token'];

        echo $_token[$action];
    }

    /**
     *
     * initialising of token range
     */
    public static function fire()
    {
        $_SESSION['_token']['time'] = time();
        $random = uniqid(rand(), true);

        $_SESSION['_token']['prozessImage'] = md5('prozessImage' . $random);
        $_SESSION['_token']['admin'] = md5('admin' . $random);
        $_SESSION['_token']['user'] = md5('user' . $random);


        $_SESSION['_token']['prozessAdmin'] = md5('prozessAdmin' . $random);


    }

    /**
     *
     * check if the given token matches the required
     *
     * @param $action
     * @return bool
     */
    public static function check($action)
    {

        if(!isset($_POST['_token']) OR $_POST['_token']!= @$_SESSION['_token'][$action]) {

            if(isset($_POST['ajax'])) {
                echo json_encode(["message"=> smthWentWrong(), "error"=> true ]); exit();
            }

            header('Location:'.$_SERVER['HTTP_REFERER']); exit();
        }

        return true;
    }


    /**
     *
     * check token for admin entry
     */
    public static function checkAdmin($handle){

        if(!isset($_POST['_token']) OR $_POST['_token']!= $_SESSION['_token'][$handle])  {

            $_POST['login']= null; $_POST['password']= null;  }
    }



    public static function setUserToken($login)
    {
        $random = uniqid(rand(), true);

        $token = md5($login . $random);

        return $token;
    }

}