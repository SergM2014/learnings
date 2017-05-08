<h2 class="header-h2"><?= $testimonialsL ?></h2>
<div class="table-container">

    <table class="table">

        <tr>
            <th>#</th><th><?= $userL ?><th><?= $avatarL ?></th><th><?= $responseL ?></th><th><?= $publishedL ?></th><th><?= $changedL ?></th><th><?= $addedAtL ?></th>
        </tr>

        <?php foreach ($testimonials as $testimonial): ?>

            <tr class="table__row testimonial-row" data-testimonial-id ="<?= $testimonial->id ?>">
                <td><?= $counter++ ?></td>
                <td><?= $testimonial->login ?></td>
                <td>
                    <?php if($testimonial->avatar): ?>
                        <img src="<?= ROOT ?>/uploads/avatars/<?= $testimonial->avatar ?>" class="table-image" alt="">
                    <?php endif;?>
                </td>
                <td><?= $testimonial->testimonial ?></td>

                <td class="<?= $testimonial->published == '1'? 'green': 'red' ?>"><?= $testimonial->published == '1'? $yesL: $noL ?></td>
                <td class="<?= $testimonial->changed == '0'? 'green': 'red' ?>"><?= $testimonial->changed == '0'? $noL: $yesL ?></td>
                <td><?= $testimonial->added_at ?></td>
            </tr>

        <?php endforeach ?>

    </table>

</div>



<?php include PATH_SITE.'/resources/views/admin/partials/pagination.php'; ?>
