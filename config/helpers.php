<?php

    /**
     * define if document root is in public folder or not
     * @return string
     */
     function getDocumentRoot()

        {
            $arr = explode('/', $_SERVER['DOCUMENT_ROOT']);
            if(in_array('public', $arr)){
            array_pop($arr);
            $document_root = implode('/', $arr);
            return $document_root;
            }
            return $_SERVER['DOCUMENT_ROOT'];
        }

    function dd($arg)
        {
            echo "<br>";
            echo "<pre>";
             var_dump($arg);
             echo "<br>";

            exit();
        }



    function subscribedUser()
    {
         $activeSubscribtion = $_SESSION['user']['activeSubscribtion']?? false;
         return !!$activeSubscribtion;
    }

    function loggedInUser()
    {
        $loggedInUser = $_SESSION['user']['login']?? false ;
        return !!$loggedInUser;
    }

   function displayPreviewImage($givenImage, $imageCustomType, $path)
   {
        if(@!$givenImage) {
           return $imageCustomType == 'avatar'? '/img/noavatar.jpg' : '/img/nophoto.jpg';
        }
        return $path.$givenImage;
   }