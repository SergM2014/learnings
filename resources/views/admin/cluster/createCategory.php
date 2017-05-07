<div class="centered">

    <h2 class="header-h2"><?= $createCategoryL ?></h2>


    <form method = "post" action="/admin/cluster/saveCategory">

        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">
        <input type="hidden" name="action" value="createSerie">

        <div class="form-field">
            <label class="form-field__label" for="title"><?= $titleL ?></label>
            <br>
            <input type="text" name = "title" id="scroller_container" value="<?= @$_POST['title'] ?>">
            <small class="form-field__error"><?= @$errors['title'] ?></small>
        </div>

        <div class="form-field">
            <button type="submit"><?= $createL ?></button>
        </div>

    </form>

</div>

