<section class="centered">

    <h2 class="header-h2">This is create page</h2>

    <div class="form-field">
        <label class="form-field__label"><?= $iconL ?></label><br>

        <?php
            $givenImage = $_SESSION['lessonsIcon']?? null;
            $imageCustomType = 'lessonsIcon';
            $path = ROOT."/uploads/lessonsIcons/"; ?>

        <?php include PATH_SITE.'/resources/views/admin/partials/addImage.php'; ?>
        <small class="form-field__error"><?= @$errors['lessonsIcon'] ?></small>
    </div>


    <div class="form-field">
        <label  class="form-field__label"><?= $fileL ?></label><br>


        <?php include PATH_SITE.'/resources/views/admin/partials/addFile.php'; ?>
        <small class="form-field__error"><?= @$errors['downloadFile'] ?></small>
    </div>





    <form class="lesson-form" method="post" action = "/admin/lesson/store">

        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">

        <div class="form-field">
            <label for="title" class="form-field__label"><?= $titleL ?></label><br>
            <input type="text" name="title" id="title" value="<?= @$_POST['title'] ?>" required >
            <small class="form-field__error"><?= @$errors['title'] ?></small>
        </div>

        <div class="form-field">
            <label for="excerpt" class="form-field__label"><?= $excerptL ?></label>
            <textarea name="excerpt" id="excerpt" rows="10" cols="40" required ><?= @$_POST['excerpt'] ?></textarea>
            <small class="form-field__error"><?= @$errors['excerpt'] ?></small>
        </div>


        <div class="form-field">
            <label  class="form-field__label"><?= $shooseSerieL ?></label>
            <small class="form-field__error"><?= @$errors['category'] ?></small>

            <input type="hidden" id="categoryField" name="category" value="<?= @$_POST['category'] ?>">
            <input type="hidden" id="serieField" name="serie" value="<?= @$_POST['serie'] ?>" >

            <ul id="serieList" class="serie-selection">
                <?= $treeMenu ?>
            </ul>
        </div>




        <div class="form-field" >
            <p class="form-field__label"><?= $setPayedStatusL ?></p>

                <label><input type="radio" name="free_status" value="1" <?= (@$_POST['free_status']== 1 OR @!$_POST['free_status']) ? 'checked': ''; ?> ><?= $freeL ?></label>
                <label><input type="radio" name="free_status" value="0" <?= @$_POST['free_status']== 0 ? 'checked': ''; ?> ><?= $notFreeL ?></label>
        </div>

        <button type="submit"><?= $createLessonL ?></button>


    </form>
</section>