<input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">

<div class="form-field">
    <label for="title" class="form-field__label"><?= $titleL ?></label><br>
    <input type="text" name="title" id="title" value="<?= $lesson->title??  @$_POST['title'] ?>" required >
    <small class="form-field__error"><?= @$errors['title'] ?></small>
</div>

<div class="form-field">
    <label for="excerpt" class="form-field__label"><?= $excerptL ?></label>
    <textarea name="excerpt" id="excerpt" rows="10" cols="40" required ><?=$lesson->excerpt?? @$_POST['excerpt'] ?></textarea>
    <small class="form-field__error"><?= @$errors['excerpt'] ?></small>
</div>


<div class="form-field">
    <label  class="form-field__label"><?= $shooseSerieL ?></label>
    <small class="form-field__error"><?= @$errors['category'] ?></small>

    <input type="hidden" id="categoryField" name="category" value="<?= $lesson->category_id?? @$_POST['category'] ?>">
    <input type="hidden" id="serieField" name="serie" value="<?= $lesson->serie_id?? @$_POST['serie'] ?>" >

    <ul id="serieList" class="serie-selection">
        <?= $treeMenu ?>
    </ul>
</div>




<div class="form-field" >
    <p class="form-field__label"><?= $setPayedStatusL ?></p>

    <label><input type="radio" name="free_status" value="1" <?= (@$lesson->free_status == 1 OR @$_POST['free_status']== 1 OR @!$_POST['free_status']) ? 'checked': ''; ?> ><?= $freeL ?></label>
    <label><input type="radio" name="free_status" value="0" <?= @$_POST['free_status']==  0 OR @$lesson->free_status == 0 ? 'checked': ''; ?> ><?= $notFreeL ?></label>
</div>