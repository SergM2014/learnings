<?php

namespace App\Controllers\Admin;

use App\Core\AdminController;


use App\Models\AdminModel;
use Lib\TokenService;
use App\Models\CheckForm;

class User  extends AdminController {

    public function __construct()
    {
        if(@$_SESSION['admin']['upgrading_status']!= 3) exit('Unathoriraised access!');
    }

    public function index()
    {
        $users = AdminModel::all();

        return ['view'=>'views/admin/user/index.php', 'users' => $users  ];
    }

    public function edit ($errors = null )
    {
        $user = AdminModel::getOneUser();
        $_SESSION['editUser'] = true;


        return ['view'=>'views/admin/user/edit.php', 'user' => $user, 'errors'=> $errors ];
    }


    public function update()
    {
        TokenService::check('admin');

        if(!@$_SESSION['editUser']) return $this->index();

        $cleanedUpInputs = self::escapeInputs('login', 'email', 'password', 'password2');

        $errors = CheckForm::checkUpdateUserErrors($cleanedUpInputs);


        if(!empty($errors) ) {

            return $this->edit($errors);
        }

        AdminModel::updateUser($cleanedUpInputs);

        unset ($_SESSION['editUser']);

        return  ['view' => '/views/admin/user/updateSuccess.php'];
    }

    public function delete()
    {
        TokenService::check('admin');
        $response = AdminModel::delete();
        echo json_encode($response);
        exit();
    }






}
  