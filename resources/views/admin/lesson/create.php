<section class="centered">

    <h2 class="header-h2"><?= $createLessonL ?></h2>

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


        <?php include PATH_SITE.'/resources/views/admin/lesson/formFields.php'; ?>

        <button type="submit"><?= $createLessonL ?></button>


    </form>
</section>