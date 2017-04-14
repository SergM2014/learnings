<?php

namespace App\Controllers\Admin;



use App\Core\AdminController;




use Lib\TokenService;
use App\Models\Lesson as LessonModel;
use App\Models\AdminModel;
use App\Models\Serie;
use Lib\CheckFieldsService;
use App\Models\CheckForm;

class Lesson  extends AdminController
  {
    use CheckFieldsService;

    public function index()
	{
	    $model= new LessonModel();
        $lessons = $model->getAll('true');
        $pages = $model->countPages('true');
        $tableCounter = (new AdminModel())->getTableCounter();

        return ['view'=>'/views/admin/lesson/index.php', 'lessons'=>$lessons, 'pages'=>$pages, 'counter'=>$tableCounter ];
    }



    public function create()
    {
        $model = new Serie();
        $treeMenu =$model->printOutSerieTreeMenu();
        return ['view'=>'/views/admin/lesson/create.php', 'treeMenu'=>$treeMenu ];
    }


    public function downloadFile()
    {

        $message = (new LessonModel())->uploadFile();
        echo json_encode($message);
        exit();
    }

    public function deleteFile()
    {
        $message = (new LessonModel())->deleteFile();
        echo json_encode($message);
        exit();
    }


    public function store()
    {


        //TokenService::check('admin');

        $cleanedUpInputs = self::escapeInputs('title', 'excerpt');

        $errors = (new CheckForm())->checkAddLessonForm($cleanedUpInputs);
        if(!empty($errors) ) {


            $treeMenu = (new Serie)->printOutSerieTreeMenu();
            return ['view' => '/views/admin/lesson/create.php', 'errors'=>$errors , 'treeMenu'=>$treeMenu];
        }

        (new LessonModel())->saveLesson($this->stripTags($_POST['comment']));


        return  ['view' => '/views/common/comments/addSuccess.php','ajax' => true];
    }
















  }
  