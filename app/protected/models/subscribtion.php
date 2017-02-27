<?php

namespace App\Models;


use App\Core\DataBase;
use Lib\TokenService;

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
        $sql = "INSERT INTO `users` (`login`, `password`,`email`, `role_title`, `upgrading_status`, `token`) VALUES (?, ?, ?, 'user', '1', ?)";
        $stmt =$this->conn->prepare($sql);
        $stmt->bindValue(1, $login, \PDO::PARAM_STR);
        $stmt->bindValue(2, $password, \PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['email'], \PDO::PARAM_STR);
        $stmt->bindValue(4, $token, \PDO::PARAM_STR);

        if(!$stmt->execute()) return;

        $id = $this->conn->lastInsertId();
        unset ($_SESSION['storeUser']);

        $this->saveInSession($login, $password);

        return $id;
    }

    protected function saveInSession($login, $upgradingStatus)
    {
        $_SESSION['user']['login'] = $login;
        $_SESSION['user']['upgradingStatus'] = $upgradingStatus;

    }

    /**
     * Check whether given in input user exists in DB
     *
     * @param array $input
     * @return bool|void
     */
    public function getSubscribedUser( array $input)
    {
        extract($input);
        if (@!$login OR @!$password) return;
        $sql = "SELECT `login`, `password`, `role_title`, `upgrading_status`, `token` FROM `users` WHERE `login`=? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $login, \PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        if (@password_verify($password, $user->password)) {
            $this->saveInSession($login, $user->upgrading_status);
           // return true;
            return $user->token;
        }
    }

    public function destroySession()
    {
        unset($_SESSION['user']['login']);
        unset($_SESSION['user']['upgradingStatus']);
    }

    /**
     * Check whether user is saved in cookie , when exist than is transmitted to session
     *
     * @return bool|void
     */
    public function getCookiedUser()
    {
        if (!isset($_COOKIE['login']) ) return;
        $sql = "SELECT `login` , `role_title`, `upgrading_status` FROM `users` WHERE `login`=? AND `token`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_COOKIE['login'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $_COOKIE['userToken'], \PDO::PARAM_STR);

        $stmt->execute();

    //var_dump($stmt); //return only string

        $user = $stmt->fetch();
//var_dump($user);
        if ($user) {
            $this->saveInSession( $_COOKIE['login'], $user->upgrading_status);
            return true;
        }
    }


}