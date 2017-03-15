<img id="lessonCommentCloseSign" class="lesson-comments__close-sign" src="/img/close.png" alt="">
<article class="lesson-comments__article">
    <h2 class="header__h2"><?= $responseGivvenComment ?></h2>

    <img class="lesson-comments__avatar" src="<?= $comment->avatar? '/uploads/avatars/'.$comment->avatar : '/img/noavatar.jpg' ?>" alt="">
    <span class="lesson-comments__login"><?= $comment->login ?></span>
    <time class="lesson-comments__time"><?= $comment->added_at ?></time>
    <div class="lesson-comments__text"><?= $comment->comment ?></div>

</article>