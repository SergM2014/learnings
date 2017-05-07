<p><a href='<?= \Lib\HelperService::currentLang() .'/' .$_POST['processContr'] ?>/createCategory' class='popUp-menu-item'><?= $addL ?></a></p>
<p><a href='<?= \Lib\HelperService::currentLang() .'/'.$_POST['processContr'] ?>/createSerie?parentId=<?= (int)$_POST['id'] ?>' class='popUp-menu-item'><?= $createSerieL ?></a></p>
<p><a href='<?= \Lib\HelperService::currentLang() .'/'.$_POST['processContr'] ?>/editCategory?id=<?= (int)$_POST['id'] ?>' class='popUp-menu-item'><?= $updateL ?></a></p>



<form id="deleteCategory" action="<?= \Lib\HelperService::currentLang() .'/'.$_POST['processContr']?>/deleteCategory" method="post" class="">

    <input type="hidden" name="id" value="<?= (int)$_POST['id'] ?>">
    <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>" >


    <button type="button" class="popUp-menu__delete-item" id="popUpAdminDeleteCategory" ><?= $deleteL ?></button>

</form>
