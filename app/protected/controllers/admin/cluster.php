<?php

namespace App\Controllers\Admin;



use App\Core\AdminController;




use Lib\TokenService;
use App\Models\Lesson as LessonModel;
use App\Models\AdminModel;
use App\Models\Serie;
use Lib\CheckFieldsService;
use App\Models\CheckForm;

class Cluster  extends AdminController
  {
    use CheckFieldsService;

    public function index()
	{
        $treeMenu = (new Serie())->printOutSerieTreeMenu(true);

        return ['view'=>'/views/admin/cluster/index.php', 'treeMenu'=>$treeMenu ];
    }

    public function editSerie($errors = null )
    {
        $serie = (new Serie)->getOneSerie();

        $_SESSION['editSerie'] = true;

        return ['view'=>'/views/admin/cluster/editSerie.php', 'serie' =>$serie, 'errors' => $errors ];
    }


    public function updateSerie()
    {
        TokenService::check('admin');

        if(!@$_SESSION['editSerie']) return $this->index();

        $cleanedUpInputs = self::escapeInputs('title');

        $errors = (new CheckForm())->checkSerieForm($cleanedUpInputs);
        if(!empty($errors) ) {

           return $this->editSerie($errors);
        }

        (new Serie())->updateSerie($cleanedUpInputs['title']);

        unset ($_SESSION['editSerie']);

        return  ['view' => '/views/admin/cluster/serieUpdateSuccess.php'];
    }


    public function deleteSerie()
    {
        TokenService::check('admin');
        $response = (new Serie())->delete();
        echo json_encode($response);
        exit();
    }















  }
  