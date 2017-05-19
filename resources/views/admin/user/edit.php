<section class="profile-block">

    <h1 class="profile-header__h1"><?= $editProfileL ?></h1>
    <?php


    if(@!$_SESSION['avatar'] AND @$_POST['action']== 'handleUser'){
        $givenImage = null;
    } elseif (@$_SESSION['avatar'] AND @$_POST['action']== 'handleUser'){
        $givenImage = $_SESSION['avatar'];
    }

    else {
        $givenImage = $_SESSION['avatar'] = $user->avatar;
    }
    $imageCustomType = 'avatar';
    $path = '/uploads/avatars/';
    include   PATH_SITE.'/resources/views/admin/partials/addImage.php';

    ?>

    <form action="<?= \Lib\HelperService::currentLang() ?>/admin/user/update" method="post" >
        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">
        <input type="hidden" name="userId" value = "<?= $user->id ?>" >
        <input type="hidden" name="action" value = "handleUser" >
        <div class="subscribtion-form__field-block">
            <label class="form-field__label">
                <?= $changeNameL ?> <br>
                <input type="text" name="login" value = "<?=  @$_POST['login']?? @$user->login ?>" >
                <p><small class="error"><?= @$errors['login'] ?></small></p>
            </label>
        </div>
        <div class="subscribtion-form__field-block">
            <label class="form-field__label">
                <?= $changePasswordL ?> <br>
                <input type="password" name="password"  value = "<?=  @$_POST['password'] ?>" >
                <p><small class="error"><?= @$errors['password'] ?></small></p>
            </label>
        </div>
        <div class="subscribtion-form__field-block">
            <label class="form-field__label">
                <?= $repeatPasswordL ?> <br>
                <input type="password" name="password2" value = "<?= @$_POST['password2'] ?>" >
                <p><small class="error"><?= @$errors['password2'] ?></small></p>
            </label>
        </div>

        <div class="subscribtion-form__field-block">
            <label class="form-field__label">
                <?= $changeEmailL ?> <br>
                <input type="text" name="email" value = "<?=  @$_POST['email']?? @$user->email ?>" >
                <p><small class="error"><?= @$errors['email'] ?></small></p>
            </label>
        </div>

        <div class="subscribtion-form__field-block">
            <label class="form-field__label" for="role"><?= $changeRoleL ?>  </label>
            <br>
            <select name="role" id="role">
                <option value="3" <?= $user->upgrading_status == 3 ? 'selected': '' ?> >Superadmin</option>
                <option value="2" <?= $user->upgrading_status == 2 ? 'selected': '' ?>>Admin</option>
                <option value="1" <?= $user->upgrading_status == 1 ? 'selected': '' ?>>User</option>
            </select>
        </div>
        <br>
        <p>
            <button class="subscribtion-form__button">OK</button>
        </p>
    </form>



</section>