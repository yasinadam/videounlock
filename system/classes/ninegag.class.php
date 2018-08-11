<?php

class ninegag
{
    public function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public function media_info($url)
    {
        $path = parse_url($url, PHP_URL_PATH);
        $pieces = explode('/', $path);
        $id = $pieces[2];
        $result = url_get_contents($url);
        $videoHDlink = "https://img-9gag-fun.9cache.com/photo/" . $id . "_460sv.mp4";
        $videoSDlink = "https://img-9gag-fun.9cache.com/photo/" . $id . "_460svwm.webm";
        if ($videoSDlink) {
            $data['found'] = 1;
            $data['id'] = $id;
            $links = array();
            $links['SD'] = $videoSDlink;
            if (!empty($videoHDlink)) {
                $links['HD'] = $videoHDlink;
            }
            $image = "http://images-cdn.9gag.com/photo/" . $id . "_460s.jpg";
            $data['image'] = $image;
            if ($result) {
                $title = $this->get_string_between($result, '<meta property="og:title" content="', '" />');;
                $description = $this->get_string_between($result, '<meta property="og:description" content="', '" />');
                $data['title'] = $title;
                $data['description'] = $description;
            }
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
        $media_info = $data;
        $video["source"] = "9gag";
        $video["title"] = $media_info["title"];
        $video["thumbnail"] = $media_info["image"];
        $i = 0;
        foreach ($media_info["videos"] as $current) {
            $video["links"][$i]["url"] = $current["url"];
            $video["links"][$i]["type"] = "mp4";
            $video["links"][$i]["size"] = get_file_size($video["links"][$i]["url"]);
            $video["links"][$i]["quality"] = $current["formatId"];
            $video["links"][$i]["mute"] = "no";
            $i++;
        }
        return $video;
    }
}