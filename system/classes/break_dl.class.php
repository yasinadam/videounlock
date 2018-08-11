<?php

class break_dl
{
    function media_info($url)
    {
        $data = array();
        $data['found'] = 0;
        $resultM = url_get_contents($url);
        if ($resultM) {
            $result = $this->get_string_between($resultM, '<iframe width=', ' frameborder');
            if ($result) {
                $link = $this->get_string_between($result, 'src="', '?');
                $urlParts = parse_url($link);
                if (isset($urlParts['host']) && $urlParts['host'] = "www.youtube.com") {
                    if (isset($urlParts['path'])) {
                        $pathArr = explode("/", rtrim($urlParts['path'], "/"));
                        $vid = $pathArr[2];
                        if (count($pathArr) == 3 && $pathArr[1] == "embed") {
                            $linkUrl = "https://www.youtube.com/watch?v=" . $vid;
                            $data['found'] = 0;
                            $data['original_url'] = $linkUrl;
                        }
                    }
                }
            } else {
                $result = $this->get_string_between($resultM, 'var clipvars = ', ';');
                $data['found'] = 1;
                $title = $this->get_string_between($resultM, '<title>', '</title>');
                $data['title'] = $title;
                $data['description'] = "Download " . $title . " From Break";
                $data['image'] = $this->get_string_between($resultM, 'defaultThumbnailUrl": "', '"');
                //$duration  = $result['videoLengthInSeconds'];
                //$data['time'] = gmdate(($duration > 3600 ? "H:i:s" : "i:s"), $duration);
                $videoSDlink = $this->get_string_between($resultM, '[{"url":"', '"');
                $links = array();
                $links['SD'] = $videoSDlink;
                $formatCodes = array(
                    "SD" => array("order" => "1", "height" => "{{height}}", "ext" => "mp4", "resolution" => "SD", "video" => "true", "video_only" => "false"),
                    "HD" => array("order" => "2", "height" => "{{height}}", "ext" => "mp4", "resolution" => "HD", "video" => "true", "video_only" => "false")
                );
                $videos = array();
                foreach ($formatCodes as $formatId => $formatData) {
                    if (isset($links[$formatId])) {
                        $link = array();
                        $link['data'] = $formatData;
                        $link['formatId'] = $formatId;
                        $link['order'] = $formatData['order'];
                        $link['url'] = $links[$formatId];
                        $link['title'] = $title . "." . $formatData['ext'];
                        $link['size'] = "unknown";
                        array_push($videos, $link);
                    }
                }
                $data['videos'] = $videos;
            }
        }
        if ($data['found'] === 1) {
            return $this->format_data($data);
        } else {
            include(__DIR__ . "/youtube.class.php");
            $download = new youtube();
            return $download->media_info($data["original_url"]);
        }
    }

    function format_data($data)
    {
        $video["title"] = $data["title"];
        $video["source"] = "break";
        $video["thumbnail"] = $data["image"];
        $i = 0;
        foreach ($data["videos"] as $current) {
            $video["links"][$i]["url"] = $current["url"];
            $video["links"][$i]["type"] = "mp4";
            $video["links"][$i]["size"] = get_file_size($video["links"][$i]["url"]);
            $video["links"][$i]["quality"] = $current["formatId"];
            $video["links"][$i]["mute"] = "no";
            $i++;
        }
        return $video;
    }

    function get_string_between($string, $start, $end)
    {
        $string = " " . $string;
        $ini = strpos($string, $start);
        $eni = strpos($string, $end);
        if ($ini == 0 || $eni == 0) return "";
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}