<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="<?php config("description", true); ?>">
    <meta name="author" content="<?php config("author", true); ?>"/>
    <meta name="generator" content="AIO Video Downloader (https://goo.gl/QWSZpN)"/>
    <title><?php config("title", true); ?></title>
    <meta itemprop="name" content="<?php config("title", true); ?>">
    <meta itemprop="description" content="<?php config("description", true); ?>">
    <meta itemprop="image" content="<?php config("url", true); ?>/assets/img/social-media-banner.png">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?php config("title", true); ?>">
    <meta name="twitter:description" content="<?php config("description", true); ?>">
    <meta name="twitter:image:src" content="<?php config("url", true); ?>/assets/img/social-media-banner.png">
    <meta property="og:title" content="<?php config("title", true); ?>">
    <meta property="og:type" content="article">
    <meta property="og:image" content="<?php config("url", true); ?>/assets/img/social-media-banner.png">
    <meta property="og:description" content="<?php config("description", true); ?>">
    <meta property="og:site_name" content="<?php config("title", true); ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?php config("url", true); ?>/template/start/assets/css/style.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css"/>
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,500" rel="stylesheet">
    <link rel="stylesheet" href="<?php config("url", true); ?>/template/start/assets/css/custom.css"/>
    <link rel="shortcut icon" href="<?php config("url", true); ?>/assets/img/favicon.png"/>
    <meta name="theme-color" content="#3f50b5">
</head>
<body class="page" data-spy="scroll" data-target="#nav-scroll">

<nav class="navbar navbar-expand-lg navbar-inverse bg-primary sticky-top">
    <div class="container no-padding">
        <a class="navbar-brand" href="<?php config("url", true); ?>"><img
                    src="<?php config("url", true); ?>/assets/img/videounlock-logo.png"
                    alt="<?php config("url", true); ?>"></a>

        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="main-menu">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?php config("url", true); ?>"><?php echo $lang["home"] ?></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="?page=tos">Copyright Notice</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="?page=faq">FAQ</a>
                </li>
                
                <?php
                //build_menu();
                /*if (template_config("tos") == "true") {
                    echo "<li class='nav-item'><a class='nav-link smooth-scroll' href='?page=tos'>" . $lang["terms-of-service"] . "</a></li>";
                }
                if (template_config("contact") == "true") {
                    echo "<li class='nav-item'><a class='nav-link smooth-scroll' href='?page=contact'>" . $lang["contact"] . "</a></li>";
                }*/
                ?>
                <?php
                /*<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false"><?php echo $lang["language"]; ?></a>
                    <div class="dropdown-menu language-list" aria-labelledby="dropdown01">
                        <?php list_languages(); ?>
                    </div>
                </li>*/
                ?>
            </ul>
        </div>
    </div>
</nav>