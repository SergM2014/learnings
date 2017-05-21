<!DOCTYPE html>
<html lang="<?= $attrLang ?>">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Admin Part">
    <meta name="description" content="admin part">
    <title>Admin</title>

    <?php if(@!$noTemplate): ?>

        <link href="/assets/css/admin.css?ver=<?= time() ?>" rel="stylesheet">
    <?php endif; ?>

    </head>
    <body>

    <?php if(@!$noTemplate): ?>


    <div id="alertZone" class="alert-zone hidden">
        <img src="<?= ROOT ?>/img/small-close.png" id="closeAlert" class="close-alert-sign" alt="">
        <span id="alertZoneText" class="alert-zone__text">Here is alert text to be inserted</span>
    </div>


    <div class="container">

        <?php if(isset($_SESSION['admin']) ) : ?>

        <header class="main-header ">



            <h1 class="main-header__title--h1"><?= $youAreInAdminL ?></h1>


            <nav class="main-header__nav ">



                <div class="main-header__touch-button">
                    <span class="main-header__icon-bar"></span>
                    <span class="main-header__icon-bar"></span>
                    <span class="main-header__icon-bar"></span>
                </div>

                 <ul class="main-header__menu" >

                     <li class="main-header__menu-item"><a href="<?= \Lib\HelperService::currentLang() ?>/" class="main-header__menu-item-link"><?= $backToSiteL ?></a></li>
                     <li class="main-header__menu-item"><a href="<?= \Lib\HelperService::currentLang() ?>/admin/lesson" class="main-header__menu-item-link"><?= $lessonsTitlesL ?></a></li>
                     <li class="main-header__menu-item"><a href="<?= \Lib\HelperService::currentLang() ?>/admin/cluster" class="main-header__menu-item-link"><?= $category_serieTitleL ?></a></li>

                     <?php if($_SESSION['admin']['upgrading_status']>1): ?>
                         <li class="main-header__menu-item"><a href="<?= \Lib\HelperService::currentLang() ?>/admin/testimonial" class="main-header__menu-item-link"><?= $testimonialsL ?></a></li>
                         <li class="main-header__menu-item"><a href="<?= \Lib\HelperService::currentLang() ?>/admin/comment" class="main-header__menu-item-link"><?= $commentsL ?></a></li>
                     <?php endif; ?>

                     <li class="main-header__menu-item"><a href="<?= \Lib\HelperService::currentLang() ?>/admin/subscription" class="main-header__menu-item-link"><?= $subscriptionPlanL ?></a></li>
                     <?php if($_SESSION['admin']['upgrading_status']>2): ?>
                        <li class="main-header__menu-item"><a href="<?= \Lib\HelperService::currentLang() ?>/admin/user" class="main-header__menu-item-link"><?= $usersL ?></a></li>
                     <?php endif; ?>
                        <div class="main-header__right-side">

                             <li class="main-header__admin">
                                 <form action="<?= \Lib\HelperService::currentLang() ?>/admin/index/logOut" method="post">
                                     <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">

                                    <button type="submit"><?= $_SESSION['admin']['login'].' / '. $exitL ?></button>
                                 </form>

                             </li>

                             <li class="main-header__language-select">

                                 <?php $langs = \Lib\HelperService::prozessLangArray(); ?>

                                 <select name="language"  onchange="window.location.href=this.options[this.selectedIndex].value" >
                                     <option selected disabled>Language/Мова</option>

                                     <?php foreach ($langs as $key => $value): ?>
                                         <option VALUE="/<?= \Lib\HelperService::overrideLangInUrl($key) ?>"><?= $value ?></option>
                                     <?php endforeach; ?>

                                 </select>

                             </li>
                     </div>

                </ul>

             </nav>


        </header><!--/site-header-->

        <?php endif; ?>

       <section class="content">

    <?php endif; ?>

