

<form method="post" class="add-comment__form" id="addCommentForm">


        <input type="hidden" name="lessonId" value="<?= @$_POST['lessonId']?? $lesson->id ?>">
        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('user') ?>" >

        <small><?= $enterCommentL ?></small>
        <div><textarea name="comment" id="comment" name="comment" cols="40" rows="10">
                <?= \Lib\CheckFieldsService::stripMaliciousTags(@$_POST['comment']) ?>
            </textarea>
        </div>

         <p><small class="error"><?= @$errors['comment'] ?></small></p>
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

        <button type="button" id="addCommentSubmitBtn" class="add-comment__submit-btn"><?= $sendCommentL ?></button>

 </form>
