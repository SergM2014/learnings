<div class="centered">

    <h2 class="header-h2"><?= $editTestimonialL ?></h2>

    <?php if($testimonial->avatar): ?>
        <div>
            <img  src="/uploads/avatars/<?= $testimonial->avatar ?>"  alt="" >
        </div>
    <?php endif; ?>

    <form method = "post" action="/admin/testimonial/update">

    <input type="hidden" name="testimonialId" value="<?= $testimonial->id?? $_POST['testimonialId']?? @$_GET['id'] ?>">
    <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">


    <div class="form-field">
        <label class="form-field__label" for="testimonial"><?= $titleL ?></label>
        <br>
        <textarea name = "testimonial" id="testimonial" cols="40" rows="15"><?= $_POST['testimonial']?? @$testimonial->testimonial ?>
        </textarea>
        <small class="form-field__error"><?= @$errors['testimonial'] ?></small>
    </div>



    <div class="form-field">
        <input type="radio" name="published" value="1" <?= $testimonial->published == "1"? 'checked': '' ?>><?= $publishedL ?>
        <input type="radio" name="published" value="0" <?= $testimonial->published == "0"? 'checked': '' ?>><?= $unpublishedL ?>
    </div>

    <div class="form-field">
        <?= $testimonial->changed == '1'? '<span class="red">'.$changedL.'</span>' : '<span class="green">'.$notChangedL.'</span>'  ?>
    </div>




    <div class="form-field">
        <button type="submit"><?= $updateL ?></button>
    </div>



    </form>


</div>