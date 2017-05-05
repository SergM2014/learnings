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



    public function create($errors = null )
    {
        $treeMenu = (new Serie())->printOutSerieTreeMenu();

        $_SESSION['createLesson'] = true;

        return ['view'=>'/views/admin/lesson/create.php', 'treeMenu'=>$treeMenu, 'errors'=>$errors ];
    }


    public function store()
    {
        TokenService::check('admin');

        if(!@$_SESSION['createLesson']) return $this->index();

        $cleanedUpInputs = self::escapeInputs('title', 'excerpt');

        $errors = (new CheckForm())->checkLessonForm($cleanedUpInputs);
        if(!empty($errors) ) {

           return  $this->create($errors);
        }

        (new LessonModel())->saveLesson($this->stripTags($_POST['excerpt']));

        unset($_SESSION['createLesson']);

        return  ['view' => '/views/admin/lesson/addSuccess.php'];
    }


    public function edit($errors = null )
    {
        $lesson = (new LessonModel())->getOneLesson();
        $treeMenu = (new Serie())->printOutSerieTreeMenu();

        $_SESSION['editLesson'] = true;

        return ['view'=>'/views/admin/lesson/edit.php', 'treeMenu'=>$treeMenu , 'lesson'=> $lesson, 'errors'=>$errors ];
    }


    public function update()
    {
        TokenService::check('admin');

        if(!@$_SESSION['editLesson']) return $this->index();

        $cleanedUpInputs = self::escapeInputs('title', 'excerpt');

        $errors = (new CheckForm())->checkLessonForm($cleanedUpInputs);
        if(!empty($errors) ) {

            return $this->edit($errors);
        }

        (new LessonModel())->updateLesson($this->stripTags($_POST['excerpt']));

        unset ($_SESSION['editLesson']);

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













  }
  