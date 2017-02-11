<?php

namespace App\Controllers;



use App\Core\BaseController;
use App\Models\Index as DB;
use App\Models\Category;
use App\Models\Lesson;
use App\Models\Testemonial;
use Lib\HelperService;

class Index  extends BaseController
  {


      /**
       * fire off he index action
       *
       * @return array
       */
    public function index()
	{
        $categories = (new Category())->getAll();
        $randomLessons = (new Lesson())->getRandomItems();
        $randomTestimonials = (new Testemonial())->getRandomItems();

        $language = HelperService::getLanguageForPlanDescription();
        $planDescription = (new DB)->getPlanDescription($language);

      return ['view'=>'views/index.php', 'categories'=>$categories, 'randomLessons'=>$randomLessons,
          'randomTestimonials'=> $randomTestimonials, 'planDescription'=>$planDescription];
    }


      public function refreshCaptcha()
      {
          $builder = (new DB)->printCaptcha();
          return ['view' => 'customer/partials/captcha.php', 'builder' => $builder, 'ajax' => true];
      }

  }
  