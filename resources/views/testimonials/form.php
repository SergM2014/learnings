<div id="addTestimonialHeader" class="add-testimonial__header">
    <?php include PATH_SITE.'/resources/views/testimonials/addTestimonialHeader.php'; ?>
</div>


<form method="post" class="add-testimonial__form" id="addTestimonialForm">

        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('user') ?>" >

        <small><?= $enterTestimonialL ?></small>
        <div>
            <textarea name="testimonial" id="testimonial" name="testimonial" cols="40" rows="10"><?= \Lib\CheckFieldsService::stripMaliciousTags(@$_POST['testimonial']) ?></textarea>
        </div>

         <p><small class="error"><?= @$errors['testimonial'] ?></small></p>
        <br>


        <small><?= $clickToRefreshL ?></small>

        <br>
        <div id="captchaImgContainer" class="add-comment__captcha">
            <?php include PATH_SITE.'/resources/views/partials/captcha.php'; ?>
        </div>

        <small><?= $enterCaptchaL ?></small>
        <div>
            <input type="text" name="captcha" id="captcha">
        </div>

        <p><small class="error"><?= @$errors['captcha'] ?></small></p>
        <br>



        <button type="button" id="addTestimonialSubmitBtn" class="add-testimonial__submit-btn"><?= $addTestimonialL ?></button>

 </form>
