<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'App\\Controllers\\Admin' => $baseDir . '/app/protected/controllers/admin.php',
    'App\\Controllers\\Category' => $baseDir . '/app/protected/controllers/category.php',
    'App\\Controllers\\Error_404' => $baseDir . '/app/protected/controllers/404.php',
    'App\\Controllers\\Index' => $baseDir . '/app/protected/controllers/index.php',
    'App\\Controllers\\Lesson' => $baseDir . '/app/protected/controllers/lesson.php',
    'App\\Controllers\\SignUp' => $baseDir . '/app/protected/controllers/signUp.php',
    'App\\Controllers\\Testimonials' => $baseDir . '/app/protected/controllers/testemonials.php',
    'App\\Core\\AdminController' => $baseDir . '/app/core/admincontroller.php',
    'App\\Core\\Application' => $baseDir . '/app/core/application.php',
    'App\\Core\\BaseController' => $baseDir . '/app/core/basecontroller.php',
    'App\\Core\\DataBase' => $baseDir . '/app/core/database.php',
    'App\\Core\\HihgLevelDependacy\\MainDispatcher' => $baseDir . '/app/core/highLevelDependancy/maindispatcher.php',
    'App\\Core\\HihgLevelDependacy\\Prozess_Image' => $baseDir . '/app/core/highLevelDependancy/prozess_image.php',
    'App\\Models\\AdminModel' => $baseDir . '/app/protected/models/admin.php',
    'App\\Models\\Avatar' => $baseDir . '/app/protected/models/avatar.php',
    'App\\Models\\Category' => $baseDir . '/app/protected/models/categories.php',
    'App\\Models\\CheckForm' => $baseDir . '/app/protected/models/checkForm.php',
    'App\\Models\\Comment' => $baseDir . '/app/protected/models/comment.php',
    'App\\Models\\Images' => $baseDir . '/app/protected/models/images.php',
    'App\\Models\\Index' => $baseDir . '/app/protected/models/index.php',
    'App\\Models\\Lesson' => $baseDir . '/app/protected/models/lessons.php',
    'App\\Models\\SignUp' => $baseDir . '/app/protected/models/signUp.php',
    'App\\Models\\Testemonial' => $baseDir . '/app/protected/models/testemonials.php',
    'Gregwar\\Captcha\\CaptchaBuilder' => $vendorDir . '/gregwar/captcha/CaptchaBuilder.php',
    'Gregwar\\Captcha\\CaptchaBuilderInterface' => $vendorDir . '/gregwar/captcha/CaptchaBuilderInterface.php',
    'Gregwar\\Captcha\\ImageFileHandler' => $vendorDir . '/gregwar/captcha/ImageFileHandler.php',
    'Gregwar\\Captcha\\PhraseBuilder' => $vendorDir . '/gregwar/captcha/PhraseBuilder.php',
    'Gregwar\\Captcha\\PhraseBuilderInterface' => $vendorDir . '/gregwar/captcha/PhraseBuilderInterface.php',
);
