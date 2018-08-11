$(document).ready(function () {
    var executed = false;
    var get_location = function (href) {
        var l = document.createElement("a");
        l.href = href;
        return l;
    };

    $(window).bind('hashchange', function () {
        url();
    });

    var input = document.getElementById("url");
    input.addEventListener("keyup", function(event) {
        event.preventDefault();
        if (event.keyCode === 13) {
            document.getElementById("send").click();
        }
    });


    url();

    $('#send').click(function (e) {
        var url = $('#url').val();
        if (url !== "") {
            executed = true;
            document.getElementById("send").disabled = true;
            $('#loading').html('<i class="fas fa-spinner fa-spin"></i>');
            var token = $('#token').val();
            scroll("500");
            var parseUrl = get_location(url);
            if (parseUrl.hostname === "twitter.com") {
                twitter(url, token);
            } else {
                submit(url, token);
            }
            remove_hash();
            window.location.replace("#url=" + url);
        }
        e.preventDefault();
    });

    function url() {
        if (window.location.href.indexOf("#url=") > -1 && executed === false) {
            var url = window.location.href.match(new RegExp("#url=(.+)", ""))[1];
            var token = $('#token').val();
            $('#url').val(url);
            if (url !== "") {
                document.getElementById("send").disabled = true;
                $('#loading').html('<i class="fas fa-spinner fa-spin"></i>');
                scroll("500");
                var parseUrl = get_location(url);
                if (parseUrl.hostname === "twitter.com") {
                    twitter(url, token);
                } else {
                    submit(url, token);
                }
            }
        }
    }

    function submit(url, token) {
        $.post("system/action.php", {url: url, token: token}, function (data) {
            if (data !== "error" && data.title !== "") {
                var links_html_code = "";
                var audio_links_html_code = "";
                var links = data.links;
                var audio_link = 0;
                var video_link = 0;
                links.forEach(function (link) {
                    if (link.url !== null) {
                        var downloadTitle = btoa(unescape(encodeURIComponent(data.title)));
                        var link_row = "";
                        switch (true) {
                            case(link.type === "mp3" || link.type === "m4a" && data.source === "youtube"):
                                link_row = '<tr><td>{{quality}}</td><td>{{type}}</td><td>{{size}}</td><td><a target="_blank" href="{{url}}" class="btn btn-sm btn-secondary"><i class="fas fa-download"></i></a></td></tr>';
                                link_row = link_row.replace(new RegExp("{{quality}}", "g"), link.quality);
                                link_row = link_row.replace(new RegExp("{{type}}", "g"), link.type);
                                link_row = link_row.replace(new RegExp("{{size}}", "g"), link.size);
                                link_row = link_row.replace(new RegExp("{{url}}", "g"), "?source=" + data.source + "&title=" + downloadTitle + "&type=" + link.type + "&download=" + encodeURIComponent(link.url));
                                audio_links_html_code = link_row;
                                audio_link++;
                                break;
                            case(data.source === "youtube" && link.hide === true && link.type !== "webm"):
                                link_row = '<tr class="collapse hidden-video"><td>{{quality}}</td><td>{{type}}</td><td>{{size}}</td><td><a target="_blank" href="{{url}}" class="btn btn-sm btn-secondary"><i class="fas fa-download"></i></a></td></tr>';
                                link_row = link_row.replace(new RegExp("{{quality}}", "g"), link.quality + '<span class="fa-stack"><i class="fa fa-volume-up fa-stack-1x"></i><i class="fa fa-ban fa-stack-2x text-danger"></i></span>');
                                link_row = link_row.replace(new RegExp("{{type}}", "g"), link.type);
                                link_row = link_row.replace(new RegExp("{{size}}", "g"), link.size);
                                link_row = link_row.replace(new RegExp("{{url}}", "g"), "?source=" + data.source + "&title=" + downloadTitle + "&type=" + link.type + "&download=" + encodeURIComponent(link.url));
                                links_html_code = links_html_code.concat(link_row);
                                video_link++;
                                break;
                            case(data.source === "youtube" && link.hide === true && link.type === "webm"):
                                link_row = '<tr class="collapse hidden-video"><td>{{quality}}</td><td>{{type}}</td><td>{{size}}</td><td><a target="_blank" href="{{url}}" class="btn btn-sm btn-secondary"><i class="fas fa-download"></i></a></td></tr>';
                                link_row = link_row.replace(new RegExp("{{quality}}", "g"), link.quality);
                                link_row = link_row.replace(new RegExp("{{type}}", "g"), link.type);
                                link_row = link_row.replace(new RegExp("{{size}}", "g"), link.size);
                                link_row = link_row.replace(new RegExp("{{url}}", "g"), "?source=" + data.source + "&title=" + downloadTitle + "&type=" + link.type + "&download=" + encodeURIComponent(link.url));
                                links_html_code = links_html_code.concat(link_row);
                                video_link++;
                                break;
                            default:
                                link_row = '<tr><td>{{quality}}</td><td>{{type}}</td><td>{{size}}</td><td><a target="_blank" href="{{url}}" class="btn btn-sm btn-secondary"><i class="fas fa-download"></i></a></td></tr>';
                                link_row = link_row.replace(new RegExp("{{quality}}", "g"), link.quality);
                                link_row = link_row.replace(new RegExp("{{type}}", "g"), link.type);
                                link_row = link_row.replace(new RegExp("{{size}}", "g"), link.size);
                                link_row = link_row.replace(new RegExp("{{url}}", "g"), "?source=" + data.source + "&title=" + downloadTitle + "&type=" + link.type + "&download=" + encodeURIComponent(link.url));
                                links_html_code = links_html_code.concat(link_row);
                                video_link++;
                                break;
                        }
                    }
                });
                var table_url = "";
                switch (true) {
                    case(audio_link > 0 && video_link === 0):
                        table_url = "template/start/areas/downloads-table.php?audio=true";
                        break;
                    case(audio_link > 0 && video_link > 0):
                        table_url = "template/start/areas/downloads-table.php?video=true&audio=true";
                        break;
                    default:
                        table_url = "template/start/areas/downloads-table.php?video=true";
                        break;

                }
                $.get(table_url, function (template) {
                    template = template.replace(new RegExp("{{video_title}}", "g"), data.title);
                    template = template.replace(new RegExp("{{video_thumbnail}}", "g"), data.thumbnail);
                    template = template.replace(new RegExp("{{video_duration}}", "g"), data.duration);
                    template = template.replace(new RegExp("{{page_link}}", "g"), window.location.href);
                    if (video_link > 0) {
                        template = template.replace(new RegExp("{{video_links}}", "g"), links_html_code);
                    }
                    if (audio_link > 0) {
                        template = template.replace(new RegExp("{{audio_links}}", "g"), audio_links_html_code);
                    }
                    $('#links').html(template);
                    if (data.source !== "youtube") {
                        $('#show-all-small').remove();
                    }
                    if (data.duration === undefined) {
                        $('#duration').remove();
                    }
                });
                $('.fa-spinner').remove();
                document.getElementById("send").disabled = false;
            } else {
                alert();
            }
        })
    }

    function twitter(url, token) {
        var fail = "";
        var cb = new Codebird;
        var tweet_url = url;
        cb.setConsumerKey("K0w8rlDCB6zBB739TGt1BLY2n", "3dk9oqc7CQoI90fCyk9JcZEvS88bvkP1YHxI3ylyorl1cNaD5H");
        cb.setProxy(base_url() + "/assets/js/codebird-cors-proxy/");
        var s_url = tweet_url.split("/")[5];
        if ((tweet_url.indexOf("twitter.com") === -1) || s_url === undefined) {
            fail += "Please enter a valid twitter link";
            alert();
        } else {
            var v0;
            var v144;
            var v480;
            var v720;
            var v1080;
            cb.__call(
                "statuses_show_ID",
                "id=" + s_url,
                null,
                true
            ).then(function (data) {
                if (data.reply.extended_entities == null && data.reply.entities.media == null) {
                }
                else if ((data.reply.extended_entities.media[0].type) !== "video" && (data.reply.extended_entities.media[0].type) !== "animated_gif") {
                } else {
                    if (data.reply.extended_entities.media[0].video_info.variants[0].content_type === 'video/mp4') {
                        v0 = data.reply.extended_entities.media[0].video_info.variants[0].url;
                    }
                    if (data.reply.extended_entities.media[0].video_info.variants[1].content_type === 'video/mp4') {
                        v144 = data.reply.extended_entities.media[0].video_info.variants[1].url;
                    }
                    if (data.reply.extended_entities.media[0].video_info.variants[2].content_type === 'video/mp4') {
                        v480 = data.reply.extended_entities.media[0].video_info.variants[2].url;
                    }
                    if (data.reply.extended_entities.media[0].video_info.variants[3].content_type === 'video/mp4') {
                        v720 = data.reply.extended_entities.media[0].video_info.variants[3].url;
                    }
                    submit(url + "?v144=" + v144 + "&v480=" + v480 + "&v720=" + v720 + "&v0=" + v0, token);
                }
            });
        }
    }

    function base_url() {
        var pathparts = location.pathname.split('/');
        if (location.host === 'localhost') {
            var url = location.origin + '/' + pathparts[1].trim('/') + '/';
        } else {
            var url = location.origin;
        }
        return url;
    }

    function scroll(ratio) {
        var scroll_pixels = (ratio * screen.height) / 768;
        window.scrollBy(0, scroll_pixels);
    }

    function remove_hash() {
        history.pushState("", document.title, window.location.pathname
            + window.location.search);
    }

    function alert() {
        $('.fa-spinner').remove();
        $.get("template/start/areas/error-alert.php", function (alert) {
            $('#alert').html(alert);
        });
        $("#alert").fadeTo(4500, 1000).slideUp(1000, function () {
            $("#alert").slideUp(3000);
        });
        document.getElementById("send").disabled = false;
    }
});