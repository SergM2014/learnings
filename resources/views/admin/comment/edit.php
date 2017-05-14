<section class="centered">

    <h2 class="header-h2"><?= $updateCommentL.' '.$comment->id ?></h2>


    <h3><span class="form-field__label"><?= $comment->login ?></span></h3>

    <div class="form-field">

        <img class="lesson-comments__avatar" src="<?= $comment->avatar? '/uploads/avatars/'.$comment->avatar : '/img/noavatar.jpg' ?>" alt="">


    </div>


    <form class="lesson-form" method="post" action = "/admin/comment/update">

        <input type="hidden" name="commentId" value="<?= $comment->id?? $_POST['lessonId']?? @$_GET['id'] ?>"/>
        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">

        <div class="form-field">
            <label for="comment" class="form-field__label"><?= $commentL ?></label>
            <textarea name="comment" id="comment" rows="10" cols="40" required ><?= $_POST['comment']??  @$comment->comment ?></textarea>
            <small class="form-field__error"><?= @$errors['comment'] ?></small>
        </div>

        <button type="submit"><?= $updateCommentL ?></button>


    </form>
</section>