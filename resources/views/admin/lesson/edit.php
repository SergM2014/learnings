<section class="centered">

    <h2 class="header-h2"><?= $updateLessonL.' '.$lesson->id ?></h2>

    <div class="form-field">
        <label class="form-field__label"><?= $iconL ?></label><br>

        <?php

        if(@!$_SESSION['lessonsIcon'] AND @$_POST['action']== 'handleLessonIcon'){
            $givenImage = null;
        } else {
            $givenImage = $_SESSION['lessonsIcon'] = $lesson->icon;
        }

        $imageCustomType = 'lessonsIcon';
        $path = ROOT."/uploads/lessonsIcons/"; ?>

        <?php include PATH_SITE.'/resources/views/admin/partials/addImage.php'; ?>

        <small class="form-field__error"><?= @$errors['lessonsIcon'] ?></small>
    </div>


    <div class="form-field">
        <label  class="form-field__label"><?= $fileL ?></label><br>

        <?php $_SESSION['downloadFile']= $lesson->file?? null; ?>

        <?php include PATH_SITE.'/resources/views/admin/partials/addFile.php'; ?>

        <small class="form-field__error"><?= @$errors['downloadFile'] ?></small>
    </div>


    <form class="lesson-form" method="post" action = "/admin/lesson/update">

        <input type="hidden" name="lessonId" value="<?= $lesson->id?? $_POST['lessonId']?? @$_GET['id'] ?>"/>

        <?php include PATH_SITE.'/resources/views/admin/lesson/formFields.php'; ?>

        <button type="submit"><?= $updateLessonL ?></button>


    </form>
</section>