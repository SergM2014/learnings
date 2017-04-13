<?php

namespace App\Models;



use App\Core\DataBase;


class AdminModel extends DataBase
{



    public function getAdminUser( )
    {
        if (@!$_POST['login'] OR @!$_POST['password']) return;
        $sql = "SELECT `login` , `password`, `upgrading_status`, `token` FROM `admins` WHERE `login`= ? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['login'], \PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        if (password_verify($_POST['password'], @$user->password)) {
            $_SESSION['admin']['login'] = $user->login;
            $_SESSION['admin']['upgrading_status'] = $user->upgrading_status;
            $_SESSION['admin']['token'] = $user->token;
        }
    }


    public function getTableCounter()
    {
        $p = $_GET['p']?? 1;
        $start = ($p-1)*AMOUNTONPAGEADMIN+1;
        return $start;
    }



}