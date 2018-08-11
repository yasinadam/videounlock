<?php if (isset($_SESSION["logged"]) === true) { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">Theme Settings</h4>
                </div>
                <div class="content">
                    <?php
                    $config_file = "template.json";
                    if (@$_POST && $_SESSION["logged"] === true) {
                        save_config($_POST, $config_file);
                        save_menu($_POST["menu"], "menu.json");
                        echo '<p class="alert alert-success">Settings saved.</p>';
                    }
                    ?>
                    <form method="post">
                        <div class="form-group">
                            <div class="checkbox">
                                <input value="true" name="about"
                                       type="checkbox" <?php check_config($config_file, "about"); ?>>
                                <label for="about">Show About Area</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <input value="true" name="ads"
                                       type="checkbox" <?php check_config($config_file, "ads"); ?>>
                                <label for="ads">Show Ads</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <input value="true" name="tos"
                                       type="checkbox" <?php check_config($config_file, "tos"); ?>>
                                <label for="tos">Show ToS Page Link</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <input value="true" name="contact"
                                       type="checkbox" <?php check_config($config_file, "contact"); ?>>
                                <label for="contact">Show Contact Page Link</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <input value="true" name="social"
                                       type="checkbox" <?php check_config($config_file, "social"); ?>>
                                <label for="social">Show Social Links</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="facebook">Facebook</label>
                            <input type="text" value="<?php theme_config("facebook", true) ?>"
                                   placeholder="Facebook Username" name="facebook" class="form-control">
                            <label for="twitter">Twitter</label>
                            <input type="text" value="<?php theme_config("twitter", true) ?>"
                                   placeholder="Twitter Username" name="twitter" class="form-control">
                            <label for="google">Google+</label>
                            <input type="text" value="<?php theme_config("google", true) ?>"
                                   placeholder="Google+ Username" name="google" class="form-control">
                            <label for="youtube">YouTube</label>
                            <input type="text" value="<?php theme_config("youtube", true) ?>"
                                   placeholder="YouTube Username" name="youtube" class="form-control">
                            <label for="instagram">Instagram</label>
                            <input type="text" value="<?php theme_config("instagram", true) ?>"
                                   placeholder="Instagram Username" name="instagram" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="menu">Menu Links</label><br>
                            <textarea placeholder="TITLE,URL&#10;TITLE,URL" name="menu" class="form-control" cols="50"
                                      rows="5">
                            <?php view_menu("menu.json"); ?>
                        </textarea>
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