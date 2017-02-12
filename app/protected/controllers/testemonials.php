<?php

namespace App\Controllers;



use App\Core\BaseController;

use App\Models\Testemonial as TestimonialsModel;



class Testimonials  extends BaseController
  {


      /**
       * fire off he index action
       *
       * @return array
       */
    public function show()
	{
        $testimonials = (new TestimonialsModel())->getAll();



      return ['view'=>'views/testimonials.php', 'testimonials'=>$testimonials];
    }




  }
  