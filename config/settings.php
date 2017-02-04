<?php

    include_once ('helpers.php');

    define('PATH_SITE', getDocumentRoot());

    define('NAMESITE','learnings');
    define('URL','http://learnings/');
    define('AMOUNTONPAGE',3);
    define('AMOUNTONPAGEADMIN',6);
    define('HOST', 'localhost'); //сервер
    define('USER', 'root'); //пользователь
    define('PASSWORD', '1'); //пароль
    define('NAME_BD', 'learnings');

    define('DEBUG_MODE', true ); //режим отладки

    define('IMAGE_TYPES',['image/gif', 'image/png', 'image/jpeg']);
	define('UPLOAD_FOLDER','/public/uploads/');

	define('LINKCOUNT',5);
	define('ADMINEMAIL', 'weisse@ukr.net');
    define('DEFAULT_LANG', 'uk');
    define('DEFAULT_LANG_TITLE', 'Українська');

    define ('LANG', ['uk=>Українська', 'en=>English']);
	
	date_default_timezone_set('Europe/Kiev');




    $directory = new DirectoryIterator(PATH_SITE.'/app/lib/');
    foreach ($directory as $file) {
        if($file->getExtension() == 'php') include_once PATH_SITE.'/app/lib/'.$file;
    }




    require PATH_SITE.'/vendor/autoload.php';

/**
 * if case of development all errors must be outputed ot screen
 */
	if (DEBUG_MODE){
					ini_set("display_errors","1");
					ini_set("display_startup_errors","1");
					ini_set('error_reporting', E_ALL);
	}








?>
