<?php

namespace App\Core;

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
         session_start();

     }


 }
 
?>