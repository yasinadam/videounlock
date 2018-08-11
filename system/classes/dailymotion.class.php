<?php

class dailymotion
{
    public $url;

    function base_url()
    {
        return sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            $_SERVER['REQUEST_URI']
        );
    }

    function truncate($string, $length)
    {
        $string = trim(strip_tags($string));
        if (strlen($string) > $length) {
            $string = substr($string, 0, $length) . '...';
        }
        return $string;
    }

    function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    function find_video_id($url)
    {
        $domain = str_ireplace("www.", "", parse_url($url, PHP_URL_HOST));
        switch (true) {
            case($domain == "dai.ly"):
                $video_id = str_replace('https://dai.ly/', "", $url);
                $video_id = str_replace('/', "", $video_id);
                return $video_id;
                break;
            case($domain == "dailymotion.com"):
                $url_parts = parse_url($url);
                $path_arr = explode("/", rtrim($url_parts['path'], "/"));
                $video_id = $path_arr[2];
                return $video_id;
                break;
        }
    }

    function media_info($url)
    {
        $url = "http://www.dailymotion.com/video/" . $this->find_video_id($url);
        $data = array();
        $data['found'] = 0;
        $urlParts = parse_url($url);
        if (isset($urlParts['path'])) {
            $pathArr = explode("/", rtrim($urlParts['path'], "/"));
            if (count($pathArr) == 3 && $pathArr[1] == "video") {
                $id = $pathArr[2];
                $result = url_get_contents("https://api.dailymotion.com/video/" . $id . "?fields=title,description,thumbnail_url,duration");
                if ($result) {
                    $result = json_decode($result, true);
                    $data['found'] = 1;
                    $data['id'] = $id;
                    $title = (isset($result['title']) ? htmlentities($result['title'], ENT_QUOTES) : "Video By Dailymotion");
                    $data['title'] = $title;
                    if (isset($result['description']) && !empty($result['description'])) {
                        $data['description'] = htmlentities($this->truncate(trim(preg_replace('/[\s]+/', ' ', preg_replace("/\r|\n/", " ", $result['description']))), 250), ENT_QUOTES);
                    } else {
                        $data['description'] = "Download " . $title . " From Dailymotion";
                    }
                    $data['image'] = str_replace("http", "https", $result['thumbnail_url']);
                    $duration = $result['duration'];
                    $data['time'] = gmdate(($duration > 3600 ? "H:i:s" : "i:s"), $duration);
                    $formatCodes = array(
                        "144" => array("order" => "1", "height" => "144", "ext" => "mp4", "resolution" => "144p", "video" => "true", "video_only" => "false"),
                        "240" => array("order" => "2", "height" => "240", "ext" => "mp4", "resolution" => "240p", "video" => "true", "video_only" => "false"),
                        "380" => array("order" => "3", "height" => "380", "ext" => "mp4", "resolution" => "380p", "video" => "true", "video_only" => "false"),
                        "480" => array("order" => "4", "height" => "480", "ext" => "mp4", "resolution" => "480p", "video" => "true", "video_only" => "false"),
                        "720" => array("order" => "5", "height" => "720", "ext" => "mp4", "resolution" => "720p", "video" => "true", "video_only" => "false"),
                        "1080" => array("order" => "6", "height" => "1080", "ext" => "mp4", "resolution" => "1080p", "video" => "true", "video_only" => "false")
                    );
                    $videoFormatsData = url_get_contents("https://www.dailymotion.com/embed/video/" . $id);
                    $videoFormatsData = $this->get_string_between($videoFormatsData, "config = ", "}};");
                    $videoFormatsData .= "}}";
                    $videoFormatsData = json_decode($videoFormatsData, true);
                    $streams = $videoFormatsData['metadata']['qualities'];
                    $videos = array();
                    foreach ($streams as $formatId => $stream) {
                        if (array_key_exists($formatId, $formatCodes)) {
                            $link = array();
                            $formatData = $formatCodes[$formatId];
                            $link['data'] = $formatData;
                            $link['formatId'] = $formatId;
                            $link['order'] = $formatData['order'];
                            $link['url'] = $stream[1]['url'];
                            $link['title'] = $title . "." . $formatData['ext'];
                            $link['size'] = "unknown";
                            array_push($videos, $link);
                        }
                    }
                    $orders = array();
                    foreach ($videos as $key => $row) {
                        $orders[$key] = $row['order'];
                    }
                    array_multisort($orders, SORT_DESC, $videos);
                    $data['videos'] = $videos;
                }
            }
        }
        return $this->format_data($data);
    }

    function format_data($data)
    {
        $video["title"] = $data["title"];
        $video["source"] = "dailymotion";
        $video["thumbnail"] = $data["image"];
        $video["duration"] = $data["time"];
        $i = 0;
        foreach ($data["videos"] as $current) {
            $video["links"][$i]["url"] = $current["url"];
            $video["links"][$i]["type"] = "mp4";
            $video["links"][$i]["size"] = get_file_size($video["links"][$i]["url"]);
            $video["links"][$i]["quality"] = $current["formatId"] . "P";
            $video["links"][$i]["mute"] = "no";
            $i++;
        }
        $video["links"] = array_reverse($video["links"]);
        return $video;
    }
}