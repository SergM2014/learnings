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
        $serieDropDownList = (new Serie())->printSerieDropDownList();

        return ['view'=>'/views/admin/lesson/index.php', 'lessons'=>$lessons, 'pages'=>$pages, 'counter'=>$tableCounter,
            'serieDropDownList'=>  $serieDropDownList ];
    }



    public function create()
    {
        $treeMenu = (new Serie())->printOutSerieTreeMenu();
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
        TokenService::check('admin');

        $cleanedUpInputs = self::escapeInputs('title', 'excerpt');

        $errors = (new CheckForm())->checkLessonForm($cleanedUpInputs);
        if(!empty($errors) ) {


            $treeMenu = (new Serie)->printOutSerieTreeMenu();
            return ['view' => '/views/admin/lesson/create.php', 'errors'=>$errors , 'treeMenu'=>$treeMenu];
        }

        (new LessonModel())->saveLesson($this->stripTags($_POST['excerpt']));


        return  ['view' => '/views/admin/lesson/addSuccess.php'];
    }


    public function edit()
    {
        $lesson = (new LessonModel())->getOneLesson();
        $treeMenu = (new Serie())->printOutSerieTreeMenu();
        return ['view'=>'/views/admin/lesson/edit.php', 'treeMenu'=>$treeMenu , 'lesson'=> $lesson ];
    }


    public function update()
    {
        TokenService::check('admin');

        $cleanedUpInputs = self::escapeInputs('title', 'excerpt');

        $errors = (new CheckForm())->checkLessonForm($cleanedUpInputs);
        if(!empty($errors) ) {

            $lesson = (new LessonModel())->getOneLesson();
            $treeMenu = (new Serie)->printOutSerieTreeMenu();
            return ['view' => '/views/admin/lesson/edit.php', 'errors'=>$errors , 'treeMenu'=>$treeMenu, 'lesson'=> $lesson ];
        }

        (new LessonModel())->updateLesson($this->stripTags($_POST['excerpt']));


        return  ['view' => '/views/admin/lesson/updateSuccess.php'];
    }


    public function show()
    {
        $lesson = (new LessonModel())->getFullOneLesson();

        return  ['view' => '/views/admin/lesson/show.php', 'lesson'=> $lesson ];
    }


    public function delete()
    {
        TokenService::check('admin');
        $response = (new LessonModel())->deleteLesson();
        echo json_encode($response);
        exit();
    }













  }
  