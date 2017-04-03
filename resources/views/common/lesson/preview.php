<img id="previewLessonCloseSign" class="preview-lesson__close-sign" src="/img/close.png" alt="">


    <img class="preview-lesson__icon" src="/uploads/lessonsIcons/<?= $lesson->icon ?>" alt="">
    <div class="preview-lesson__excerpt">
        <?= $lesson->excerpt ?>
    </div>
    <div class="preview-lesson__link-container">
        <a class="preview-lesson__link" href="/<?= \Lib\HelperService::currentLang() ?>lesson?id=<?= (int)$lesson->id ?>"><?= $gotoLessonL ?></a>
    </div>

    <div class="preview-lesson__close-btn-container">
        <button id="previewLessonCloseBtn" class="preview-lesson__close-btn" type="button"><?= $closeL ?></button>
    </div>






