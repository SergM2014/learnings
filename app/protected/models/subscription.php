<?php

namespace App\Models;


use App\Core\DataBase;
use Lib\TokenService;
use Carbon\Carbon;
use Lib\CookieService;

class Subscription extends DataBase
{

    /**
     * store User in DB
     *
     * @param array $input
     * @return string
     */
    public static function storeUser(array $input)
    {
        extract($input);
        $password= password_hash($password, PASSWORD_DEFAULT);
        $token = TokenService::setUserToken($login);
        $sql = "INSERT INTO `users` (`login`, `password`,`email`,  `token`) VALUES (?, ?, ?, ?)";
        $stmt =self::conn()->prepare($sql);
        $stmt->bindValue(1, $login, \PDO::PARAM_STR);
        $stmt->bindValue(2, $password, \PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['email'], \PDO::PARAM_STR);
        $stmt->bindValue(4, $token, \PDO::PARAM_STR);

        if(!$stmt->execute()) return  false;

        $id = self::conn()->lastInsertId();
        unset ($_SESSION['storeUser']);

        self::saveInSession($login, $id);

        return $id;
    }

    protected static function saveInSession($login, $id, $activeSubscription = null )
    {
        $_SESSION['user']['login'] = $login;
        $_SESSION['user']['id'] = $id;
        if(@$activeSubscription) $_SESSION['user']['activeSubscription'] = $activeSubscription;
    }

    /**
     * Check whether given in credentials user exists in DB
     *
     * @param array $input
     * @return array|void
     */
    public static function getSubscribedUser( array $input)
    {
        extract($input);

        if (@!$login OR @!$password) return false;

        $sql = "SELECT `id`,`login`, `password`, `start_date`, `subscription_term`, `token` FROM `users` WHERE `login`=? ";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $login, \PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        $subscription = self::ifUserSubscriped($user);

        if (password_verify($password, $user->password)) {

           self::saveInSession($login, $user->id,  @$subscription->activeStatus );


            return ['token' => $user->token, 'userId'=>$user->id, 'activeSubscription' => @$subscription->activeStatus ];
        }
        return false;
    }


    public static function destroySession()
    {
        unset($_SESSION['user']['login']);
        unset($_SESSION['user']['activeSubscription']);
        unset($_SESSION['user']['id']);

        CookieService::destroyUserCookies();
    }

    /**
     * Check whether user is saved in cookie , when exist than is transmitted to session
     *
     * @return bool|void
     */
    public static function getCookiedUser()
    {
        if (!isset($_COOKIE['login']) ) return;
        $sql = "SELECT `login` , `start_date`, `subscription_term` FROM `users` WHERE `login`=? AND `token`=?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $_COOKIE['login'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $_COOKIE['userToken'], \PDO::PARAM_STR);

        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {

            self::saveInSession( $_COOKIE['login'], $_COOKIE['userId'], @$_COOKIE['activeSubscription']);
            return true;
        }
        return false;
    }

    /**
     * check whether user's subscribtion is active;
     *
     * @param $user
     */
    private static function ifUserSubscriped($user)
    {
        if(!$user->start_date OR !$user->subscription_term)  return false;

        switch ($user->subscription_term) {
            case 'monthly':
                $method = 'addMonth';
                break;
            case 'quarterly':
                $method = 'addMonths';
                $argument = 3;
                break;
            case 'yearly':
                $method = 'addYear';
                break;

        }

        $date = new Carbon($user->start_date);
        //date its end date of subscribtion
        $subscription = new \stdClass();
        $subscription->finalDate = isset($argument) ? $date->$method($argument) : $date->$method();
        $subscription->activeStatus = (Carbon::now() < $date)? true: false;

       return $subscription;
    }


    public static function getUserInfo()
    {
        $sql = "SELECT `id`, `avatar`, `login`, `email`, `start_date`, `subscription_term` FROM `users` WHERE `login`=? ";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $_SESSION['user']['login'], \PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch();
        //should get end day of subscribtion
        $subscription = self::ifUserSubscriped($res);

        $res->finalDate = @$subscription->finalDate;
        $res->activeStatus = @$subscription->activeStatus;

        return $res;
    }


    public static function updateUser(array $input)
    {
        extract($input);

        $sql = "UPDATE `users` SET `login`= ?, `email`= ?  WHERE `id`= ?";
        $stmt =self::conn()->prepare($sql);
        $stmt->bindValue(1, $login, \PDO::PARAM_STR);

        $stmt->bindValue(2, $_POST['email'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['id'], \PDO::PARAM_INT);


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
            $sql = "UPDATE `users` SET `avatar` = ? WHERE `id`=?";
            $stmt = self::conn()->prepare($sql);
            $stmt->bindValue(1, $_SESSION['avatar'], \PDO::PARAM_STR);
            $stmt->bindValue(2, $_POST['id'], \PDO::PARAM_INT);
            if( $stmt->execute()) unset($_SESSION['avatar']);
        }

        self::saveInSession($login);

        unset ($_SESSION['updateUser']);

        //$this->saveInSession($login);

        //return $id;
    }


}