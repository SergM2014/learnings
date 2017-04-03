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

      return ['view'=>'views/common/lesson/index.php', 'lesson' =>$lesson, 'comments' => $comments, 'relatedLessons' => $relatedLessons, 'builder'=> $builder, 'commentsTreeStructure'=> $commentsTreeStructure ];
    }


    public function preview()
    {

        $lesson =  ( new ModelLesson())->getOneLessonforPreview();
        return ['view'=>'views/common/lesson/preview.php', 'lesson' =>$lesson , 'ajax'=> true ];
    }


  }
  