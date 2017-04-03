<?php

namespace  App\Core;

use App\Core\HihgLevelDependacy\MainDispatcher;


class Application extends MainDispatcher {

  

    /**
     *
     * fire off appointed controller
     * @param $controller
     * @return mixed
     */
    public function runController($controller){

        if( isset($controller['admin'])){$class = '\App\Controllers\Admin\\'; } else {
            {$class = '\App\Controllers\\'; }
        }


        $nameContr = $class.ucfirst($controller[0]);

        $action = $controller[1];

        $contr = new $nameContr($controller);

        $data=call_user_func(array($contr, $action));

        return $data;

    }


    /**
     *
     * get the way of the view
     * @param $view
     * @return string
     */
    public function getView ($view)//получить представление для контролера $view
    {
        $view_path = '/resources/'.$view;

        return PATH_SITE.$view_path;
    }


    /**
     * includes a template
     *
     * @return string
     */
    public function putTemplate()
    {
        if(is_array($this->url)) {
            $result = in_array('admin', $this->url);
        } else {
            $result = preg_match('/^admin/i', $this->url);
        }

        if($result ) return 'templates/admin';
        return 'templates/default/';
    }





}