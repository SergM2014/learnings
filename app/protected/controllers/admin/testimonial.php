<?php

namespace App\Controllers\Admin;



use App\Core\AdminController;



use Lib\TokenService;
use App\Models\Testimonial as TestimonialModel;
use App\Models\AdminModel;


class Testimonial  extends AdminController {

    public function index()
    {
        $model = new TestimonialModel();

        $testimonials = $model->getAll(true);
        $pages = $model->countPages('true');
        $tableCounter = (new AdminModel())->getTableCounter();

        return ['view'=>'views/admin/testimonial/index.php', 'testimonials' => $testimonials, 'pages' => $pages, 'counter' => $tableCounter ];
    }


  }
  