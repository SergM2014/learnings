<?php

namespace App\Controllers;



use App\Core\BaseController;
use App\Models\Comment;
use App\Models\Lesson as ModelLesson;
use App\Models\Index as DB;


class Lesson  extends BaseController
  {


      /**
       * fire off he index action
       *
       * @return array
       */
    public function index()
	{
	    $commentModel = new Comment();
	    $modelLesson = new ModelLesson();
        $lesson =  $modelLesson->getOneLesson();
        $comments = $commentModel->getCommentsOfOneLesson();
        $commentsTreeStructure = $commentModel->getCommentsTreeStructure();
        $relatedLessons = $modelLesson->getRelatedLessons();

        $builder = (new DB)->printCaptcha();

      return ['view'=>'views/lesson.php', 'lesson' =>$lesson, 'comments' => $comments, 'relatedLessons' => $relatedLessons, 'builder'=> $builder, 'commentsTreeStructure'=> $commentsTreeStructure ];
    }


    function fileForceDownload() {
        $file = 'upload/video/'.$_GET['file'];
        if (file_exists($file)) {
            // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
            // если этого не сделать файл будет читаться в память полностью!
            if (ob_get_level()) {
                ob_end_clean();
            }
            // заставляем браузер показать окно сохранения файла
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            // читаем файл и отправляем его пользователю
            readfile($file);
            exit;
        }
    }



  }
  