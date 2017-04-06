<section class="breadcrumbs">

    <a href="/<?= \Lib\HelperService::currentLang() ?>" class="breadcrumb__item"><?=  $mainPageL ?></a>  =>
    <span class="breadcrumb__item--current"><?=  $seriesBeadcrumbsL ?></span>

</section>


<?php if($seriesWithLessons): ?>
    <h2 class="content-zone__header"><?= $categoryWithSeries->title ?></h2>
    <h3 class="content-zone__subheader"><?php  if($categoryWithSeries->count_series): ?>

            <?= $categoryWithSeries->count_series ?>
            <?= $categoryWithSeries->count_series == 1 ? $serieL: $seriesL; ?>

        <?php endif; ?>

    </h3>


        <section class="series-block">
          <?php foreach($seriesWithLessons as $serie): ?>

              <div class="series-block__item">
                  <span class="series-block__item-level"><?php $level = 'level'.$serie->upgrading_skill.'L'; echo $$level ?></span>
                    <img src="<?= ROOT ?>/uploads/seriesIcons/<?= $serie->icon ?>" alt="" class="series-block__item-img">
                  <a href="/<?= \Lib\HelperService::currentLang() ?>category/serie?id=<?= $serie->id ?>"><h3 class="series-block__item-title"><?= $serie->title ?></h3></a>
                  <span class="series-block__item-bottom-lesson"><?= $serie->lessons_count ?>
                    <?= $serie->lessons_count == 1 ? $lessonL: $lessonsL ?>
                  </span>
              </div>

          <?php endforeach; ?>
        </section>
<?php else: ?>

    <h2 class="header__h2"><?= $nothingFound ?></h2>

<?php endif; ?>



<?php if($extraLessonsAmount): ?>
    <div class="content-zone__subheader">
        <?= $extraLessonsAmount ?>
        <?= $extraLessonsAmount == 1 ? $extraLessonL : $extraLessonsL; ?>
    </div>
<?php endif; ?>
<?php if($extraLessons): ?>
    <section class="lessons-block">
        <?php foreach($extraLessons as $lesson): ?>

            <div class="lessons-block__item">
                <a href="/<?= \Lib\HelperService::currentLang() ?>lesson?id=<?= $lesson->id ?>" class="lessons-block__item-link"><?= $lesson->title ?></a>
                <img  class="lessons-block__item-icon" src="<?= ROOT ?>/uploads/lessonsIcons/<?= $lesson->icon ?>">
            </div>

        <?php endforeach ?>
    </section>
<?php endif ?>
