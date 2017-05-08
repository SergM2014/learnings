

<form method="get" action="<?= \Lib\HelperService::currentLang() ?>/admin/lesson">

    <label for="orderList"><?= $orderByL ?></label>
    <select name="order" id="orderList">

        <option value="new_first" <?= @$_GET['order' ]== 'new_first' ? 'selected': '' ?> ><?= $newFirstL ?></option>
        <option value="old_first" <?= @$_GET['order'] == 'old_first' ? 'selected': '' ?> ><?= $oldFirstL ?></option>
        <option value="abc" <?= @$_GET['order'] == 'abc' ? 'selected': '' ?>><?= $abcL ?></option>
        <option value="abc_backwards" <?= @$_GET['order']=='abc_backwards' ? 'selected': '' ?> ><?= $abcBackwardsL ?></option>
        <option value="more_comments_first" <?=  @$_GET['order'] == 'more_comments_first' ? 'selected': '' ?> ><?= $moreCommentsFirstL ?></option>
        <option value="less_comments_first" <?=  @$_GET['order'] == 'less_comments_first' ? 'selected': '' ?> ><?= $lessCommentsFirstL ?></option>
    </select>

    <label for="categoryAndSerie"><?= $category_serieTitleL ?></label>
    <select name="category_and_serie" id="categoryAndSerie">
        <option value="all"><?= $selectAllL ?></option>
        <?= $serieDropDownList ?>
    </select>


    <button type="submit">ok</button>

</form>




<div class="table-container">

    <table class="table">
        <tr>
            <th>#</th><th></th><th><?= $titleL ?></th><th><?= $excerptL ?></th><th><?= $category_serieTitleL ?></th><th><?= $commentsNumberL ?></th><th><?= $addedAtL ?></th>
        </tr>

        <?php foreach ($lessons as $lesson): ?>

            <tr class="table__row lesson-row" data-lesson-id ="<?= $lesson->id ?>">
                <td><?= $counter++ ?></td>
                <td><img src="<?= ROOT ?>/uploads/lessonsIcons/<?= $lesson->icon ?>" class="table-image" alt=""></td>
                <td><?= $lesson->title ?></td>
                <td><?= $lesson->excerpt ?></td>
                <td><?= $lesson->category_title ?>/<?= $lesson->serie_title?? $noSerieTitleL ?></td>
                <td><?= $lesson->comments_number ?></td>
                <td><?= $lesson->added_at ?></td>
            </tr>

        <?php endforeach ?>

    </table>

</div>



<?php include PATH_SITE.'/resources/views/admin/partials/pagination.php'; ?>