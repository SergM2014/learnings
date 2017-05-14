<?php

namespace App\Controllers\Admin;



use App\Core\AdminController;

use App\Models\Comment as CommentModel;
use App\Models\AdminModel;
use Lib\TokenService;
use App\Models\CheckForm;

class Comment  extends AdminController {

    public function index()
    {
        $comments = CommentModel::getAll(true);
        $pages = CommentModel:: countPages('true');
        $tableCounter = AdminModel::getTableCounter();

        return ['view'=>'views/admin/comment/index.php', 'comments' => $comments, 'pages' => $pages, 'counter' => $tableCounter ];
    }

    public function edit ($errors = null )
    {
        $comment = CommentModel::getOneComment();
        $_SESSION['editComment'] = true;


        return ['view'=>'views/admin/comment/edit.php', 'comment' => $comment, 'errors'=> $errors ];
    }


    public function update()
    {
        TokenService::check('admin');

        if(!@$_SESSION['editComment']) return $this->index();

        $cleanedUpInputs = self::escapeInputs('comment');

        $errors = CheckForm::checkCommentForm($cleanedUpInputs);


        if(!empty($errors) ) {

            return $this->edit($errors);
        }

        CommentModel::updateComment($this->stripTags($_POST['comment']));

        unset ($_SESSION['editComment']);

        return  ['view' => '/views/admin/comment/updateSuccess.php'];
    }


    public function publish()
    {
        TokenService::check('admin');
        $response = CommentModel::publish();
        echo json_encode($response);
        exit();
    }

    public function unpublish()
    {
        TokenService::check('admin');
        $response = CommentModel::unpublish();
        echo json_encode($response);
        exit();
    }



}
  