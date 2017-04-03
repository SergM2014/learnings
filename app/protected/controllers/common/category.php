<?php




namespace App\Controllers;



use App\Core\BaseController;

use App\Models\Category as CatModel;
use App\Models\Serie;



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
        $seriesWithLessons = $model->getSeriesWithLessons();


        $extraLessonsAmount = $model->getAmountOfExtraLessons();
        $extraLessons = $model->getExtraLessons();



      return ['view'=>'views/common/category.php', 'categoryWithSeries'=>$categoryWithSeries,
          'extraLessonsAmount' => $extraLessonsAmount, 'seriesWithLessons'=>$seriesWithLessons, 'extraLessons'=>$extraLessons];
    }

    public function serie()
    {
        $catModel = new CatModel();
        $serieModel = new Serie();

        $lessons = $serieModel->getSerieLessons();

        $categoryId = $serieModel->getCategoryId($lessons);

        $serieLessonsAmount = $serieModel->getSerieLessonsAmount();

        $extraLessonsAmount = $catModel->getAmountOfExtraLessons($categoryId);

        $extraLessons = $catModel->getExtraLessons($categoryId);

        return ['view'=>'views/common/serie.php', 'lessons'=>$lessons, 'extraLessons' => $extraLessons, 'categoryId'=>$categoryId,
            'extraLessonsAmount' => $extraLessonsAmount, 'serieLessonsAmount' => $serieLessonsAmount];
    }




  }
  