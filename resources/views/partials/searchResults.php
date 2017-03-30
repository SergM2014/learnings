
<?php
if ($searchResults): ?>

    <?php foreach($searchResults as $result): ?>
       <p class="search-results__founded"  data-lesson-id="<?= $result->id ?>">
           <?= $result->title ?> / <span class="red"> <?= $result->serie_title ?> </span> / <span class="green"><?= $result->category_title ?> </span>
       </p>

    <?php endforeach; ?>


<?php else: ?>

   <h3 class="header"><?= $nothingFound ?></h3>

<?php endif; ?>
