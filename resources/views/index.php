<section class="breadcrumbs">

    <span class="breadcrumb__item--current"><?=  $mainPageL ?></span>

</section>



<h1 class="main-header__h1"><?= $mainTitleExplanationL ?></h1>


<section id="categories-block" class="categories-block">
    <?php foreach ($categories as $category) : ?>

        <div class="categories-block__item">
            <a href="/<?= \Lib\HelperService::currentLang() ?>category?id=<?= $category->id ?>">
                 <h3><?= $category->title ?></h3>
            </a>
            <?php if ($category->count_series): ?>

                <?=  $category->count_series ?>
                  <?=  $category->count_series == 1 ? $serieL : $seriesL; ?>

            <?php endif; ?>
        </div>

    <?php endforeach; ?>
</section>

<section id="lessons-block" class="lessons-block">

    <?php foreach ($randomLessons as $lesson): ?>

        <a href="/<?= \Lib\HelperService::currentLang() ?>lesson?id=<?= $lesson->id ?>">
            <div class="lessons-block__item"><h3><?= $lesson->title ?></h3>
                <img src="/uploads/lessonsIcons/<?= $lesson->icon ?>" class="lessons-block__item-icon" alt="">
            </div>

        </a>


    <?php endforeach; ?>

</section>

<section id="testimonials-block" class="testimonials-block">

    <h3><?= $testimonialsL ?></h3>

    <?php foreach ($randomTestimonials as $testimonial): ?>

        <div class="testimonials-block__item"><?= $testimonial->testimonial ?></div>

    <?php endforeach; ?>

    <div id="" class="testimonials-block__further">
        <a href="/<?= \Lib\HelperService::currentLang() ?>index/testimonials">
             <span id="" class="testimonials-block__furher-title"><?= $lookThroughTestimonialsL ?></span>
        </a>
    </div>

</section>

<section id="subscription-block" class="subscription-block">
    <?= $planDescription ?>
</section>




<div class="clearfix"></div>

