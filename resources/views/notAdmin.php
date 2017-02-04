<?php

if(!isset($_SESSION['admin'])): ?>

    <style type="text/css">
        .login_form {width:360px;   margin:100px auto; padding:10px; border:1px solid #000000 }
    </style>

    <a href="/<?= \Lib\HelperService::currentLang() ?>"><?= $backToSiteL ?></a>
    <div class="login_form">
        <h3><?= $adminEntryTitleL ?></h3>



                <form  method="POST" action="/<?= \Lib\HelperService::currentLang() ?>admin">
                    <input type="hidden" name="_token" value="<?php \Lib\TokenService::printTocken('enterAdmin') ?>">
                    <p><label for="login"><?= $loginTitleL ?></label><br>
                        <input   name="login" id="login" type="text"  maxlength="25" autofocus > </p>
                    <p><label for="password"><?= $passwordL ?></label><br>
                        <input   name="password" id="password" type="password" maxlength="20" > </p>
                    <!--<p><input type="checkbox" id="remember_me" name="remember_me" >
                        <label for="remember_me">Remember me</label></p>-->
                    <br>
                    <p><input  type="submit" value="OK"></p>

                </form>


        </div><!--login




<?php endif; ?>

