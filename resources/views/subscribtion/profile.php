<section class="profile-block">
    <?php

        $givenImage = $profileData->avatar;
        $imageCustomType = 'avatar';
        include   PATH_SITE.'/resources/views/partials/addImage.php';

        ?>

    <form action="/subscribtion/update" method="post">
        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('user') ?>">
        <input type="hidden" name="id" value = "<?= $profileData->id ?>" >
        <div class="subscribtion-form__field-block">
            <label>
                <?= $changeNameL ?> <br>
                <input type="text" name="login" value = "<?= @$profileData->login?? @$_POST['login'] ?>" >
                <p><small class="error"><?= @$errors['login'] ?></small></p>
            </label>
        </div>
        <div class="subscribtion-form__field-block">
            <label>
                <?= $changePasswordL ?> <br>
                <input type="password" name="password"  value = "<?=  @$_POST['password'] ?>" >
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
                <?= $changeEmailL ?> <br>
                <input type="text" name="email" value = "<?= @$profileData->email?? @$_POST['email'] ?>" >
                <p><small class="error"><?= @$errors['email'] ?></small></p>
            </label>
        </div>
        <br>
        <p>
            <button class="subscribtion-form__button">OK</button>
        </p>
    </form>


    <p>
        <?= $profileData->activeStatus == 1 ? $subscripedTillL.' '.$profileData->finalDate->toDateString() : $unsubscriped; ?>
    </p>

</section>

