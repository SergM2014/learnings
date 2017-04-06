<section class="breadcrumbs">

    <a href="/" class="breadcrumb__item"><?=  $mainPageL ?></a>  =>
    <a href="/category?id=<?= $categoryId ?>" class="breadcrumb__item"><?=  $seriesBeadcrumbsL ?></a> =>
    <span class="breadcrumb__item--current"><?=  $seriesLessonsL ?></span>

</section>



<h2 class="content-zone__header"><?= $seriesLessonsL ?></h2>
<h3 class="content-zone__subheader"><?php  if($serieLessonsAmount >0): ?>

        <?= $serieLessonsAmount ?>
        <?= $serieLessonsAmount == 1 ? $lessonL: $lessonsL; ?>

    <?php endif; ?>

</h3>

<?php if($lessons): ?>
    <section class="lessons-block--seried">
      <?php foreach($lessons as $lesson): ?>
          <div class="lessons-block__item">
              <a href="/lesson?id=<?= $lesson->id ?>" class="lessons-block__item-link"><?= $lesson->title ?></a>
              <img  class="lessons-block__item-icon" src="<?= ROOT ?>/uploads/lessonsIcons/<?= $lesson->icon ?>">
          </div>

      <?php endforeach; ?>
    </section>

<?php else: ?>

    <h2 class="header__h2"><?= $nothingFound ?></h2>

<?php endif; ?>



<?php if($extraLessonsAmount): ?>

    <h3 class="content-zone__subheader">
        <?= $extraLessonsAmount ?>
        <?= $extraLessonsAmount == 1 ? $extraLessonL : $extraLessonsL; ?>
    </h3>
<?php endif; ?>
<?php if($extraLessons): ?>
    <section class="lessons-block">
        <?php foreach($extraLessons as $lesson): ?>

            <div class="lessons-block__item">
                <a href="/lesson?id=<?= $lesson->id ?>" class="lessons-block__item-link"><?= $lesson->title ?></a>
                <img  class="lessons-block__item-icon" src="<?= ROOT ?>/uploads/lessonsIcons/<?= $lesson->icon ?>">
            </div>

        <?php endforeach ?>
    </section>
<?php endif ?>



