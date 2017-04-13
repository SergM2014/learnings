<section class="centered">
    <h2 class="header-h2">This is create page</h2>

    <div class="form-field">
        <label class="form-field__label"><?= $iconL ?></label><br>
        <?php
            $givenImage = null;
            $imageCustomType = 'lessonsIcon';
            $path = ROOT."/uploads/lessonsIcons/"; ?>

        <?php include PATH_SITE.'/resources/views/admin/partials/addImage.php'; ?>
    </div>


    <div class="form-field">
        <label  class="form-field__label"><?= $fileL ?></label><br>

        <?php include PATH_SITE.'/resources/views/admin/partials/addFile.php'; ?>
    </div>





    <form class="lesson-form" method="post">

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
            <small class="form-field__error"><?= @$errors['serie'] ?></small>

            <input type="hidden" id="serie" name="serie">
            <input type="hidden" id="category" name="category">
            <ul id="serie" class="serie-selection">
                <?= $treeMenu ?>
            </ul>
        </div>




        <div class="form-field" >
            <p class="form-field__label"><?= $setPayedStatusL ?></p>

                <label><input type="radio" name="browser" value="1" checked><?= $freeL ?></label>
                <label><input type="radio" name="browser" value="0"><?= $notFreeL ?></label>
        </div>

        <button type="submit"><?= $createLessonL ?></button>


    </form>
</section>