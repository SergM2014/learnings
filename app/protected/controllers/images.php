<?php

namespace App\Controllers;



use App\Core\BaseController;
use App\Models\Images as ModelImages;
use Lib\TokenService;

class Images  extends BaseController
  {
      public function __construct()
      {
          TokenService::check('prozessImageToken');
          parent::__construct();
      }

    public function uploadAvatar()
      {
          $message = (new ModelImages())->uploadAvatar();

          echo json_encode($message);
          exit();
      }


      public function deleteAvatar()
      {
         // TokenService::check('prozessImageToken');
          $message = (new ModelImages())->deleteAvatar();

          echo json_encode($message);
          exit();
      }


  }
  