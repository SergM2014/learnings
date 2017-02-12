<section class="breadcrumbs">

    <a href="/" class="breadcrumb__item"><?=  $mainPageL ?></a>  =>
    <span class="breadcrumb__item--current"><?=  $testimonialsL ?></span>

</section>

<h2 class="content-zone__header"><?= $testemonialsL ?></h2>


<section class="testimonials-block__all">
    <?php foreach($testimonials as $testimonial): ?>

        <div class="testimonials-block__all-item">
            <img class="testimonials-block__all-item-avatar" src="/uploads/usersImages/<?= $testimonial->first_avatar ?? $testimonial->second_avatar; ?>"
                 alt="" onerror="this.style.display='none'">
            <strong><?= $testimonial->name ?></strong>
            <?= $testimonial->testimonial ?>
            <p class="testimonials-block__all-item-time"><?= (new \DateTime($testimonial->time))->format('Y-m-d'); ?></p>
        </div>

    <?php endforeach; ?>
</section>





