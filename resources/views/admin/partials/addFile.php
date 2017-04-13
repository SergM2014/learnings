<p><small><?= $lessonFileUploadRemark ?></small></p>
<div class="file-download__block">

    <img src="<?= ROOT ?>/img/download_file.jpg" alt="" id="downloadFilePreview" class="file-download__preview">



     <div id="fileDownloadOutput" class="file-download__output"></div>


    <form enctype="multipart/form-data">
        <input type="hidden" id="prozessFileToken" name="prozessFileToken" value = "<?= \Lib\TokenService::printTocken('admin') ?>" >

        <input type="file" name="downloadFile" id="downloadFile" class="<?= @$_SESSION['file']? 'hidden': '' ?>">
        <button type="button" id="downloadFileBtn" class="file-download__btn hidden"><?= $downloadL ?></button>
        <button type="button" id="resetFileBtn" class="file-download__btn <?= @!$_SESSION['file']? 'hidden': '' ?>"><?= $deleteL ?></button>
    </form>

    <progress max="100" value="0" id="fileDownloadProgress"  class="file-download__progress hidden" >

    </progress>

    <script src="/assets/js/uploadFile.js?ver=<?= time() ?>" ></script>

</div>