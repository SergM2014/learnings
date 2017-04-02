<?php

namespace App\Controllers;


use App\Core\BaseController;
use Lib\CheckFieldsService;
use App\Models\CheckForm;
use App\Models\Subscription  as SubscriptionModel;
use Lib\TokenService;
use Lib\HelperService;
use App\Controllers\Index as IndexController;
use Lib\CookieService;


class Subscription extends BaseController
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

        return ['view'=>'/views/subscription/signUp.php', 'noTemplate' =>true, 'errors' =>$errors ];
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

        if(!isset($_SESSION['storeUser']))  header('Location:/subscription/signUp');

        (new SubscriptionModel())->storeUser($cleanedUpInputs);

         HelperService::sendMail($cleanedUpInputs);

        return ['view'=>'/views/subscription/signUpSuccess.php'];
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

        return ['view'=>'/views/subscription/signIn.php', 'noTemplate' =>true, 'errors' =>$errors ];
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

        @extract((new SubscriptionModel())->getSubscribedUser($cleanedUpInputs));

         if(@$token AND isset($_POST['rememberMe'])) {
             CookieService::addUserCookies($cleanedUpInputs['login'], $userId, $token, $activeSubscription);


             return ['view' => '/views/subscription/signInSuccess.php'];
         }
      //in case of fail
       header('Location: /subscription/signIn');
    }

    /**
     * leave a subscribed user status
     *
     * @return array
     */
    public function signOut()
    {
        TokenService::check('user');

        (new SubscriptionModel())->destroySession();

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
        return ['view'=>'/views/subscription/alreadySignedIn.php'];
    }

    public function profile($errors = null )
    {
        $this->ifNotSubscribed();

        //select all information according to session user login
        $profileData = (new SubscriptionModel())->getUserInfo();

        unset($_SESSION['avatar']);
        $_SESSION['updateUser'] = true;

        return ['view'=>'/views/subscription/profile.php', 'profileData' => @$profileData, 'errors' =>$errors];
    }


    public function update()
    {

        TokenService::check('user');

        $cleanedUpInputs = CheckFieldsService::escapeInputs('login', 'password', 'password2', 'email');

        $errors = (new CheckForm())->checkUpdateUserErrors($cleanedUpInputs);

        if(!empty($errors) ){ return $this->profile($errors); }

        if(!isset($_SESSION['updateUser']))  header('Location:/subscription/profile');

        (new SubscriptionModel())->updateUser($cleanedUpInputs);

        HelperService::sendMail($cleanedUpInputs);

        return ['view'=>'/views/subscription/updateUserSuccess.php'];
    }


}