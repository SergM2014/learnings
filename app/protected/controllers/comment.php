<?php

namespace App\Controllers;



use App\Core\BaseController;
use App\Core\DataBase;
use App\Models\Index as DB;
use App\Models\CheckForm;
use Lib\CheckFieldsService;
use App\Models\Comment as DBComment;
use Lib\TokenService;


class Comment  extends BaseController
  {
      use CheckFieldsService;
      /**
       * fire off he index action
       *
       * @return array
       */
    public function store()
	{
        TokenService::check('user');

        $cleanedUpInputs = self::escapeInputs('comment', 'captcha');

	    $errors = (new CheckForm())->checkAddCommentForm($cleanedUpInputs);
        if(!empty($errors) ) {

            $builder = (new DB())->printCaptcha();

            return ['view' => '/views/comments/form.php', 'errors'=>$errors, 'builder'=>$builder, 'ajax' => true];
        }

       (new DBComment())->saveComment($this->stripTags($_POST['comment']));


        return  ['view' => '/views/comments/addSuccess.php','ajax' => true];

    }


    public function getOneForResponse()
    {
        $comment = (new DBComment())->getOneComment();

        return  ['view' => '/views/comments/oneForResponse.php', 'comment'=> $comment, 'ajax' => true];
    }


    public function resetHeader()
    {
        return  ['view' => '/views/comments/addCommentHead.php', 'ajax' => true];
    }


    public function showForm()
    {
        $builder = (new DB())->printCaptcha();
        return  ['view' => '/views/comments/form.php', 'builder' =>$builder, 'ajax' => true];
    }





  }
  