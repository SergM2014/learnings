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
	    $modelLesson = new ModelLesson();
        $lesson =  $modelLesson->getOneLesson();
        $comments = (new Comment())->getCommentsOfOneLesson();
        $relatedLessons = $modelLesson->getRelatedLessons();

        $builder = (new DB)->printCaptcha();

      return ['view'=>'views/lesson.php', 'lesson' =>$lesson, 'comments' => $comments, 'relatedLessons' => $relatedLessons, 'builder'=> $builder ];
    }




  }
  