<header class="landing-page-template parallax">
    <div class="container">
        <div class="header-content text-center">
            <img src="<?php config("url", true); ?>/assets/img/videounlock-logo.png" class="header-logo"
                 alt="<?php config("title", true) ?>">
            <h1 class="text-white header-title"><?php echo $lang["homepage-slogan"]; ?></h1>
            <div class="col-md-8 m-auto">
                <form>
                    <div class="input-group">
                        <input name="url" type="url" id="url" class="form-control"
                               placeholder="<?php echo $lang["placeholder"]; ?>">
                        <input type="hidden" name="token" id="token" value="<?php echo $_SESSION["token"]; ?>">
                        <span class="input-group-btn">
                        <button class="btn btn-primary btn-download" type="button" id="send"><i
                                    class="fas fa-download"></i></button>
                    </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>

<?php include(__DIR__ . "/areas/advertising-728_90.php"); ?>

<div class="loading-spinner text-xl text-center" id="loading"></div>
<div id="alert"></div>

<section data-spy="scroll" data-target="#nav-scroll" data-offset="0">
    <div class="spacer">&nbsp;</div>
    <div class="container">
        <div class="row" id="links"></div>
    </div>
</section>

<div class="spacer">&nbsp;</div>

<?php include(__DIR__ . "/areas/services-list.php") ?>