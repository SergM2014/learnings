<?php

namespace App\Controllers;

use App\Core\BaseController;
use Lib\CheckFieldsService;
use App\Models\CheckForm;
use App\Models\SignUp as SignUpModel;
use Lib\TokenService;
use Lib\HelperService;

use function \succededRegistrationMail;


class SignUp extends BaseController
{
    function index($errors = null )
    {
        $_SESSION['storeUser'] = true;

        return ['view'=>'/views/signUp.php', 'noTemplate' =>true, 'errors' =>$errors ];
    }

    public function register()
    {
        TokenService::check('user');

        $errors = new \stdClass();

        $modelCheckform = new CheckForm();

        $cleanedInputs = CheckFieldsService::escapeInputs('login', 'password', 'password2', 'email');

        $modelCheckform->checkIfNotEmpty($cleanedInputs, $errors);

        $modelCheckform->ifUniqueLogin($cleanedInputs, $errors);

        $modelCheckform->comparePasswordFields($cleanedInputs['password'], $cleanedInputs['password2'], $errors);

        $modelCheckform ->checkLength( $cleanedInputs, 6, $errors);

        $modelCheckform->checkIfEmail($errors);


        $errors = (array)$errors;

        if(!empty($errors) ){ return $this->index($errors); }

        if(!isset($_SESSION['storeUser']))  header('Location:/signUp');


        (new SignUpModel())->storeUser();

         HelperService::sendMail($cleanedInputs['email'], $cleanedInputs['login'], succededRegistrationMail($cleanedInputs['login'], $cleanedInputs['password']));

        return ['view'=>'/views/signUpSuccess.php'];
    }


}