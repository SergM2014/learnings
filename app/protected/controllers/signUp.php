<?php

namespace App\Controllers;

use App\Core\BaseController;
use Lib\CheckFieldsService;

class SignUp extends BaseController
{
    function index(){
        return ['view'=>'/views/signUp.php', 'noTemplate' =>true ];
    }

    public function register()
    {

        $cleanedInputs = CheckFieldsService::escapeInputs('login', 'password', 'password2', 'email');
//chek whether fields corresponds to their fields type
//save new user
        return ['view'=>'/views/signUp.php'];
    }
}