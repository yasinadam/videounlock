<?php if(template_config("about") == "true"){ ?>
<section id="advertising" data-spy="scroll" data-target="#nav-scroll" data-offset="0">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-3">
                <h5 class="mb-3"><?php echo $lang["multiple-sources"]; ?></h5>
                <p>
                    <?php echo $lang["about"]; ?>
                <ul>
                    <li>YouTube,    Twitter, ESPN</li>
                    <li>Facebook,   Instagram, IMDb</li>
                    <li>Vimeo,  Dailymotion, İzlesene</li>
                    <li>Imgur,  Tumblr, Bandcamp</li>
                    <li>TED,    LiveLeak, Flickr</li>
                    <li>Mashable,   VK, Soundcloud</li>
                    <li>9GAG,   Break, TV.com</li>
                </ul>
                <?php echo $lang["coming-soon"]; ?>
                </p>
            </div>
            <div class="col-md-6">
                <img src="<?php config("url", true); ?>/template/start/assets/img/supported-sources.png" alt="">
            </div>
        </div>
    </div>
</section>
<?php } ?>