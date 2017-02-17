<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\AdminModel;
use Lib\TokenService;


class Admin  extends BaseController
{

    public function index()
    {
        TokenService::checkAdmin('enterAdmin');
        $adminModel = new AdminModel();
        $adminModel->getAdminUser();


      if(!isset($_SESSION['admin'])){
          return ['view'=>'views/notAdmin.php'];
      }


        return ['view'=>'views/admin.php'];
    }


    public function out()
    {
        unset($_SESSION['admin']);
        return ['view'=>'views/notAdmin.php'];
    }

    /*function index(){
        return ['view'=>'/views/signUp.php'];
    }*/

}