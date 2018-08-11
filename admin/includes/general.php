<?php if (isset($_SESSION["logged"]) === true) { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">General Settings</h4>
                </div>
                <div class="content">
                    <?php
                    if (@$_POST && $_SESSION["logged"] === true) {
                        save_config($_POST, "config.json");
                        echo '<p class="alert alert-success">Settings saved.</p>';
                    }
                    ?>
                    <form method="post">
                        <div class="form-group">
                            <label for="url">Site URL</label><br>
                            <input class="form-control" type="url" name="url" required
                                   value="<?php config("url", true); ?>">
                        </div>
                        <div class="form-group">
                            <label for="title">Site Title</label><br>
                            <input class="form-control" type="text" name="title" required
                                   value="<?php config("title", true); ?>">
                        </div>
                        <div class="form-group">
                            <label for="description">Site Description</label><br>
                            <textarea class="form-control" name="description" cols="50">
                            <?php config("description", true); ?>
                        </textarea>
                        </div>
                        <div class="form-group">
                            <label for="author">Site Owner</label><br>
                            <input class="form-control" type="text" name="author" required
                                   value="<?php config("author", true); ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Site Owner E-Mail</label><br>
                            <input class="form-control" type="email" name="email" required
                                   value="<?php config("email", true); ?>">
                        </div>
                        <div class="form-group">
                            <label for="language">Default Language</label><br>
                            <select class="form-control" name="language">
                                <?php list_languages(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="template">Theme</label><br>
                            <input class="form-control" type="text" placeholder="Enter template folder name"
                                   name="template" required
                                   value="<?php config("template", true); ?>">
                        </div>
                        <div class="form-group">
                            <label for="tracking-code">Tracking code</label><br>
                            <input class="form-control" type="text" placeholder="Paste here your code"
                                   name="tracking-code"
                                   value="<?php get_tracking_code(true); ?>">
                        </div>
                        <input type="hidden" name="purchase_code" value="<?php config("purchase_code", true); ?>">
                        <input type="hidden" name="fingerprint" value="<?php config("fingerprint", true); ?>">
                        <input type="hidden" name="version" value="<?php config("version", true); ?>">
                        <input type="hidden" name="checksum" value="<?php config("checksum", true); ?>">
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