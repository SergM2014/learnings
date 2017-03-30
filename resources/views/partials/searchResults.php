
<?php
if ($searchResults): ?>

    <?php foreach($searchResults as $result): ?>
       <p class="search-results__founded">
           <span data-lesson-id="<?= $result->id ?>"><?= $result->title ?></span>
       </p>

    <?php endforeach; ?>

<?php else: ?>

   <h3 class="header"><?= $nothingFound ?></h3>

<?php endif; ?>
