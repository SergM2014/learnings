<section class="breadcrumbs">

    <a href="/" class="breadcrumb__item"><?=  $mainPageL ?></a>  =>
    <span class="breadcrumb__item--current"><?=  $testimonialsL ?></span>

</section>

<h2 class="content-zone__header"><?= $testemonialsL ?></h2>


<section class="testimonials-block__all">
    <?php foreach($testimonials as $testimonial): ?>

        <div class="testimonials-block__all-item">
            <img class="testimonials-block__all-item-avatar" src="/uploads/avatars/<?= $testimonial->avatar  ?>"
                 alt="" onerror="this.style.display='none'">
            <h4><?= $testimonial->login ?></h4>
            <?= $testimonial->testimonial ?>
            <p class="testimonials-block__all-item-time"><?= (new \DateTime($testimonial->added_at))->format('Y-m-d'); ?></p>
        </div>

    <?php endforeach; ?>
</section>


<?php if(loggedInUser()): ?>

    <section class="add-testimonials__block">

        <div class="add-testimonials__block-centered">


            <div id="TestimonialFormContainer">
                <?php include PATH_SITE.'/resources/views/common/testimonials/form.php'; ?>
            </div>

        </div>

    </section>
<?php else: ?>

    <h3 class="header"><?= $testimonialsForLoggedInL ?></h3>

<?php endif ?>





