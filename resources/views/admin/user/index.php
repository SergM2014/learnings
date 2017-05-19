<section class="centered">

    <h2 class="header-h2"><?= $usersL ?></h2>
    <ul class="admin-list">

        <?php foreach($users as $user): ?>

            <li class = "admin-item <?= $user->role_title ?>" data-user-id="<?= $user->id ?>"><?= $user->login ?>/<small><?= $user->role_title ?></small></li>

        <?php endforeach ; ?>

    </ul>


</section>

