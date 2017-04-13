<?php

namespace App\Controllers\Admin;



use App\Core\AdminController;




use Lib\TokenService;
use App\Models\Lesson as LessonModel;
use App\Models\AdminModel;
use App\Models\Serie;
//use Intervention\Image\ImageManagerStatic as Image;


class Lesson  extends AdminController
  {

    public function index()
	{
	    $model= new LessonModel();
        $lessons = $model->getAll('true');
        $pages = $model->countPages('true');
        $tableCounter = (new AdminModel())->getTableCounter();

        return ['view'=>'views/admin/lesson/index.php', 'lessons'=>$lessons, 'pages'=>$pages, 'counter'=>$tableCounter ];
    }



    public function create()
    {
        $model = new Serie();
        $treeMenu =$model->printOutSerieTreeMenu();
        return ['view'=>'views/admin/lesson/create.php', 'treeMenu'=>$treeMenu ];
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
  