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
          var_dump($arg);
            exit();
        }