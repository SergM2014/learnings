<form method="post" class="add-comment__form">

        <small><?= $enterCommentL ?></small>
        <div>
            <textarea name="comment" id="comment" name="comment" cols="40" rows="10"></textarea>
        </div>

        <span class="error"></span>
        <br>

        <small><?= $clickToRefreshL ?></small>
        <br>
        <div id="captchaImgContainer" class="add-comment__captcha">
            <?php include PATH_SITE.'/resources/views/partials/captcha.php'; ?>
        </div>


        <br>

        <small><?= $enterCaptchaL ?></small>
        <div>
            <input type="text" name="captcha" id="captcha">
        </div>

        <span class="error"></span>
        <br>

        <button type="button" id="addCommentSubmitBtn" class="add-comment__submit-btn"><?= $sendCommentL ?></button>

 </form>
