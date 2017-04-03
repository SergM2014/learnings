<?php

namespace Lib;


use App\Models\Subscription;
use Lib\TokenService;

class CookieService {

    public static function addUserCookies($login, $userId, $token = false, $activeSubscription = false )
    {
        $expire_time = time()+1209600;

        setcookie('login', $login, $expire_time, '/' );
        setcookie('userId', $userId, $expire_time, '/' );
        if($token) setcookie('userToken', $token, $expire_time, '/');//here is an error tocken should be taken from the DB
        if($activeSubscription) setcookie('activeSubscription', $activeSubscription, time()+86400, '/'); //duration 24 hours
    }


    /**
     * get the user from cookies unless it's not the exit action of the controller
     * 
     * @param array $exitArray
     */
    public static function getUserCookies(array $exitActionArray= ['signOut', 'leave'])
    {
        $url = explode('/',$_SERVER['REQUEST_URI']);
        $url = array_map('strtolower', $url);
        $exitActionArray = array_map('strtolower', $exitActionArray);

        $intersection = !! array_intersect($exitActionArray, $url);
        if($intersection) return;

        if(@!isset($_SESSION['user']['login']) && isset($_COOKIE['login']) && isset($_COOKIE['userToken']) ){

            (new Subscription())->getCookiedUser();
        }
    }



    public static function destroyUserCookies()
    {
        setcookie('login', '', time() - 1, '/');
        setcookie('userId', '', time() - 1, '/');
        setcookie('userToken', '', time() - 1, '/');
        setcookie('activeSubscription', '', time()-1, '/');
    }



}


?>