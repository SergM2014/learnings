<p><a href='<?= \Lib\HelperService::currentLang() .'/'.$_POST['processContr'] ?>/editSerie?id=<?= (int)$_POST['id'] ?>' class='popUp-menu-item'><?= $updateL ?></a></p>


<form id="deleteSerie" action="<?= \Lib\HelperService::currentLang() .'/'.$_POST['processContr']?>/deleteSerie" method="post" class="">

    <input type="hidden" name="id" value="<?= (int)$_POST['id'] ?>">
    <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>" >


    <button type="button" class="popUp-menu__delete-item" id="popUpAdminDeleteSerie" ><?= $deleteL ?></button>

</form>
