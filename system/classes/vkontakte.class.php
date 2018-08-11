<?php

class vk
{
    function media_info($url)
    {
        $url = str_replace("just_vid?w=", "", $url);
        $curl_content = url_get_contents($url);
        if (preg_match_all('<meta property="og:title" content="(.*?)"/>', $curl_content, $match)) {
            $data["title"] = $match[1][0];
        } else {
            $data["title"] = "VK-" . $this->generate_random_string();
        }
        if (preg_match_all('<meta property="og:image" content="(.*?)" />', $curl_content, $match)) {
            $data["thumbnail"] = $match[1][0];
        }
        if (preg_match_all('<meta property="og:video:duration" content="(.*?)" />', $curl_content, $match)) {
            $data["duration"] = gmdate(($match[1][0] > 3600 ? "H:i:s" : "i:s"), $match[1][0]);
        }
        if (preg_match_all('<meta property="og:url" content="(.*?)" />', $curl_content, $match)) {
            $post_url = $match[1][0];
            $curl_content_2 = url_get_contents($post_url);
        } else {
            $curl_content_2 = $curl_content;
        }
        if (preg_match_all('/"url(.*?)":"(.*?)",/', $curl_content_2, $match)) {
            $links = $match;
        }
        $i = 0;
        if (!empty($links[2])) {
            foreach ($links[2] as $link) {
                $data["links"][$i]["url"] = $this->convert_url($link);
                $data["links"][$i]["type"] = "mp4";
                $data["links"][$i]["quality"] = $links[1][$i] . "P";
                $data["links"][$i]["size"] = get_file_size($data["links"][$i]["url"]);
                $i++;
            }
            $data["source"] = "vkontakte";
            return $data;
        }

    }

    function convert_url($url)
    {
        $url = str_replace("\\", "", $url);
        $url = str_replace("&amp", "&", $url);
        $url = str_replace("&;", "&", $url);
        return $url;
    }

    function generate_random_string($length = 4)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function check_redirect($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $out = curl_exec($ch);
        $out = str_replace("\r", "", $out);
        $headers_end = strpos($out, "\n\n");
        if ($headers_end !== false) {
            $out = substr($out, 0, $headers_end);
        }
        $headers = explode("\n", $out);
        foreach ($headers as $header) {
            if (substr($header, 0, 10) == "Location: ") {
                $target = substr($header, 10);
                return $target;
            }
        }
        return false;
    }
}