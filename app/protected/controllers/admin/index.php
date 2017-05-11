<?php

namespace App\Controllers\Admin;



use App\Core\BaseController;

use App\Models\AdminModel;
use Lib\TokenService;



class Index  extends BaseController
  {

    public function index()
	{

      if(!isset($_SESSION['admin'])) $noTemplate = true;

      return ['view'=>'views/admin/index.php', 'noTemplate'=> @$noTemplate];
    }


    public function login()
    {
        TokenService::check('admin');
        $adminModel = new AdminModel();
        $adminModel->getAdminUser();


        if(!isset($_SESSION['admin'])){
            return $this->index();
        }


        return ['view'=>'views/admin/index.php'];
    }


    public function logOut()
    {
        TokenService::check('admin');
        unset($_SESSION['admin']);

        return ['view'=>'views/admin/index.php','noTemplate'=>true];
    }













  }
  