<?php if (isset($_SESSION["logged"]) === true) { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.11/tinymce.min.js"></script>
                <script>
                    tinymce.init({
                        selector: 'textarea',
                        height: 400,
                        theme: 'modern',
                        plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
                        toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
                    });
                </script>
                <div class="header">
                    <h4 class="title">Page Settings</h4>
                </div>
                <div class="content">
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#tos-page" aria-expanded="false" aria-controls="tos-page">Terms of Service Page</button>
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#contact-page" aria-expanded="false" aria-controls="contact-page">Contact Page</button>
                    <?php
                    $config_file = "template.json";
                    if (@$_POST && $_SESSION["logged"] === true) {
                        save_pages($_POST);
                        echo '<br><p class="alert alert-success">Settings saved.</p>';
                    }
                    ?>
                    <form method="post">
                        <div class="collapse form-group" id="tos-page">
                                <label for="tos">Terms of Service Page</label>
                                <textarea id="tos" name="tos"><?php page_content("tos"); ?></textarea>
                        </div>
                        <div class="collapse form-group" id="contact-page">
                                <label for="tos">Contact Page</label>
                                <textarea id="contact" name="contact"><?php page_content("contact"); ?></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-info btn-fill btn-wd">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php } else {
    http_response_code(403);
} ?>