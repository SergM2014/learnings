<?php

namespace App\Controllers\Admin;



use App\Core\BaseController;

use Lib\HelperService;
use Lib\CheckFieldsService;
use Lib\TokenService;
use App\Models\AdminModel;



class Index  extends BaseController
  {

    use CheckFieldsService;
      /**
       * fire off he index action
       *
       * @return array
       */
    public function index()
	{

      if(!isset($_SESSION['admin'])) $noTemplate = true;

      return ['view'=>'views/admin/login.php', 'noTemplate'=> @$noTemplate];
    }

    public function login()
    {
       // TokenService::check('admin');
        $adminModel = new AdminModel();
        $adminModel->getAdminUser();


        if(!isset($_SESSION['admin'])){
            return $this->index();
        }


        return ['view'=>'views/admin/index.php'];
    }


    public function logOut()
    {
       // TokenService::check('admin');
        unset($_SESSION['admin']);

        return ['view'=>'views/admin/login.php','noTemplate'=>true];
    }













  }
  