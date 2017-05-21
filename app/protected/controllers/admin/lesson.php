<?php

namespace App\Controllers\Admin;



use App\Core\AdminController;
use App\Models\Lesson as LessonModel;
use App\Models\AdminModel;
use App\Models\Serie;
use Lib\TokenService;
use App\Models\CheckForm;

class Lesson  extends AdminController
  {


    public function index()
	{

        $lessons = LessonModel::getAll('true');
        $pages = LessonModel::countPages('true');
        $tableCounter =  AdminModel::getTableCounter();
        $serieDropDownList =  Serie::printSerieDropDownList();

        return ['view'=>'/views/admin/lesson/index.php', 'lessons'=>$lessons, 'pages'=>$pages, 'counter'=>$tableCounter,
            'serieDropDownList'=>  $serieDropDownList ];
    }



    public function create($errors = null )
    {
        $treeMenu = Serie::printOutSerieTreeMenu();

        $_SESSION['createLesson'] = true;

        if(@$_POST['action']!= "createLesson"){
            unset($_SESSION['lessonsIcon']);
            unset($_SESSION['downloadFile']);
        }

        return ['view'=>'/views/admin/lesson/create.php', 'treeMenu'=>$treeMenu, 'errors'=>$errors ];
    }


    public function store()
    {
        TokenService::check('admin');

        if(!@$_SESSION['createLesson']) return $this->index();

        $cleanedUpInputs = self::escapeInputs('title', 'excerpt');

        $errors =  CheckForm::checkLessonForm($cleanedUpInputs);
        if(!empty($errors) ) {

           return  $this->create($errors);
        }

       LessonModel::saveLesson($this->stripTags($_POST['excerpt']));

        unset($_SESSION['createLesson']);

        return  ['view' => '/views/admin/lesson/addSuccess.php'];
    }


    public function edit($errors = null )
    {
        $lesson =  LessonModel::getOneLesson();
        $treeMenu =  Serie::printOutSerieTreeMenu();

        $_SESSION['editLesson'] = true;

        return ['view'=>'/views/admin/lesson/edit.php', 'treeMenu'=>$treeMenu , 'lesson'=> $lesson, 'errors'=>$errors ];
    }


    public function update()
    {
        TokenService::check('admin');

        if(!@$_SESSION['editLesson']) return $this->index();

        $cleanedUpInputs = self::escapeInputs('title', 'excerpt');

        $errors = CheckForm::checkLessonForm($cleanedUpInputs);
        if(!empty($errors) ) {

            return $this->edit($errors);
        }

        LessonModel::updateLesson($this->stripTags($_POST['excerpt']));

        unset ($_SESSION['editLesson']);

        return  ['view' => '/views/admin/lesson/updateSuccess.php'];
    }


    public function show()
    {
        $lesson = LessonModel::getFullOneLesson();

        return  ['view' => '/views/admin/lesson/show.php', 'lesson'=> $lesson ];
    }


    public function delete()
    {
        TokenService::check('admin');
        $response =  LessonModel::deleteLesson();
        echo json_encode($response);
        exit();
    }

    public function downloadFile()
    {

        $message =  LessonModel::uploadFile();
        echo json_encode($message);
        exit();
    }

    public function deleteFile()
    {
        $message =  LessonModel::deleteFile();
        echo json_encode($message);
        exit();
    }













  }
  