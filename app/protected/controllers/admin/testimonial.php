<?php

namespace App\Controllers\Admin;



use App\Core\AdminController;

use App\Models\Testimonial as TestimonialModel;
use App\Models\AdminModel;
use Lib\TokenService;
use App\Models\CheckForm;

class Testimonial  extends AdminController {

    public function index()
    {
        $testimonials = TestimonialModel::getAll(true);
        $pages = TestimonialModel:: countPages('true');
        $tableCounter = AdminModel::getTableCounter();

        return ['view'=>'views/admin/testimonial/index.php', 'testimonials' => $testimonials, 'pages' => $pages, 'counter' => $tableCounter ];
    }

    public function edit ($errors = null )
    {
        $testimonial = TestimonialModel::getOneTestimonial();
        $_SESSION['editTestimonial'] = true;


        return ['view'=>'views/admin/testimonial/edit.php', 'testimonial' => $testimonial, 'errors'=> $errors ];
    }


    public function update()
    {
        TokenService::check('admin');

        if(!@$_SESSION['editTestimonial']) return $this->index();

        $cleanedUpInputs = self::escapeInputs('testimonial');

        $errors = CheckForm::checkTestimonialForm($cleanedUpInputs);


        if(!empty($errors) ) {

            return $this->edit($errors);
        }

        TestimonialModel::updateTestimonial($this->stripTags($_POST['testimonial']));

        unset ($_SESSION['editTestimonial']);

        return  ['view' => '/views/admin/testimonial/updateSuccess.php'];
    }


    public function publish()
    {
        TokenService::check('admin');
        $response = TestimonialModel::publish();
        echo json_encode($response);
        exit();
    }

    public function unpublish()
    {
        TokenService::check('admin');
        $response = TestimonialModel::unpublish();
        echo json_encode($response);
        exit();
    }



}
  