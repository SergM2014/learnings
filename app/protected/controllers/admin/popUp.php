<?php

namespace App\Controllers\Admin;



use App\Core\BaseController;




class PopUp  extends BaseController
{

    public function lesson()
    {
        return ['view' => 'views/admin/popUp/showMenu.php', 'ajax' => true ];
    }




    public function drawDeleteLessonModal()
    {
        return ['view'=> '/views/admin/modalWindow/deleteLesson.php', 'ajax'=> true ];
    }


    public function serie()
    {
        return ['view' => 'views/admin/popUp/showSerieMenu.php', 'ajax' => true ];
    }


    public function category ()
    {
        return ['view' => 'views/admin/popUp/showCategoryMenu.php', 'ajax' => true ];
    }

    public function drawDeleteSerieModal()
    {
        return ['view'=> '/views/admin/modalWindow/deleteSerie.php', 'ajax'=> true ];
    }

    public function drawDeleteCategoryModal()
    {
        return ['view'=> '/views/admin/modalWindow/deleteCategory.php', 'ajax'=> true ];
    }


    public function testimonial()
    {
        return ['view' => 'views/admin/popUp/showTestimonialMenu.php', 'ajax' => true ];
    }

    public function comment()
    {
        return ['view' => 'views/admin/popUp/showCommentMenu.php', 'ajax' => true ];
    }


    public function user()
    {
        return ['view' => 'views/admin/popUp/showUserMenu.php', 'ajax' => true ];
    }

}