<div class="centered">



    <h2 class="header-h2"><?= $createSerieL ?></h2>

    <div class="form-field">
        <label class="form-field__label"><?= $iconL ?></label><br>

        <?php

        if(@!$_SESSION['serieIcon'] AND @$_POST['action']== 'createSerie'){
            $givenImage = null;
        } /*else {
            $givenImage = $_SESSION['serieIcon'] = $serie->icon;
        }*/

        $imageCustomType = 'serieIcon';
        $path = ROOT."/uploads/seriesIcons/"; ?>

        <?php include PATH_SITE.'/resources/views/admin/partials/addImage.php'; ?>

        <small class="form-field__error"><?= @$errors['serieIcon'] ?></small>
    </div>


    <form method = "post" action="/admin/cluster/saveSerie">

        <input type="hidden" name="parentId" value="<?=  $_GET['parentId']??  @$_POST['parentId'] ?>">
        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">
        <input type="hidden" name="action" value="createSerie">

        <div class="form-field">
            <label class="form-field__label" for="title"><?= $titleL ?></label>
            <br>
            <input type="text" name = "title" id="scroller_container" value="<?= @$_POST['title'] ?>">
            <small class="form-field__error"><?= @$errors['title'] ?></small>
        </div>


        <div class="form-field">
            <label class="form-field__label" for="upgradingSkill"><?= $difficultyLevelL ?></label>
            <br>
            <select name = "upgradingSkill"  id="upgradingSkill">
                <option value = "1" <?= @$_POST['upgradingSkill'] == 1? 'selected' : '' ?> ><?= $lowL ?></option>
                <option value = "2" <?= @$_POST['upgradingSkill'] == 2? 'selected' : '' ?> ><?= $middleL ?></option>
                <option value = "3" <?= @$_POST['upgradingSkill'] == 3? 'selected' : '' ?> ><?= $highL ?></option>
            </select>
            <small class="form-field__error"></small>
        </div>

        <div class="form-field">
            <button type="submit"><?= $createL ?></button>
        </div>



    </form>

</div>

