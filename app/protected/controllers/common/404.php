<?php

namespace App\Controllers;

use App\Core\BaseController;

class Error_404 extends BaseController
{
    function index(){
        return ['view'=>'views/common/404.html'/*,'no_footer_js'=>'true'*/];
    }
}