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


        $lesson =  ModelLesson::getOneLesson();
        $comments = Comment::getCommentsOfOneLesson();
        $commentsTreeStructure = (new Comment())->getCommentsTreeStructure();
        $relatedLessons = ModelLesson::getRelatedLessons();

        $builder = DB::printCaptcha();

      return ['view'=>'views/common/lesson/index.php', 'lesson' =>$lesson, 'comments' => $comments, 'relatedLessons' => $relatedLessons, 'builder'=> $builder, 'commentsTreeStructure'=> $commentsTreeStructure ];
    }


    public function preview()
    {

        $lesson =  ModelLesson::getOneLessonforPreview();
        return ['view'=>'views/common/lesson/preview.php', 'lesson' =>$lesson , 'ajax'=> true ];
    }


  }
  