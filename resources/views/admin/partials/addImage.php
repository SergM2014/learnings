<div class="image-download__block">

    <img src="<?=  displayPreviewImage(@$givenImage, $imageCustomType, $path) ?>" alt="" id="downloadImagePreview" class="image-download__preview">


     <div id="imageDownloadOutput" class="image-download__output"></div>


    <form enctype="multipart/form-data">
        <input type="hidden" id="prozessImageToken" name="prozessImageToken" value = "<?= \Lib\TokenService::printTocken('prozessImage') ?>" >
        <input type="hidden" id="imageCustomType" name="imageCustomType" value="<?= @$imageCustomType ?>">
        <input type="file" name="file" id="file" class="<?= @$givenImage ? 'hidden': '' ?>">
        <button type="button" id="downloadImageBtn" class="image-download__btn hidden"><?= $downloadL ?></button>
        <button type="button" id="resetImageBtn" class="image-download__btn <?= @!$givenImage ? 'hidden': '' ?>"><?= $deleteL ?></button>
    </form>

    <progress max="100" value="0" id="imageDownloadProgress"  class="image-download__progress hidden" >

    </progress>

    <script src="/assets/js/uploadImage.js?ver=<?= time() ?>" ></script>

</div>

