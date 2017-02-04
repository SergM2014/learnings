<?php

namespace App\Controllers;



use App\Core\BaseController;
use App\Models\DB_Index;



  class Index  extends BaseController
  {


      /**
       * fire off he index action
       *
       * @return array
       */
    public function index()
	{


      return ['view'=>'views/index.php'];
    }


      public function refreshCaptcha()
      {
          $builder = (new DB_Index)->printCaptcha();
          return ['view' => 'customer/partials/captcha.php', 'builder' => $builder, 'ajax' => true];
      }

  }
  