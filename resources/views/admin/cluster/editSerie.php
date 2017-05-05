<div class="centered">



    <h2 class="header-h2"><?= $updateSerieL.' '.$serie->id ?></h2>

    <div class="form-field">
        <label class="form-field__label"><?= $iconL ?></label><br>

        <?php

            if(@!$_SESSION['serieIcon'] AND @$_POST['action']== 'updateSerie'){
                $givenImage = null;
            } else {
                $givenImage = $_SESSION['serieIcon'] = $serie->icon;
            }

        $imageCustomType = 'serieIcon';
        $path = ROOT."/uploads/seriesIcons/"; ?>

        <?php include PATH_SITE.'/resources/views/admin/partials/addImage.php'; ?>

        <small class="form-field__error"><?= @$errors['serieIcon'] ?></small>
    </div>


    <form method = "post" action="/admin/cluster/updateSerie">

        <input type="hidden" name="serieId" value="<?= $serie->id?? $_POST['serieId']?? @$_GET['id'] ?>">
        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">
        <input type="hidden" name="action" value="updateSerie">

        <div class="form-field">
            <label class="form-field__label" for="title"><?= $titleL ?></label>
            <br>
            <input type="text" name = "title" id="scroller_container" value="<?= $_POST['title']?? @$serie->title ?>">
            <small class="form-field__error"><?= @$errors['title'] ?></small>
        </div>


        <div class="form-field">
            <label class="form-field__label" for="upgradingSkill"><?= $difficultyLevelL ?></label>
            <br>
            <select name = "upgradingSkill"  id="upgradingSkill">
                <option value = "1" <?= $serie->upgrading_skill == 1? 'selected' : '' ?> ><?= $lowL ?></option>
                <option value = "2" <?= $serie->upgrading_skill == 2? 'selected' : '' ?> ><?= $middleL ?></option>
                <option value = "3" <?= $serie->upgrading_skill == 3? 'selected' : '' ?> ><?= $highL ?></option>
            </select>
            <small class="form-field__error"></small>
        </div>

        <div class="form-field">
            <button type="submit"><?= $updateL ?></button>
        </div>



    </form>

</div>

