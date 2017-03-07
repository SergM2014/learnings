<?php

namespace App\Controllers;



use App\Core\BaseController;
use App\Models\Images as ModelImages;
use Lib\TokenService;

class Images  extends BaseController
  {
      public function __construct()
      {
          parent::__construct();
          TokenService::check('prozessImage');

      }

    public function uploadAvatar()
      {
          $message = (new ModelImages())->uploadAvatar();

          echo json_encode($message);
          exit();
      }


      public function deleteAvatar()
      {
          $message = (new ModelImages())->deleteAvatar();

          echo json_encode($message);
          exit();
      }


  }
  