
    <fieldset class="subscribtion-form">
        <h1 class="subscribtion-form__titel"><?= $registerL ?></h1>
            <form action="/subscription/store" method="post">
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
                        <?= $repeatPasswordL ?> <br>
                        <input type="password" name="password2" value = "<?= @$_POST['password2'] ?>" >
                        <p><small class="error"><?= @$errors['password2'] ?></small></p>
                    </label>
                </div>

                <div class="subscribtion-form__field-block">
                    <label>
                        <?= $enterEmailL ?> <br>
                        <input type="text" name="email" value = "<?= @$_POST['email'] ?>" >
                        <p><small class="error"><?= @$errors['email'] ?></small></p>
                    </label>
                </div>
                <br>
                <p>
                    <button class="subscribtion-form__button">OK</button>
                </p>
            </form>

    </fieldset>

