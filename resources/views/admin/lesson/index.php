
<div class="table-container">

    <table class="table">
        <tr>
            <th>#</th><th></th><th><?= $titleL ?></th><th><?= $excerptL ?></th>
        </tr>

        <?php foreach ($lessons as $lesson): ?>

            <tr class="table__row" data-lesson-id ="<?= $lesson->id ?>">
                <td><?= $counter++ ?></td>
                <td><img src="<?= ROOT ?>/uploads/lessonsIcons/<?= $lesson->icon ?>" class="table-image" alt=""></td>
                <td><?= $lesson->title ?></td>
                <td><?= $lesson->excerpt ?></td>
            </tr>

        <?php endforeach ?>

    </table>

</div>



<?php include PATH_SITE.'/resources/views/admin/partials/pagination.php'; ?>