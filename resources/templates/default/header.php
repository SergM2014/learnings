<!DOCTYPE html>
<html lang="<?= $attrLang ?>">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Learning Resourse">
    <meta name="description" content="Learning Resourse">
    <title><?= $siteDescriptionL ?></title>


	<link href="<?= ROOT ?>/assets/css/default.css?ver=<?= time() ?>" rel="stylesheet">



    </head>
    <body>
      <div class="container">
        <?php if(@!$noTemplate): ?>
            <header class="main-header ">

                <nav class="main-header__nav ">


                    <div id="mainHeaderTouchBtn" class="main-header__touch-btn">
                        <div class="main-header__icon-bar"></div>
                        <div class="main-header__icon-bar"></div>
                        <div class="main-header__icon-bar"></div>
                    </div>

                     <ul id="mainHeaderMenu" class="main-header__menu" >
                         <li class="main-header__menu-item"><a href="/<?= \Lib\HelperService::currentLang() ?>/#"><?= $ourBrandL ?></a></li>
                         <li class="main-header__menu-item"><a href="/<?= \Lib\HelperService::currentLang() ?>"><?= $mainPageL ?></a></li>

                    </ul>
                      <?php if(@!isset($_SESSION['user']['login'])): ?>
                        <a class="main-header__admin" href="/<?= \Lib\HelperService::currentLang() ?>subscription/signIn">
                            <?= $enterAdminL  ?>
                        </a>
                    <?php else:?>

                        <form action="/<?= \Lib\HelperService::currentLang() ?>subscription/signOut"  method="post" class="main-header__admin">
                            <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('user') ?>">
                            <button type="submit" class="main-header__admin-btn"> <?= $_SESSION['user']['login'].'/'.$exitL  ?></button>
                        </form>


                          <a class="main-header__admin" href="/<?= \Lib\HelperService::currentLang() ?>subscription/profile">
                              <?= $profileL  ?>
                          </a>

                    <?php endif; ?>


                    <?php if(@!$_SESSION['user']['login']): ?>
                         <a class="main-header__admin" href="/<?= \Lib\HelperService::currentLang() ?>subscription/signUp""><?= $registerL ?></a>
                    <?php endif; ?>
                    <?php //get the given languages array
                    $langs = \Lib\HelperService::prozessLangArray(); ?>

                    <ul class="main-header__language-select"><?= \Lib\HelperService::getCurrentLanguageTitle() ?>
                        <div class="main-header__language-select-dropdown hidden">
                            <?php foreach($langs as $key => $value): ?>

                                <li><a href="/<?= \Lib\HelperService::overrideLangInUrl($key) ?>"><?= $value ?></a></li>
                            <?php endforeach; ?>
                        </div>
                    </ul>

                    <div id="mainHeaderSearchContainer" class="main-header__search-container" >
                        <span class="main-header__search-field-label"> <?= $searchL ?></span>
                        <input type="text" name="search" id="search" class="main-header__search-field"  maxlength="20"  >

                    </div>

                 </nav>


            </header><!--/site-header-->
        <?php endif; ?>
       <section class="content">

