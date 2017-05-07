<?php

namespace App\Controllers\Admin;



use App\Core\AdminController;




use Lib\TokenService;
use App\Models\Category;
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


    public function createSerie($errors = null )
    {
        $_SESSION['createSerie'] = true;

        return ['view'=>'/views/admin/cluster/createSerie.php',  'errors' => $errors ];
    }


    public function saveSerie()
    {
        TokenService::check('admin');

        if(!@$_SESSION['createSerie']) return $this->index();

        $cleanedUpInputs = self::escapeInputs('title');

        $errors = (new CheckForm())->checkSerieForm($cleanedUpInputs);
        if(!empty($errors) ) {

            return $this->createSerie($errors);
        }

        (new Serie())->saveSerie($cleanedUpInputs['title']);

        unset ($_SESSION['createSerie']);

        return  ['view' => '/views/admin/cluster/serieAddSuccess.php'];
    }


    public function createCategory($errors = null )
    {
        $_SESSION['createCategory'] = true;

        return ['view'=>'/views/admin/cluster/createCategory.php',  'errors' => $errors ];
    }


    public function saveCategory()
    {
        TokenService::check('admin');

        if(!@$_SESSION['createCategory']) return $this->index();

        $cleanedUpInputs = self::escapeInputs('title');

        $errors = (new CheckForm())->checkCategoryForm($cleanedUpInputs);
        if(!empty($errors) ) {

            return $this->createCategory($errors);
        }

        (new Category())->saveCategory($cleanedUpInputs['title']);

        unset ($_SESSION['createCategory']);

        return  ['view' => '/views/admin/cluster/categoryAddSuccess.php'];
    }



    public function editCategory($errors = null )
    {
        $category = (new Category)->getOneSimplifiedCategory();
        $_SESSION['editCategory'] = true;

        return ['view'=>'/views/admin/cluster/editCategory.php',  'errors' => $errors, 'category' => $category ];
    }

    public function updateCategory()
    {
        TokenService::check('admin');

        if(!@$_SESSION['editCategory']) return $this->index();

        $cleanedUpInputs = self::escapeInputs('title');

        $errors = (new CheckForm())->checkCategoryForm($cleanedUpInputs);
        if(!empty($errors) ) {

            return $this->editCategory($errors);
        }

        (new Category())->updateCategory($cleanedUpInputs['title']);

        unset ($_SESSION['ediCategory']);

        return  ['view' => '/views/admin/cluster/categoryUpdateSuccess.php'];
    }







  }
  