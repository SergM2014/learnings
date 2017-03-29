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


      public function testimonials()
      {
          $testimonials = (new Testimonial())->getAll();
          $builder = (new DB)->printCaptcha();
          return ['view'=>'views/testimonials/index.php', 'testimonials'=>$testimonials, 'builder' => $builder,];
      }

      public function storeTestimonial()
      {
          TokenService::check('user');

          $cleanedUpInputs = self::escapeInputs('testimonial', 'captcha');

          $errors = (new CheckForm())->checkAddTestimonialForm($cleanedUpInputs);

          if(!empty($errors) ) {

              $builder = (new DB())->printCaptcha();

              return ['view' => '/views/testimonials/form.php', 'errors'=>$errors,  'ajax' => true , 'builder' => $builder];
          }

          (new Testimonial())->saveTestimonial($this->stripTags($_POST['testimonial']));


          return  ['view' => '/views/testimonials/addSuccess.php','ajax' => true];
      }

      public function search()
      {
        echo 'this is result of index/search
        Журналіст був затриманий 25 березня, коли висвітлював розгін силовиками в центрі Мінська зібралися відсвяткувати День Волі – 99-у річницю проголошення Білоруської Народної Республіки у 1918 році, – повідомляє прес-служба Білоруської асоціації журналістів.

Борозенко після затримання був засуджений судом Московського району білоруської столиці до 15 діб адміністративного арешту за звинуваченням у дрібному хуліганстві.

Свідчив в суді співробітник міліції Варіончик заявив, що Борозенко вигукував нецензурні вирази й не представився журналістом. Представник Омону Михалевич заявив суду, що Борозенко висловлював невдоволення декретом президента Лукашенка про попередження соціального утриманства, що іменується в народі “декретом про дармоїдство”.';
        exit();
      }





  }
  