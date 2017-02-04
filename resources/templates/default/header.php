<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="E shop ">
    <meta name="description" content="training shop">
    <title><?= $siteDescriptionL ?></title>


	<link href="/assets/css/default.css?ver=<?= time() ?>" rel="stylesheet">



    </head>
    <body>
    <div class="container">

        <header class="main-header ">





            <nav class="main-header__nav ">

                <a href="/<?= \Lib\HelperService::currentLang() ?>#" class="main-header__logo "><?= $ourBrandL ?></a>

                <div class="main-header__touch-button">
                    <span class="main-header__icon-bar"></span>
                    <span class="main-header__icon-bar"></span>
                    <span class="main-header__icon-bar"></span>
                </div>

                 <ul class="main-header__menu" >
                     <li class="main-header__menu-item"><a href="/<?= \Lib\HelperService::currentLang() ?>"><?= $mainPageL ?></a></li>

                </ul>


                <a class="main-header__admin" href="/<?= \Lib\HelperService::currentLang() ?>signIn"><?php if(isset($_SESSION['admin']['login'])){echo $_SESSION['admin']['login'];}else {echo "$enterAdminL";};  ?></a>
                <a class="main-header__admin" href="/<?= \Lib\HelperService::currentLang() ?>register""><?= $registerL ?></a>

                <?php //get the given languages array
                $langs = \Lib\HelperService::prozessLangArray(); ?>

                <ul class="main-header__language-select"><?= \Lib\HelperService::getCurrentLanguageTitle() ?>
                    <div class="main-header__language-select-dropdown hidden">
                        <?php foreach($langs as $key => $value): ?>

                            <li><a href="/<?= \Lib\HelperService::overrideLangInUrl($key) ?>"><?= $value ?></a></li>
                        <?php endforeach; ?>
                    </div>
                </ul>

                <div class="main-header__search-container" >
                    <span class="main-header__search-field-label"> <?= $searchL ?></span>
                    <input type="text" name="search" id="search" class="main-header__search-field"  maxlength="20" autofocus >
                    <aside class="main-header__search-result-box--hidden" id="search-results"></aside>
                </div>

             </nav>


        </header><!--/site-header-->

       <section class="content">

