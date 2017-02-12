<?php

namespace App\Controllers;



use App\Core\BaseController;

use App\Models\Category as CatModel;



class Category  extends BaseController
  {


      /**
       * fire off he index action
       *
       * @return array
       */
    public function index()
	{
	    $model = new CatModel();

        $categoryWithSeries = $model->getOneCategory();
        $extraLessonsAmount = $model->getAmountOfExtraLessons();

        $seriesWithLessons = $model->getSeriesWithLessons();
        $extraLessons = $model->getExtraLessons();



      return ['view'=>'views/category.php', 'categoryWithSeries'=>$categoryWithSeries,
          'extraLessonsAmount' => $extraLessonsAmount, 'seriesWithLessons'=>$seriesWithLessons, 'extraLessons'=>$extraLessons];
    }




  }
  