<?php require_once(__DIR__ . "/../../../system/config.php"); ?>
<div class="col-md-4">
    <span class="badge badge-info badge-duration" id="duration">{{video_duration}}</span>
    <img class="img-thumbnail" src="{{video_thumbnail}}" alt="{{video_title}}">
    <p>{{video_title}}</p>
    <div id="share-buttons">
        <p class="lead"><strong><?php echo $lang["share"]; ?></strong></p>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{page_link}}" class="btn btn-facebook btn-sm btn-block"
           target="_blank"><i class="fab fa-facebook fa-fw"></i> Facebook</a>
        <a href="https://twitter.com/home?status=Download%20{{video_title}}%20here%20{{page_link}}"
           class="btn btn-twitter btn-sm btn-block" target="_blank"><i class="fab fa-twitter fa-fw"></i> Twitter</a>
        <a href="https://plus.google.com/share?url={{page_link}}" class="btn btn-google btn-sm btn-block"
           target="_blank"><i class="fab fa-google fa-fw"></i> Google+</a>
        <a href="https://pinterest.com/pin/create/button/?url={{page_link}}&media={{video_thumbnail}}&description={{video_title}}"
           class="btn btn-pinterest btn-sm btn-block" target="_blank"><i class="fab fa-pinterest-p fa-fw"></i> Pinterest</a>
    </div>
    <?php include(__DIR__ . "/advertising-300_300.php") ?>
</div>
<div class="col-md-8">
    <?php if (isset($_GET["video"]) === true) { ?>
    <h5><i class="far fa-file-video"></i> <?php echo $lang["video"]; ?> <small id="show-all-small"><button class="btn btn-sm btn-outline-secondary" data-toggle="collapse" data-target=".hidden-video" aria-pressed="false" id="show-all" title="<?php echo $lang["show-all"]; ?>"><span class="arrow-up"><i class="fas fa-chevron-circle-up"></i></span><span class="arrow-down"><i class="fas fa-chevron-circle-down"></i></span></button></small></h5>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th class="quality" width="25%">
                    <?php echo $lang["quality"]; ?>
                </th>
                <th class="format" width="25%">
                    <?php echo $lang["format"]; ?>
                </th>
                <th class="size" width="25%">
                    <?php echo $lang["size"]; ?>
                </th>
                <th class="downloads" width="25%">
                    <?php echo $lang["downloads"]; ?>
                </th>
            </tr>
            </thead>
            <tbody class="video-links">
            {{video_links}}
            </tbody>
        </table>
    </div>
    <?php } ?>
    <?php if (isset($_GET["audio"]) === true) { ?>
        <h5><i class="far fa-file-audio"></i> <?php echo $lang["audio"]; ?></h5>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th class="quality" width="25%">
                        <?php echo $lang["quality"]; ?>
                    </th>
                    <th class="format" width="25%">
                        <?php echo $lang["format"]; ?>
                    </th>
                    <th class="size" width="25%">
                        <?php echo $lang["size"]; ?>
                    </th>
                    <th class="downloads" width="25%">
                        <?php echo $lang["downloads"]; ?>
                    </th>
                </tr>
                </thead>
                <tbody class="video-links">
                {{audio_links}}
                </tbody>
            </table>
        </div>
    <?php } ?>
</div>