<section class="breadcrumbs">

    <a href="/" class="breadcrumb__item"><?=  $mainPageL ?></a>  =>
    <span class="breadcrumb__item--current"><?=  $lessonL ?></span>

</section>

<section class="view-container">
    <link href="//vjs.zencdn.net/5.11/video-js.min.css" rel="stylesheet">
    <script src="//vjs.zencdn.net/5.11/video.min.js"></script>

    <h2 class="lesson-header_h1"><?= $lesson->title ?></h2>

    <video
        id="my-player"
        class="video-js view-container-video"
        controls
        preload="auto"
        poster="//vjs.zencdn.net/v/oceans.png"
        data-setup='{}'>
        <source src="/uploads/video/<?= $lesson->file ?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>

        Элемент video не поддерживается вашим браузером.

    </video>

</section>

<section class="under-video__container">
    <section class="lesson-comments">

        <?php if(subscribedUser()): ?>

            <a download href="/uploads/video/<?= $lesson->file ?>"  class="lesson-comments__link-btn--toLoadContent" ><?= $downloadL ?></a>

        <?php endif; ?>

        <?php if(!loggedInUser()): ?>
             <button class="lesson-comments__button"><a class="lesson-comments__button-link" href="/subscribtion/signIn"><?= $loginL ?></a></button>
        <?php endif; ?>

        <h3 class="under-video__container-h3"><?= $commentsL ?> (<?= count($comments) ?>)</h3>

        <?php if(!!count($comments)): ?>



        <ul class="lesson-comments__items">
            <?= $commentsTreeStructure  ?>
        </ul>
        <?php endif; ?>

    </section>
    <section class="related-lessons">
        <h3 class="under-video__container-h3"><?= $underVideoLessonsL ?></h3>

        <?php foreach ($relatedLessons as $relatedLesson): ?>
        <div class="related-lessons__item">
            <a href="/lesson?id=<?= $relatedLesson->id ?>" class="related-lessons__item-link">
                <img src="/uploads/lessonsIcons/<?= $relatedLesson->icon ?>" alt="" class="related-lessons__item-img">
                <span class="related-lessons__item-link-title"><?= $relatedLesson->title ?></span>
            </a>
        </div>
        <?php endforeach; ?>

    </section>

</section>

<?php if(loggedInUser()): ?>

        <a name="addComment"></a>
        <?php include PATH_SITE.'/resources/views/comments/addComment.php'; ?>

<?php endif; ?>
