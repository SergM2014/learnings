<?php

namespace App\Controllers;



use App\Core\BaseController;
use App\Models\Index as DB;
use App\Models\Category;
use App\Models\Lesson;
use App\Models\Testimonial;
use Lib\HelperService;
use Lib\CheckFieldsService;
use Lib\TokenService;
use App\Models\CheckForm;



class Index  extends BaseController
  {

    use CheckFieldsService;
      /**
       * fire off he index action
       *
       * @return array
       */
    public function index()
	{
        $categories = (new Category())->getAll();
        $randomLessons = (new Lesson())->getRandomItems();
        $randomTestimonials = (new Testimonial())->getRandomItems();

        $language = HelperService::getCurrentLanguageAbbr();
        $planDescription = (new DB)->getPlanDescription($language);

      return ['view'=>'views/common/index.php', 'categories'=>$categories, 'randomLessons'=>$randomLessons,
          'randomTestimonials'=> $randomTestimonials, 'planDescription'=>$planDescription];
    }


      public function refreshCaptcha()
      {
          $builder = (new DB)->printCaptcha();
          return ['view' => 'views/common/partials/captcha.php', 'builder' => $builder, 'ajax' => true];
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

    /**
     * show all testimonial
     *
     * @return array
     */
      public function testimonials()
      {
          $testimonials = (new Testimonial())->getAll();
          $builder = (new DB)->printCaptcha();
          return ['view'=>'views/common/testimonials/index.php', 'testimonials'=>$testimonials, 'builder' => $builder,];
      }


      public function storeTestimonial()
      {
          TokenService::check('user');

          $cleanedUpInputs = self::escapeInputs('testimonial', 'captcha');

          $errors = (new CheckForm())->checkAddTestimonialForm($cleanedUpInputs);

          if(!empty($errors) ) {

              $builder = (new DB())->printCaptcha();

              return ['view' => '/views/common/testimonials/form.php', 'errors'=>$errors,  'ajax' => true , 'builder' => $builder];
          }

          (new Testimonial())->saveTestimonial($this->stripTags($_POST['testimonial']));


          return  ['view' => '/views/common/testimonials/addSuccess.php','ajax' => true];
      }


      public function search()
      {
        $searchResults = (new DB())->getSearchResults();
          return  ['view' => '/views/common/partials/searchResults.php', 'searchResults'=>$searchResults, 'ajax' => true];

      }





  }
  