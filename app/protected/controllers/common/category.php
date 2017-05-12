<?php




namespace App\Controllers;



use App\Core\BaseController;

use App\Models\Category as CategoryModel;
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
        $categoryWithSeries = CategoryModel::getOneCategory();
        $seriesWithLessons = CategoryModel::getSeriesWithLessons();
        $extraLessonsAmount = CategoryModel::getAmountOfExtraLessons();
        $extraLessons = CategoryModel::getExtraLessons();

        return ['view'=>'views/common/category.php', 'categoryWithSeries'=>$categoryWithSeries,
          'extraLessonsAmount' => $extraLessonsAmount, 'seriesWithLessons'=>$seriesWithLessons, 'extraLessons'=>$extraLessons];
    }

    public function serie()
    {
        $lessons = Serie::getSerieLessons();
        $categoryId = Serie::getCategoryId($lessons);
        $serieLessonsAmount = Serie::getSerieLessonsAmount();
        $extraLessonsAmount = CategoryModel::getAmountOfExtraLessons($categoryId);
        $extraLessons = CategoryModel::getExtraLessons($categoryId);

        return ['view'=>'views/common/serie.php', 'lessons'=>$lessons, 'extraLessons' => $extraLessons, 'categoryId'=>$categoryId,
            'extraLessonsAmount' => $extraLessonsAmount, 'serieLessonsAmount' => $serieLessonsAmount];
    }




  }
  