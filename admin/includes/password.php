<?php if(isset($_SESSION["logged"]) === true){ ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">Change Password</h4>
                </div>
                <div class="content">
                    <?php
                    if (@$_POST && $_SESSION["logged"] === true) {
                        change_password($_POST["password"]);
                        echo '<p class="alert alert-success">Settings saved.</p>';
                    }
                    ?>
                    <form method="post">
                        <div class="form-group">
                            <label for="password">New Password</label><br>
                            <input class="form-control" type="password" name="password" required>
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