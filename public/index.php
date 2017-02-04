<?php

use App\Core\Application;

    require_once "./../config/settings.php";

    $router = new Application();

    require_once PATH_SITE."/resources/languages/".$router->getCurrentLanguage().".php";

    $controller=$router->getController();

    extract($router->runController($controller), EXTR_OVERWRITE);


    require_once PATH_SITE."/resources/". $router->putTemplate()."/index.php";


