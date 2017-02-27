<?php

namespace App\Core;

use Lib\CookieService;

/**
 *
 * the parent for all controllersd
 * Class BaseController
 * @package App\Core
 */
 class BaseController
 {

     /**
      *
      * initialize session
      * BaseController constructor.
      */
     public function __construct()
     {
         @session_start();

         CookieService::getUserCookies();
     }

     public function alreadySignedUser()
     {
         if(@isset($_SESSION['user']['login'])) {header("Location: /subscribtion/signed");}
     }


 }
 
?>