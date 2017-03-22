<?php

namespace App\Controllers;


use App\Core\BaseController;
use Lib\CheckFieldsService;

use App\Models\Subscribtion  as SubscribtionModel;
use Lib\TokenService;
use Lib\HelperService;
use App\Controllers\Index as IndexController;
use Lib\CookieService;


class Subscribtion extends BaseController
{
    public function index()
    {
        return (new IndexController())->index();
    }

    /**
     * show registration form
     *
     * @param null $errors
     * @return array
     */
    function signUp($errors = null )
    {
        $this->alreadySignedUser();

        $_SESSION['storeUser'] = true;

        return ['view'=>'/views/subscribtion/signUp.php', 'noTemplate' =>true, 'errors' =>$errors ];
    }

    /**
     * persist the user given from SignUp form
     *
     * @return array
     */
    public function store()
    {
        TokenService::check('user');

        $cleanedUpInputs = CheckFieldsService::escapeInputs('login', 'password', 'password2', 'email');

        $errors = (new CheckForm())->checkSignUpErrors($cleanedUpInputs);

        if(!empty($errors) ){ return $this->signUp($errors); }

        if(!isset($_SESSION['storeUser']))  header('Location:/subscribtion/signUp');

        (new SubscribtionModel())->storeUser($cleanedUpInputs);

         HelperService::sendMail($cleanedUpInputs);

        return ['view'=>'/views/subscribtion/signUpSuccess.php'];
    }


    /**
     * show login form
     *
     * @param null $errors
     * @return array
     */
    function signIn($errors = null )
    {
        $this->alreadySignedUser();

        $_SESSION['getUser'] = true;

        return ['view'=>'/views/subscribtion/signIn.php', 'noTemplate' =>true, 'errors' =>$errors ];
    }

    /**
     * sign in as a user using credentials form and populate token
     *
     * @return array
     */
    public function login()
    {
        TokenService::check('user');

        $this->alreadySignedUser();

        $cleanedUpInputs = CheckFieldsService::escapeInputs('login', 'password');

        @extract((new SubscribtionModel())->getSubscribedUser($cleanedUpInputs));

         if(@$token AND isset($_POST['rememberMe'])) {
             CookieService::addUserCookies($cleanedUpInputs['login'], $userId, $token, $activeSubscribtion);


             return ['view' => '/views/subscribtion/signInSuccess.php'];
         }
      //in case of fail
       header('Location: /subscribtion/signIn');
    }

    /**
     * leave a subscribed user status
     *
     * @return array
     */
    public function signOut()
    {
        TokenService::check('user');

        (new SubscribtionModel())->destroySession();

        CookieService::destroyUserCookies();

        return (new IndexController())->index();
    }

    /**
     * redirect if already subscribed
     *
     * @return array
     */
    public function signed()
    {
        return ['view'=>'/views/subscribtion/alreadySignedIn.php'];
    }

    public function profile($errors = null )
    {
        $this->ifNotSubscribed();

        //select all information according to session user login
        $profileData = (new SubscribtionModel())->getUserInfo();

        unset($_SESSION['avatar']);
        $_SESSION['updateUser'] = true;

        return ['view'=>'/views/subscribtion/profile.php', 'profileData' => @$profileData, 'errors' =>$errors];
    }


    public function update()
    {

        TokenService::check('user');

        $cleanedUpInputs = CheckFieldsService::escapeInputs('login', 'password', 'password2', 'email');

        $errors = (new CheckForm())->checkUpdateUserErrors($cleanedUpInputs);

        if(!empty($errors) ){ return $this->profile($errors); }

        if(!isset($_SESSION['updateUser']))  header('Location:/subscribtion/profile');

        (new SubscribtionModel())->updateUser($cleanedUpInputs);

        HelperService::sendMail($cleanedUpInputs);

        return ['view'=>'/views/subscribtion/updateUserSuccess.php'];
    }


}