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
    <link href="./assets/css/paper-dashboard.css" rel="stylesheet"/>
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="./assets/css/themify-icons.css" rel="stylesheet">
    <style>
        .login-page {
            background-image: url(./assets/img/background-1.jpg);
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-color: #999;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-transparent navbar-absolute">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="https://goo.gl/QWSZpN">All in One Video Downloader</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="../.">
                        Go to website
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="wrapper wrapper-full-page">
    <div class="full-page login-page" data-color="blue">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                        <?php if(isset($_GET["failed-login"]) == "1"){?>
                        <p class="alert alert-danger">E-mail or password wrong!</p>
                        <?php } ?>
                        <form method="post" action="login.php">
                            <div class="card" data-background="color" data-color="blue">
                                <div class="card-header">
                                    <h3 class="card-title">Login</h3>
                                </div>
                                <div class="card-content">
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input name="email" type="email" placeholder="Enter email"
                                               class="form-control input-no-border">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input name="password" type="password" placeholder="Password"
                                               class="form-control input-no-border">
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-fill btn-wd ">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer footer-transparent">
            <div class="container">
                <div class="copyright">
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