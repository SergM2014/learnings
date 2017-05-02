<div class="show-lesson">

    <h2 class="header-h2"><?= $lesson->title ?></h2>


    <div class="show-lesson__field">
        <img src="/uploads/lessonsIcons/<?= $lesson->icon ?>" alt="">

    </div>

    <?php if(@$lesson->serie_title): ?>
        <div class="show-lesson__field"><span class="show-lesson__field-title"><?= $serieTitleL ?> : </span><?= $lesson->serie_title ?></div>
    <?php endif; ?>

    <div class="show-lesson__field"><span class="show-lesson__field-title"><?= $categoryTitleL ?> : </span><?= $lesson->category_title ?></div>
    <div class="show-lesson__field"><span class="show-lesson__field-title"><?= $excerptL ?> : </span><?= $lesson->excerpt ?></div>
    <div class="show-lesson__field"><span class="show-lesson__field-title"><?= $videoTitleL ?> : </span><?= $lesson->file?? $noVideoL ?></div>
    <div class="show-lesson__field"><span class="show-lesson__field-title"><?= $payStatusL ?> : </span><?= $lesson->free_status == 1? $freeL: $notFreeL; ?></div>

    <div class="show-lesson__footer">
        <a href="<?= $_SERVER['HTTP_REFERER'] ?>"><?= $backL ?></a>
        <a href="<?= \Lib\HelperService::currentLang() ?>/admin/lesson/edit?id=<?= $lesson->id ?>"><?= $updateL ?></a>
    </div>

</div>
