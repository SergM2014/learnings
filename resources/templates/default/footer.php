            </section><!-- content-->
            <?php if(@!$noTemplate): ?>
                <footer class="site-footer">
                    <span class="site-footer__mark"><?= $footerDisclaimerL ?></span>

                        <a href="/admin" class="site-footer__admin-link"><small>admin</small></a>


                </footer>

                <script src="<?= ROOT ?>/assets/js/script.js?ver=<?= time() ?>" ></script>
            <?php endif; ?>
    </div><!-- container-->
</body>
</html>