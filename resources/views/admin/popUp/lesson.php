<p><a href='/<?= \Lib\HelperService::currentLang() .$_POST['processContr'] ?>/create' class='popUp-menu-item'><?= $addL ?></a></p>
<p><a href='/<?= \Lib\HelperService::currentLang() .$_POST['processContr'] ?>/show?id=<?= (int)$_POST['id'] ?>' class='popUp-menu-item'><?= $showL ?></a></p>
<p><a href='/<?= \Lib\HelperService::currentLang() .$_POST['processContr'] ?>/edit?id=<?= (int)$_POST['id'] ?>' class='popUp-menu-item'><?= $updateL ?></a></p>




<form id="delete-item" action="/<?= \Lib\HelperService::currentLang() .$_POST['processContr']?>/delete" method="post" class="">

    <input type="hidden" name="id" value="<?= (int)$_POST['id'] ?>">
    <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>" >


    <button type="submit" class="popUp-menu__delete-item" id="popUp-admin-delete-item" ><?= $deleteL ?></button>

</form>
