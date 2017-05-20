<a href="<?= \Lib\HelperService::currentLang() ?>/"><?= $backToSiteL ?></a>


    <fieldset class="subscribtion-form">
        <h1 class="subscribtion-form__titel"><?= $enterL ?></h1>
            <form action="<?= \Lib\HelperService::currentLang() ?>/subscription/login" method="post">
                <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('user') ?>">
                <div class="subscribtion-form__field-block">
                    <label>
                       <?= $enterNameL ?> <br>
                        <input type="text" name="login" value = "<?= @$_POST['login'] ?>" >
                        <p><small class="error"><?= @$errors['login'] ?></small></p>
                    </label>
                </div>
                <div class="subscribtion-form__field-block">
                    <label>
                        <?= $enterPasswordL ?> <br>
                        <input type="password" name="password"  value = "<?= @$_POST['password'] ?>" >
                        <p><small class="error"><?= @$errors['password'] ?></small></p>
                    </label>
                </div>

                <div class="subscribtion-form__field-block">
                    <label>
                        <input type="checkbox" name="rememberMe" >
                        <?= $rememberMeL ?>
                    </label>
                </div>



                <br>
                <p>
                    <button class="subscribtion-form__button">OK</button>
                </p>
            </form>

    </fieldset>

