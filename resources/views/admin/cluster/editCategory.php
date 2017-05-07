<div class="centered">

    <h2 class="header-h2"><?= $updateCategoryL ?></h2>


    <form method = "post" action="/admin/cluster/updateCategory">

        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">
        <input type="hidden" name = "categoryId" value="<?= (int)$_GET['id']?? $category->id ?>">

        <div class="form-field">
            <label class="form-field__label" for="title"><?= $titleL ?></label>
            <br>
            <input type="text" name = "title" id="scroller_container" value="<?= $_POST['title']?? @$category->title ?>">
            <small class="form-field__error"><?= @$errors['title'] ?></small>
        </div>

        <div class="form-field">
            <button type="submit"><?= $updateL ?></button>
        </div>

    </form>

</div>

