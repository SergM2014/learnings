<section class="breadcrumbs">

    <a href="/" class="breadcrumb__item"><?=  $mainPageL ?></a>  =>
    <span class="breadcrumb__item--current"><?=  $lessonL ?></span>

</section>


<link href="//vjs.zencdn.net/5.11/video-js.min.css" rel="stylesheet">
<script src="//vjs.zencdn.net/5.11/video.min.js"></script>

<section class="view-container">

   <!-- <video class="view-container-video"  controls="controls" poster = "/uploads/video/1.png" >-->
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

        <button id="download_lesson" class="lesson-comments__button">Download</button>
        <button class="lesson-comments__button"><a class="lesson-comments__button-link" href="/login">Login</a></button>
        <h3 class="under-video__container-h3"><?= $commentsL ?> (<?= count($comments) ?>)</h3>


    </section>
    <section class="related-lessons">
        <h3 class="under-video__container-h3"><?= $underVideoLessonsL ?></h3>

        <?php foreach ($relatedLessons as $lesson): ?>
        <div class="related-lessons__item">
            <a href="/lesson?id=<?= $lesson->id ?>" class="related-lessons__item-link">
                <img src="/uploads/lessonsIcons/<?= $lesson->icon ?>" alt="" class="related-lessons__item-img">
                <span class="related-lessons__item-link-title"><?= $lesson->title ?></span>
            </a>
        </div>
        <?php endforeach; ?>

    </section>
</section>
