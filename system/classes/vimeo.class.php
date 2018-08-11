<?php

class vimeo
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
        if (preg_match_all('/https:\/\/vimeo.com\/(channels|([^"]+))(\/staffpicks\/([^"]+)|)/', $url, $match)) {
            if (is_numeric($match[1][0])) {
                return $match[1][0];
            } else if (is_numeric($match[4][0])) {
                return $match[4][0];
            }
        }
    }

    function media_info($url)
    {
        $data = array();
        $data['found'] = 0;
        $id = $this->find_video_id($url);
        if (is_numeric($id)) {
            $result = url_get_contents("https://vimeo.com/api/v2/video/" . $id . ".json");
            if ($result) {
                $result = json_decode($result, true);
                $data['id'] = $id;
                $data['found'] = 1;
                $title = (isset($result[0]['title']) ? htmlentities($result[0]['title'], ENT_QUOTES) : "Video By Vimeo");
                $data['title'] = $title;
                $data['image'] = (isset($result[0]['thumbnail_large']) ? $result[0]['thumbnail_large'] : $result[0]['thumbnail_medium']);
                $duration = $result[0]['duration'];
                $data['time'] = gmdate(($duration > 3600 ? "H:i:s" : "i:s"), $duration);
                $formatCodes = array(
                    "270p" => array("order" => "1", "height" => "270", "ext" => "mp4", "resolution" => "270p", "video" => "true", "video_only" => "false"),
                    "360p" => array("order" => "2", "height" => "360", "ext" => "mp4", "resolution" => "360p", "video" => "true", "video_only" => "false"),
                    "540p" => array("order" => "3", "height" => "540", "ext" => "mp4", "resolution" => "540p", "video" => "true", "video_only" => "false"),
                    "720p" => array("order" => "4", "height" => "720", "ext" => "mp4", "resolution" => "720p", "video" => "true", "video_only" => "false"),
                    "1080p" => array("order" => "5", "height" => "1080", "ext" => "mp4", "resolution" => "1080p", "video" => "true", "video_only" => "false")
                );
                $videoFormatsData = url_get_contents("https://player.vimeo.com/video/" . $id);
                $videoFormatsData = $this->get_string_between($videoFormatsData, '"request":{"files":', ',"lang":"en"');
                $videoFormatsData = json_decode($videoFormatsData, true);
                $videoStreams = $videoFormatsData['progressive'];
                $videos = array();
                foreach ($videoStreams as $stream) {
                    $formatId = $stream['quality'];
                    if (array_key_exists($formatId, $formatCodes)) {
                        $link = array();
                        $formatData = $formatCodes[$formatId];
                        $link['data'] = $formatData;
                        $link['formatId'] = $formatId;
                        $link['order'] = $formatData['order'];
                        $link['url'] = $stream['url'];
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
        return $this->format_data($data);
    }

    function format_data($data)
    {
        $video["title"] = $data["title"];
        $video["source"] = "vimeo";
        $video["thumbnail"] = $data["image"];
        $video["duration"] = $data["time"];
        $i = 0;
        foreach ($data["videos"] as $current) {
            $video["links"][$i]["url"] = $current["url"];
            $video["links"][$i]["type"] = "mp4";
            $video["links"][$i]["size"] = get_file_size($video["links"][$i]["url"]);
            $video["links"][$i]["quality"] = $current["formatId"];
            $video["links"][$i]["mute"] = "no";
            $i++;
        }
        $video["links"] = array_reverse($video["links"]);
        return $video;
    }
}