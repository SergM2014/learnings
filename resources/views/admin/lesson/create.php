<section class="centered">

    <h2 class="header-h2">This is create page</h2>

    <div class="form-field">
        <label class="form-field__label"><?= $iconL ?></label><br>
        <small class="form-field__error"><?= @$errors['lessonsIcon'] ?></small>
        <?php
            $givenImage = null;
            $imageCustomType = 'lessonsIcon';
            $path = ROOT."/uploads/lessonsIcons/"; ?>

        <?php include PATH_SITE.'/resources/views/admin/partials/addImage.php'; ?>
    </div>


    <div class="form-field">
        <label  class="form-field__label"><?= $fileL ?></label><br>
        <small class="form-field__error"><?= @$errors['downloadFile'] ?></small>

        <?php include PATH_SITE.'/resources/views/admin/partials/addFile.php'; ?>
    </div>





    <form class="lesson-form" method="post" action = "/admin/lesson/store">

        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">

        <div class="form-field">
            <label for="title" class="form-field__label"><?= $titleL ?></label><br>
            <input type="text" name="title" id="title" value="">
            <small class="form-field__error"><?= @$errors['title'] ?></small>
        </div>

        <div class="form-field">
            <label for="excerpt" class="form-field__label"><?= $excerptL ?></label>
            <textarea name="excerpt" id="excerpt" rows="10" cols="40"></textarea>
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

                <label><input type="radio" name="free_status" value="1" checked><?= $freeL ?></label>
                <label><input type="radio" name="free_status" value="0"><?= $notFreeL ?></label>
        </div>

        <button type="submit"><?= $createLessonL ?></button>


    </form>
</section>