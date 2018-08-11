<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>All in One Video Downloader Installer</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto
        }

        .form-signin .checkbox {
            font-weight: 400
        }

        .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px
        }

        .form-signin .form-control:focus {
            z-index: 2
        }

        .form-signin input[type=email] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0
        }

        .form-signin input[type=password] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0
        }
    </style>
</head>
<body class="text-center">
<form method="post" class="form-signin">
    <?php
    if (@$_POST) {
        include(__DIR__ . "/admin/functions.php");
        $installation_data["name"] = $_POST["author"];
        $installation_data["version"] = $_POST["version"];
        $installation_data["purchaseCode"] = $_POST["purchase_code"];
        $installation_data["url"] = rtrim($_POST["url"], '/\\');
        $installation_data["email"] = $_POST["email"];
        $installation_data["ip"] = gethostbyname(gethostname());
        $installation_data["userIp"] = get_user_ip();
        $installation_data["checksum"] = $_POST["checksum"];
        $installation_data = urlencode(base64_encode(json_encode($installation_data)));
        $config_json = url_get_contents("http://api.nicheoffice.web.tr/register/installation/" . $installation_data);
        if ($config_json != "Registration failed. Check input data and try again or contact with seller.") {
            $site_map = file_get_contents(__DIR__ . "/sitemap.xml");
            $site_map = str_replace("{{url}}", rtrim($_POST["url"], '/\\'), $site_map);
            $admin_password = sha1($_POST["password"]);
            file_put_contents(__DIR__ . "/system/storage/config.json", $config_json);
            file_put_contents(__DIR__ . "/system/storage/password.htpasswd", $admin_password);
            file_put_contents(__DIR__ . "/sitemap.xml", $site_map);
            echo '<p class="alert alert-success">Installation completed! <a href="' . $_POST["url"] . '">Go to website</a> <a href="' . $_POST["url"] . '/admin">Go to admin panel</a> </p>';
            echo '<p class="alert alert-warning">Do not forget to delete "install.php" file!</p>';
        } elseif ($config_json == "You can use one license only one website.") {
            echo '<p class="alert alert-warning">You can use one license only one website.</p>';
        } else {
            echo '<p class="alert alert-warning">Installation failed. Check input data and try again or contact with seller.</p>';
        }
    }
    ?>
    <img class="mb-4" src="assets/img/favicon.png" alt="all in one video downloader" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Installation</h1>
    <input name="url" type="url" class="form-control" placeholder="Website URL" required autofocus>
    <input name="title" type="text" class="form-control" placeholder="Website Title" required autofocus>
    <input name="author" type="text" class="form-control" placeholder="Website Owner" required autofocus>
    <input name="email" type="email" class="form-control" placeholder="Owner's E-mail" required autofocus>
    <input name="password" type="password" class="form-control" placeholder="Admin Panel Password" required autofocus>
    <input name="purchase_code" type="password" class="form-control" placeholder="Purchase Code" required autofocus>
    <input name="description" type="hidden" value="">
    <input name="language" type="hidden" value="en">
    <input name="template" type="hidden" value="start">
    <input name="tracking" type="hidden" value="off">
    <input name="auto-update" type="hidden" value="on">
    <input name="version" type="hidden" value="MTM0MDguMTI4MzIuNzUwNA==4">
    <input name="checksum" type="hidden" value="<?php echo sha1_file(__DIR__ . "/system/action.php") ?>">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Install</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
</form>
</body>
</html>