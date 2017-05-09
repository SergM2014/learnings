

<p><a href='<?= \Lib\HelperService::currentLang() .'/'.$_POST['processContr'] ?>/edit?id=<?= (int)$_POST['id'] ?>' class='popUp-menu-item'><?= $editL ?></a></p>



<form id="publishTestimonial" action="<?= \Lib\HelperService::currentLang() .'/'.$_POST['processContr']?>/publish" method="post" class="">

    <input type="hidden" name="id" value="<?= (int)$_POST['id'] ?>">
    <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>" >


    <button type="button" class="popUp-menu__delete-item" id="popUpAdminPublishTestimonial" ><?= $publishL ?></button>

</form>

<form id="unpublishTestimonial" action="<?= \Lib\HelperService::currentLang() .'/'.$_POST['processContr']?>/unpublish" method="post" class="">

    <input type="hidden" name="id" value="<?= (int)$_POST['id'] ?>">
    <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>" >


    <button type="button" class="popUp-menu__delete-item" id="popUpAdminUnpublishTestimonial" ><?= $unpublishL ?></button>

</form>
