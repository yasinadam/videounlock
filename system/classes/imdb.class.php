<?php

class imdb
{
    function orderArray($arrayToOrder, $keys)
    {
        $ordered = array();
        foreach ($keys as $key) {
            if (isset($arrayToOrder[$key])) {
                $ordered[$key] = $arrayToOrder[$key];
            }
        }
        return $ordered;
    }

    function media_info($url)
    {
        $web_page = url_get_contents($url);
        if (preg_match_all('@href="/video/imdb/(.*?)"@si', $web_page, $match)) {
            $player_url = "https://imdb.com/videoplayer/" . $match[1][0];
            $player_page = url_get_contents($player_url);
            $data = array();
            preg_match_all('@window.IMDbReactInitialState.push((.*?));@si', $player_page, $player_json);
            $player_json = json_decode(substr($player_json[1][0], 1, -1), true);
            $video_data = array_values($player_json["videos"]["videoMetadata"])[0];
            $data["title"] = $video_data["title"];
            $data["duration"] = $video_data["duration"];
            $data["thumbnail"] = $video_data["slate"]["url"];
            if (!empty($video_data["encodings"])) {
                $i = 0;
                foreach ($video_data["encodings"] as $video) {
                    if ($video["mimeType"] == "video/mp4") {
                        $data["links"][$i]["url"] = $video["videoUrl"];
                        $data["links"][$i]["type"] = "mp4";
                        $data["links"][$i]["size"] = get_file_size($data["links"][$i]["url"]);
                        $data["links"][$i]["quality"] = $video["definition"];
                        $data["links"][$i]["mute"] = "no";
                        $i++;
                    }
                }
            }
            $data["source"] = "imdb";
            return $data;
        }
    }
}