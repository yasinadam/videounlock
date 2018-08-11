<?php if(isset($_SESSION["logged"]) === true){ ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">Ads Settings</h4>
                </div>
                <div class="content">
                    <?php
                    if (@$_POST && $_SESSION["logged"] === true) {
                        file_put_contents(__DIR__ . "/../../system/storage/advertising-728_90.tpl", $_POST["728_90"]);
                        file_put_contents(__DIR__ . "/../../system/storage/advertising-300_300.tpl", $_POST["300_300"]);
                        echo '<p class="alert alert-success">Settings saved.</p>';
                    }
                    ?>
                    <form method="post">
                        <div class="form-group">
                            <label for="728_90">728x90</label><br>
                            <textarea rows="5" cols="80" name="728_90"><?php get_ad("728_90"); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="300_300">300x300</label><br>
                            <textarea rows="5" cols="80" name="300_300"><?php get_ad("300_300"); ?></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-info btn-fill btn-wd">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    http_response_code(403);
} ?>