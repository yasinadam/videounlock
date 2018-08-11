<?php if (isset($_SESSION["logged"]) === true) { ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8"/>
        <link rel="icon" type="image/png" sizes="96x96" href=".././assets/img/favicon.png">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <title>All in One Video Downloader Dashboard</title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
        <meta name="viewport" content="width=device-width"/>
        <link href="./assets/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="./assets/css/animate.min.css" rel="stylesheet"/>
        <link href="./assets/css/paper-dashboard-min.css" rel="stylesheet"/>
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
        <link href="./assets/css/themify-icons.css" rel="stylesheet">
    </head>
    <body>

    <div class="wrapper">
        <div class="sidebar" data-background-color="white" data-active-color="danger">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="https://nicheoffice.web.tr" class="simple-text">
                        Niche Office
                    </a>
                </div>

                <ul class="nav">
                    <li>
                        <a href="?view=default">
                            <i class="ti-panel"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a href="?view=general">
                            <i class="ti-world"></i>
                            <p>General Settings</p>
                        </a>
                    </li>
                    <li>
                        <a href="?view=api">
                            <i class="ti-key"></i>
                            <p>API Settings</p>
                        </a>
                    </li>
                    <li>
                        <a href="?view=advertising">
                            <i class="ti-eye"></i>
                            <p>Ads Settings</p>
                        </a>
                    </li>
                    <li>
                        <a href="?view=theme">
                            <i class="ti-ruler-pencil"></i>
                            <p>Theme Settings</p>
                        </a>
                    </li>
                    <li>
                        <a href="?view=page">
                            <i class="ti-write"></i>
                            <p>Pages Settings</p>
                        </a>
                    </li>
                    <li>
                        <a href="?view=about">
                            <i class="ti-info-alt"></i>
                            <p>About</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-panel">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar bar1"></span>
                            <span class="icon-bar bar2"></span>
                            <span class="icon-bar bar3"></span>
                        </button>
                        <a class="navbar-brand" href="#">Dashboard</a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="../.">
                                    <p>Go to website</p>
                                </a>
                            </li>
                            <li>
                                <a href="?view=logout">
                                    <i class="ti-shift-right"></i>
                                    <p>Logout</p>
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>


            <div class="content">
                <div class="container-fluid">
                    <?php
                    if (isset($_GET["view"]) != "") {
                        $view = filter_var($_GET["view"], FILTER_SANITIZE_STRING);
                        if (file_exists(__DIR__ . "/" . $view . ".php")) {
                            include(__DIR__ . "/" . $view . ".php");
                        } else {
                            include(__DIR__ . "/default.php");
                        }
                    } else {
                        include(__DIR__ . "/default.php");
                    }
                    ?>
                </div>
            </div>


            <footer class="footer">
                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul>
                            <li>
                                <a href="https://codecanyon.net/item/all-in-one-video-downloader/21242606">
                                    Product Page
                                </a>
                            </li>
                            <li>
                                <a href="https://codecanyon.net/item/all-in-one-video-downloader/21242606/support">
                                    Support
                                </a>
                            </li>
                            <li>
                                <a href="?view=password">
                                    Change password
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="copyright pull-right">
                        &copy;
                        <script>document.write(new Date().getFullYear())</script>
                        <a href="https://nicheoffice.web.tr">Niche Office</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    </body>
    <script src="./assets/js/jquery-1.10.2.js" type="text/javascript"></script>
    <script src="./assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="./assets/js/bootstrap-checkbox-radio.js"></script>
    <script src="./assets/js/chartist.min.js"></script>
    <script src="./assets/js/bootstrap-notify.js"></script>
    <script src="./assets/js/paper-dashboard.js"></script>
    </html>
<?php } else {
    http_response_code(403);
} ?>