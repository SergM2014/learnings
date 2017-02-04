<?php

namespace Lib;


class CookieService {

    public static function addCookies()
    {
        $expire_time = time()+1209600;
        $value = @json_encode($_SESSION['busket']);
        setcookie('busket', $value, $expire_time, '/');
        setcookie('totalSum', (int)$_SESSION['total_sum'], $expire_time, '/');
        setcookie('totalAmount', (int)$_SESSION['total_amount'], $expire_time, '/');
    }


    public static function getCookies()
    {

        if(!isset($_SESSION['busket']) && isset($_COOKIE['busket'])){
            $_SESSION['busket']= json_decode($_COOKIE['busket'], true);
        }

        if(!isset($_SESSION['total_amount']) && isset($_COOKIE['totalAmount'])){
            $_SESSION['total_amount'] = $_COOKIE['totalAmount'];
        }

        if(!isset($_SESSION['total_sum']) && isset($_COOKIE['totalSum'])){
            $_SESSION['total_sum'] = $_COOKIE['totalSum'];
        }


    }



}


?>