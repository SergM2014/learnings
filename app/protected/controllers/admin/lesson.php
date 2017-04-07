<?php

namespace App\Controllers\Admin;



use App\Core\AdminController;




use Lib\TokenService;
use App\Models\Lesson as LessonModel;
use App\Models\AdminModel;



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
















  }
  