<?php

class instagram
{
    public $url;

    function media_info($url)
    {
        $curl_content = url_get_contents($url);
        $video["title"] = $this->get_title($curl_content);
        $video["source"] = "instagram";
        $video["thumbnail"] = $this->get_thumbnail($curl_content);
        switch ($this->get_type($curl_content)) {
            case "instapp:photo":
                $video["links"]["0"]["url"] = $this->get_thumbnail($curl_content);
                $video["links"]["0"]["type"] = "jpg";
                $video["links"]["0"]["size"] = get_file_size($video["links"]["0"]["url"]);
                $video["links"]["0"]["quality"] = "HD";
                $video["links"]["0"]["mute"] = "yes";
                break;
            case "video":
                $video["links"]["0"]["url"] = $this->get_video($curl_content);
                $video["links"]["0"]["type"] = "mp4";
                $video["links"]["0"]["size"] = get_file_size($video["links"]["0"]["url"]);
                $video["links"]["0"]["quality"] = "HD";
                $video["links"]["0"]["mute"] = "no";
                break;
        }
        return $video;
    }

    function get_type($curl_content)
    {
        if (preg_match_all('@<meta property="og:type" content="(.*?)" />@si', $curl_content, $match)) {
            return $match[1][0];
        }
    }

    function get_image($curl_content)
    {

        if (preg_match_all('@<meta property="og:image" content="(.*?)" />@si', $curl_content, $match)) {
            return $match[1][0];
        }

    }

    function get_video($curl_content)
    {

        if (preg_match_all('@<meta property="og:video" content="(.*?)" />@si', $curl_content, $match)) {
            return $match[1][0];
        }

    }

    function get_thumbnail($curl_content)
    {
        if (preg_match_all('@<meta property="og:image" content="(.*?)" />@si', $curl_content, $match)) {
            return $match[1][0];
        }
    }

    function get_title($curl_content)
    {
        if (preg_match_all('@<title>(.*?)</title>@si', $curl_content, $match)) {
            return $match[1][0];
        }
    }
}