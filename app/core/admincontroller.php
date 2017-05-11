<?php

namespace App\Core;




use Lib\CheckFieldsService;
/**
 *
 * the class protect against unauthorirized access to the admin part
 * Class AdminController
 * @package App\Core
 */
class AdminController  extends BaseController{


    use CheckFieldsService;
    /**
     *
     * realisation of protection against the unauthorized access
     * AdminController constructor.
     */
    public function __construct()
    {
        session_start();

        if(!isset($_SESSION['admin'])){
            if (isset($_POST['ajax'])){
                echo json_encode(["message" => "you do not have permission to fire off the controller"]); exit();
            }
            header('Location: /admin');
        }

    }

}