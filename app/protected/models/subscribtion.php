<?php

namespace App\Models;


use App\Core\DataBase;
use Lib\TokenService;
use Carbon\Carbon;
use Lib\CookieService;

class Subscribtion extends DataBase
{

    /**
     * store User in DB
     *
     * @param array $input
     * @return string
     */
    public function storeUser(array $input)
    {
        extract($input);
        $password= password_hash($password, PASSWORD_DEFAULT);
        $token = TokenService::setUserToken($login);
        $sql = "INSERT INTO `users` (`login`, `password`,`email`,  `token`) VALUES (?, ?, ?, ?)";
        $stmt =$this->conn->prepare($sql);
        $stmt->bindValue(1, $login, \PDO::PARAM_STR);
        $stmt->bindValue(2, $password, \PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['email'], \PDO::PARAM_STR);
        $stmt->bindValue(4, $token, \PDO::PARAM_STR);

        if(!$stmt->execute()) return  false;

        $id = $this->conn->lastInsertId();
        unset ($_SESSION['storeUser']);

        $this->saveInSession($login);

        return $id;
    }

    protected function saveInSession($login, $id, $activeSubscribtion = null )
    {
        $_SESSION['user']['login'] = $login;
        $_SESSION['user']['id'] = $id;
        if(@$activeSubscribtion) $_SESSION['user']['activeSubscribtion'] = $activeSubscribtion;

        CookieService::addUserCookies($login, $id);

    }

    /**
     * Check whether given in credentials user exists in DB
     *
     * @param array $input
     * @return bool|void
     */
    public function getSubscribedUser( array $input)
    {
        extract($input);

        if (@!$login OR @!$password) return false;

        $sql = "SELECT `id`,`login`, `password`, `start_date`, `subscribtion_term`, `token` FROM `users` WHERE `login`=? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $login, \PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        $subscription = $this->ifUserSubscribed($user);

        if (password_verify($password, $user->password)) {

            $this->saveInSession($login, $user->id,  @$subscription->activeStatus );

            return ['token' => $user->token, 'activeSubscribtion' => @$subscription->activeStatus ];
        }
        return false;
    }


    public function destroySession()
    {
        unset($_SESSION['user']['login']);
        unset($_SESSION['user']['activeSubscribtion']);
        unset($_SESSION['user']['id']);

        CookieService::destroyUserCookies();
    }

    /**
     * Check whether user is saved in cookie , when exist than is transmitted to session
     *
     * @return bool|void
     */
    public function getCookiedUser()
    {
        if (!isset($_COOKIE['login']) ) return;
        $sql = "SELECT `login` , `start_date`, `subscribtion_term` FROM `users` WHERE `login`=? AND `token`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_COOKIE['login'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $_COOKIE['userToken'], \PDO::PARAM_STR);

        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {
            $this->saveInSession( $_COOKIE['login'], @$_COOKIE['activeSubscribtion']);
            return true;
        }
    }

    /**
     * check whether user's subscribtion is active;
     *
     * @param $user
     */
    private function ifUserSubscribed($user)
    {
        if(!$user->start_date OR !$user->subscribtion_term)  return false;

        switch ($user->subscribtion_term) {
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


    public function getUserInfo()
    {
        $sql = "SELECT `id`, `avatar`, `login`, `email`, `start_date`, `subscribtion_term` FROM `users` WHERE `login`=? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_SESSION['user']['login'], \PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch();
        //should get end day of subscribtion
        $subscription = $this->ifUserSubscribed($res);

        $res->finalDate = @$subscription->finalDate;
        $res->activeStatus = @$subscription->activeStatus;

        return $res;
    }


    public function updateUser(array $input)
    {
        extract($input);

        $sql = "UPDATE `users` SET `login`= ?, `email`= ?  WHERE `id`= ?";
        $stmt =$this->conn->prepare($sql);
        $stmt->bindValue(1, $login, \PDO::PARAM_STR);

        $stmt->bindValue(2, $_POST['email'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['id'], \PDO::PARAM_INT);


        if(!$stmt->execute()) return  false;

        if($_POST['password'] !=''){

            $password= password_hash($password, PASSWORD_DEFAULT);

            $sql = "UPDATE `users` SET `password` = ? ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $password, \PDO::PARAM_INT);

            if(!$stmt->execute()) return  false;
        }


        if(@$_SESSION['avatar']){
            if($_SESSION['avatar'] == 'delete') $_SESSION['avatar'] = null;
            $sql = "UPDATE `users` SET `avatar` = ? WHERE `id`=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $_SESSION['avatar'], \PDO::PARAM_STR);
            $stmt->bindValue(2, $_POST['id'], \PDO::PARAM_INT);
            if( $stmt->execute()) unset($_SESSION['avatar']);
        }

        $this->saveInSession($login);

        unset ($_SESSION['updateUser']);

        //$this->saveInSession($login);

        //return $id;
    }


}