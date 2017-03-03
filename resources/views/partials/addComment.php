<section class="add-comment__block">

    <div class="add-comment__block-centered">

        <h2 class="add-comment__title"><?= $addCommentL ?></h2>

        <div class="image-download__block">
            <img src="/img/noavatar.jpg" alt="" id="downloadImagePreview" class="image-download__preview">
            <div id="imageDownloadOutput" class="image-download__output"></div>

            <form enctype="multipart/form-data">
                <input type="file" name="file" id="file" class="">
                <button type="button" id="downloadImageBtn" class="image-download__btn hidden"><?= $downloadL ?></button>
                <button type="button" id="resetImageBtn" class="image-download__btn hidden"><?= $deleteL ?></button>
            </form>

            <progress max="100" value="0" id="imageDownloadProgress"  class="image-download__progress hidden" >

            </progress>
        </div>

    </div>

    <script src="/assets/js/uploadImage.js?ver=<?= time() ?>" ></script>

</section>