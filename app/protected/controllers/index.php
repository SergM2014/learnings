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

        $language = HelperService::getCurrentLanguageAbbr();
        $planDescription = (new DB)->getPlanDescription($language);

      return ['view'=>'views/index.php', 'categories'=>$categories, 'randomLessons'=>$randomLessons,
          'randomTestimonials'=> $randomTestimonials, 'planDescription'=>$planDescription];
    }


      public function refreshCaptcha()
      {
          $builder = (new DB)->printCaptcha();
          return ['view' => 'views/partials/captcha.php', 'builder' => $builder, 'ajax' => true];
      }


    /**
     * represent default language and array of given languages from config in json format
     */
      public function getLanguageComponents()
      {
          $langs = array_keys( HelperService::prozessLangArray());

          echo json_encode(['defaultLanguage' => DEFAULT_LANG, 'languagesArray' => $langs]);
          exit();
      }


      public function testemonials()
      {
          $testimonials = (new Testemonial())->getAll();
          return ['view'=>'views/testimonials.php', 'testimonials'=>$testimonials];
      }


  }
  