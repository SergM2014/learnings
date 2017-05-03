<?php

namespace App\Controllers\Admin;



use App\Core\AdminController;




use Lib\TokenService;
use App\Models\Lesson as LessonModel;
use App\Models\AdminModel;
use App\Models\Serie;
use Lib\CheckFieldsService;
use App\Models\CheckForm;

class CategoryAndSerie  extends AdminController
  {
    use CheckFieldsService;

    public function index()
	{
        $treeMenu = (new Serie())->printOutSerieTreeMenu(true);

        return ['view'=>'/views/admin/categoriesAndSerie/index.php', 'treeMenu'=>$treeMenu ];
    }


















  }
  