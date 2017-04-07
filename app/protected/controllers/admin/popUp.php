<?php

namespace App\Controllers\Admin;



use App\Core\BaseController;






class PopUp  extends BaseController
{

    public function lesson()
    {
        return ['view' => 'views/admin/popUp/lesson.php', 'ajax' => true ];
    }
}