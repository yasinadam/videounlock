<?php if (isset($_SESSION["logged"]) === true) { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">API Settings</h4>
                </div>
                <div class="content">
                    <?php
                    if (@$_POST && $_SESSION["logged"] === true) {
                        save_config($_POST, "api.json");
                        echo '<p class="alert alert-success">Settings saved.</p>';
                    }
                    ?>
                    <form method="post">
                        <div class="form-group">
                            <label for="url">Soundcloud API Key</label><br>
                            <input class="form-control" type="text" name="soundcloud" required
                                   value="<?php config("soundcloud", true, "api.json"); ?>">
                        </div>
                        <div class="form-group">
                            <label for="url">Flickr API Key</label><br>
                            <input class="form-control" type="text" name="flickr" required
                                   value="<?php config("flickr", true, "api.json"); ?>">
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