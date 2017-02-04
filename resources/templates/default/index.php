<?php

    if(isset($ajax)){
        $view=$router->getView($view);
        include ($view);
        exit();
    }

    require_once "header.php";
    $view=$router->getView($view);

    include_once ($view);
    require_once "footer.php";

