<div class="centered">

    <h2 class="header-h2"><?= $subscribtionPlanDescriptionL ?></h2>


    <form method = "post" action="/admin/subscription/update">

        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">


        <div class="form-field">
            <label class="form-field__label" for="planDescriptionUk"><?= $ukrainianL ?> </label>
            <br>
            <textarea name = "plan_description_uk" id="planDescriptionUk" cols="40" rows="15"><?= $_POST['plan_description_uk']?? $subscriptionPlan->plan_description_uk ?>
        </textarea>
            <small class="form-field__error"><?= @$errors['plan_description_uk'] ?></small>
        </div>


        <div class="form-field">
            <label class="form-field__label" for="planDescriptionEn"><?= $englishL ?></label>
            <br>
            <textarea name = "plan_description_en" id="planDescriptionEn" cols="40" rows="15"><?= $_POST['plan_description_en']?? $subscriptionPlan->plan_description_en ?>
        </textarea>
            <small class="form-field__error"><?= @$errors['plan_description_en'] ?></small>
        </div>


        <div class="form-field">
            <button type="submit"><?= $updateL ?></button>
        </div>


    </form>


</div>
