        <?php if(@!$noTemplate): ?>
            </section><!-- content-->




            <?php if (isset($_SESSION['admin']) ) : ?>

                <footer class="site-footer">

                </footer>


                <script src="<?= ROOT ?>/assets/js/admin.js?ver=<?= time() ?>"></script>

            <?php endif; ?>

    </div><!-- container-->
        <?php endif; ?>
</body>
</html>