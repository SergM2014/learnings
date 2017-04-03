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
        <link href="/assets/css/admin.css" rel="stylesheet">
    <?php endif; ?>

    </head>
    <body>

    <?php if(@!$noTemplate): ?>


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

                     <li class="main-header__menu-item"><a href="/<?= \Lib\HelperService::currentLang() ?>" class="main-header__menu-item-link"><?= $backToSiteL ?></a></li>



                        <div class="main-header__right-side">
                             <li class="main-header__admin"> <a href="/<?= \Lib\HelperService::currentLang() ?>admin/out" ><?= $_SESSION['user']['login'].' / '. $exitL ?></a></li>

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

