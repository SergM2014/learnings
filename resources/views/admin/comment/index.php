<h2 class="header-h2"><?= $commentsL ?></h2>


<form method="get" action="<?= \Lib\HelperService::currentLang() ?>/admin/comment">

    <label for="orderList"><?= $orderByL ?></label>
    <select name="order" id="orderList">

        <option value="new_first" <?= @$_GET['order' ]== 'new_first' ? 'selected': '' ?> ><?= $newFirstL ?></option>
        <option value="old_first" <?= @$_GET['order'] == 'old_first' ? 'selected': '' ?> ><?= $oldFirstL ?></option>
        <option value="AZ" <?= @$_GET['order'] == 'AZ' ? 'selected': '' ?>><?= $userAZL ?></option>
        <option value="ZA" <?= @$_GET['order']=='ZA' ? 'selected': '' ?> ><?= $userZAL ?></option>
        <option value="more_responses" <?= @$_GET['order'] == 'more_responses' ? 'selected': '' ?>><?= $moreResponsesFirstL ?></option>
        <option value="less responses" <?= @$_GET['order'] == 'less_responses' ? 'selected': '' ?>><?= $lessResponsesFirstL ?></option>

    </select>



    <button type="submit">ok</button>

</form>



<div class="table-container">

    <table class="table">

        <tr>
            <th>#</th><th><?= $userL ?><th><?= $avatarL ?></th><th><?= $responseL ?></th><th><?= $responsesL ?></th><th><?= $publishedL ?></th><th><?= $changedL ?></th><th><?= $addedAtL ?></th>
        </tr>

        <?php foreach ($comments as $comment): ?>

            <tr class="table__row comment-row" data-comment-id ="<?= $comment->id ?>">
                <td><?= $counter++ ?></td>
                <td><?= $comment->login ?></td>
                <td>
                    <?php if($comment->avatar): ?>
                        <img src="<?= ROOT ?>/uploads/avatars/<?= $comment->avatar ?>" class="table-image" alt="">
                    <?php endif;?>
                </td>
                <td><?= $comment->comment ?></td>
                <td><?= $comment->most_commented ?>   </td>
                <td class=" publish-status <?= $comment->published == '1'? 'green': 'red' ?>"><?= $comment->published == '1'? $yesL: $noL ?></td>
                <td class="<?= $comment->changed == '0'? 'green': 'red' ?>"><?= $comment->changed == '0'? $noL: $yesL ?></td>
                <td><?= $comment->added_at ?></td>
            </tr>

        <?php endforeach ?>

    </table>

</div>



<?php include PATH_SITE.'/resources/views/admin/partials/pagination.php'; ?>
