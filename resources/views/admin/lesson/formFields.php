<input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">
<input type = "hidden" name="action" value="createLesson">

<div class="form-field">
    <label for="title" class="form-field__label"><?= $titleL ?></label><br>
    <input type="text" name="title" id="title" value="<?= $_POST['title']?? @$lesson->title ?>" required >
    <small class="form-field__error"><?= @$errors['title'] ?></small>
</div>

<div class="form-field">
    <label for="excerpt" class="form-field__label"><?= $excerptL ?></label>
    <textarea name="excerpt" id="excerpt" rows="10" cols="40" required ><?= $_POST['excerpt']??  @$lesson->excerpt ?></textarea>
    <small class="form-field__error"><?= @$errors['excerpt'] ?></small>
</div>


<div class="form-field">
    <label  class="form-field__label"><?= $shooseSerieL ?></label>
    <small class="form-field__error"><?= @$errors['category'] ?></small>

    <input type="hidden" id="categoryField" name="category" value="<?= $_POST['category']?? @$lesson->category_id ?>">
    <input type="hidden" id="serieField" name="serie" value="<?= $_POST['serie']??  @$lesson->serie_id ?>" >

    <ul id="serieList" class="serie-selection">
        <?= $treeMenu ?>
    </ul>
</div>




<div class="form-field" >
    <p class="form-field__label"><?= $setPayedStatusL ?></p>

    <label><input type="radio" name="free_status" value="1" <?= (@$lesson->free_status == 1 OR @$_POST['free_status']== 1 OR @!$_POST['free_status']) ? 'checked': ''; ?> ><?= $freeL ?></label>
    <label><input type="radio" name="free_status" value="0" <?= @$_POST['free_status']==  0 OR @$lesson->free_status == 0 ? 'checked': ''; ?> ><?= $notFreeL ?></label>
</div>