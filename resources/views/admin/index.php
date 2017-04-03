<?php if(isset($_SESSION['admin'])): ?>

<h2 class="admin-zone--greeting">Thi sis admin zone admin really</h2>

<?php else : ?>

    <?php include PATH_SITE.'/resources/views/admin/login.php'; ?>


<?php endif; ?>
