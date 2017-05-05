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

    public function uploadLessonsIcon()
    {
        $message = (new ModelImages())->uploadLessonIcon();

        echo json_encode($message);
        exit();
    }

      public function deleteLessonsIcon()
      {
          $message = (new ModelImages())->deleteLessonsIcon();

          echo json_encode($message);
          exit();
      }


    public function deleteSerieIcon()
    {
        $message = (new ModelImages())->deleteSerieIcon();

        echo json_encode($message);
        exit();
    }


    public function uploadSerieIcon()
    {
        $message = (new ModelImages())->uploadSerieIcon();

        echo json_encode($message);
        exit();
    }


  }
  