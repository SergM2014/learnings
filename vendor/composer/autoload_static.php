<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit14fc953014b49481d3c9d0477a55e3f8
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'Gregwar\\Captcha\\' => 16,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Gregwar\\Captcha\\' => 
        array (
            0 => __DIR__ . '/..' . '/gregwar/captcha',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'App\\Controllers\\Admin' => __DIR__ . '/../..' . '/app/protected/controllers/admin.php',
        'App\\Controllers\\Category' => __DIR__ . '/../..' . '/app/protected/controllers/category.php',
        'App\\Controllers\\Error_404' => __DIR__ . '/../..' . '/app/protected/controllers/404.php',
        'App\\Controllers\\Index' => __DIR__ . '/../..' . '/app/protected/controllers/index.php',
        'App\\Controllers\\Lesson' => __DIR__ . '/../..' . '/app/protected/controllers/lesson.php',
        'App\\Controllers\\SignUp' => __DIR__ . '/../..' . '/app/protected/controllers/signUp.php',
        'App\\Controllers\\Testimonials' => __DIR__ . '/../..' . '/app/protected/controllers/testemonials.php',
        'App\\Core\\AdminController' => __DIR__ . '/../..' . '/app/core/admincontroller.php',
        'App\\Core\\Application' => __DIR__ . '/../..' . '/app/core/application.php',
        'App\\Core\\BaseController' => __DIR__ . '/../..' . '/app/core/basecontroller.php',
        'App\\Core\\DataBase' => __DIR__ . '/../..' . '/app/core/database.php',
        'App\\Core\\HihgLevelDependacy\\MainDispatcher' => __DIR__ . '/../..' . '/app/core/highLevelDependancy/maindispatcher.php',
        'App\\Core\\HihgLevelDependacy\\Prozess_Image' => __DIR__ . '/../..' . '/app/core/highLevelDependancy/prozess_image.php',
        'App\\Models\\AdminModel' => __DIR__ . '/../..' . '/app/protected/models/admin.php',
        'App\\Models\\Avatar' => __DIR__ . '/../..' . '/app/protected/models/avatar.php',
        'App\\Models\\Category' => __DIR__ . '/../..' . '/app/protected/models/categories.php',
        'App\\Models\\CheckForm' => __DIR__ . '/../..' . '/app/protected/models/check_form.php',
        'App\\Models\\Comment' => __DIR__ . '/../..' . '/app/protected/models/comment.php',
        'App\\Models\\Images' => __DIR__ . '/../..' . '/app/protected/models/images.php',
        'App\\Models\\Index' => __DIR__ . '/../..' . '/app/protected/models/index.php',
        'App\\Models\\Lesson' => __DIR__ . '/../..' . '/app/protected/models/lessons.php',
        'App\\Models\\SignUp' => __DIR__ . '/../..' . '/app/protected/models/signUp.php',
        'App\\Models\\Testemonial' => __DIR__ . '/../..' . '/app/protected/models/testemonials.php',
        'Gregwar\\Captcha\\CaptchaBuilder' => __DIR__ . '/..' . '/gregwar/captcha/CaptchaBuilder.php',
        'Gregwar\\Captcha\\CaptchaBuilderInterface' => __DIR__ . '/..' . '/gregwar/captcha/CaptchaBuilderInterface.php',
        'Gregwar\\Captcha\\ImageFileHandler' => __DIR__ . '/..' . '/gregwar/captcha/ImageFileHandler.php',
        'Gregwar\\Captcha\\PhraseBuilder' => __DIR__ . '/..' . '/gregwar/captcha/PhraseBuilder.php',
        'Gregwar\\Captcha\\PhraseBuilderInterface' => __DIR__ . '/..' . '/gregwar/captcha/PhraseBuilderInterface.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit14fc953014b49481d3c9d0477a55e3f8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit14fc953014b49481d3c9d0477a55e3f8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit14fc953014b49481d3c9d0477a55e3f8::$classMap;

        }, null, ClassLoader::class);
    }
}
