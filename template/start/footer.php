<footer class="dark bg-primary">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 footer-left-area">
                <p>© <?php echo date("Y") . " " . config("title"); ?></p>
            </div>
            <div class="col-lg-4 social-icons footer-right-area">
                <?php if (template_config("social") == "true") {
                    //social_links();
                } ?>
            </div>
        </div>
    </div>
</footer>
<?php include(__DIR__ . "/../../system/storage/tracking.tpl"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="<?php config("url", true); ?>/template/start/assets/js/main.js"></script>
<script src="<?php config("url", true); ?>/assets/js/codebird.js"></script>
</body>
</html>