<?php
function config($type, $echo = false, $file = "config.json")
{
    $json_file = json_decode(file_get_contents(__DIR__ . "/../system/storage/" . $file), true);
    if ($echo === true) {
        echo $json_file[$type];
    } else {
        return $json_file[$type];
    }
}

function theme_config($type, $echo = false, $json_decode = true)
{
    if ($json_decode === true) {
        $json_file = json_decode(file_get_contents(__DIR__ . "/../system/storage/template.json"), true);
        if ($echo === true) {
            if (isset($json_file[$type])) {
                echo $json_file[$type];
            }
        } else {
            if (isset($json_file[$type])) {
                return $json_file[$type];
            }
        }
    } else {
        $json_file = json_decode(file_get_contents(__DIR__ . "/../system/storage/template.json"), true);
        if ($echo === true) {
            echo json_encode($json_file[$type], JSON_PRETTY_PRINT);
        } else {
            return json_encode($json_file[$type], JSON_PRETTY_PRINT);
        }
    }
}

function sanitize_output($buffer)
{
    $search = array(
        '/\>[^\S ]+/s',
        '/[^\S ]+\</s',
        '/(\s)+/s',
        '/<!--(.|\s)*?-->/'
    );
    $replace = array(
        '>',
        '<',
        '\\1',
        ''
    );
    $buffer = preg_replace($search, $replace, $buffer);
    return $buffer;
}

function check_password($input)
{
    $password = file_get_contents(__DIR__ . "/../system/storage/password.htpasswd");
    if (sha1($input) == $password) {
        return true;
    } else {
        return false;
    }
}

function change_password($password)
{
    file_put_contents(__DIR__ . "/../system/storage/password.htpasswd", sha1($password));
}

function check_config($file, $type)
{
    $json_file = json_decode(file_get_contents(__DIR__ . "/../system/storage/" . $file), true);
    if (isset($json_file[$type]) == "true") {
        echo "checked";
    }
}

function redirect($url)
{
    header('Location: ' . $url);
}

function language_exists($language)
{
    if (file_exists(__DIR__ . "/../language/" . $language . ".php")) {
        return true;
    }
}

function list_languages()
{
    foreach (glob(__DIR__ . "/../language/*.php") as $filename) {
        if (basename($filename) != "index.php") {
            $language = str_replace(".php", null, basename($filename));
            if (language_exists($language) === true && config("language") == $language) {
                echo '<option selected value="' . $language . '">' . $language . '</option>';
            } elseif (language_exists($language) === true) {
                echo '<option value="' . $language . '">' . $language . '</option>';
            }
        }
    }
}

function get_ad($size)
{
    $code = file_get_contents(__DIR__ . "/../system/storage/advertising-" . $size . ".tpl");
    echo $code;
}

function save_config($post_data, $file)
{
    foreach ($post_data as $key => $data) {
        switch ($key) {
            default:
                $post_data_2 = $post_data;
                unset($post_data_2["tracking-code"]);
                file_put_contents(__DIR__ . "/../system/storage/" . $file, json_encode($post_data_2));
                break;
            case("tracking-code"):
                file_put_contents(__DIR__ . "/../system/storage/tracking.tpl", $data);
                break;
        }
    }
}

function save_menu($post_data, $file)
{
    $menu = explode("\n", $post_data);
    $json = array();
    $i = 0;
    foreach ($menu as $item) {
        $link["title"] = explode(",", $item)[0];
        $link["url"] = explode(",", $item)[1];
        array_push($json, $link);
        $i++;
    }
    file_put_contents(__DIR__ . "/../system/storage/" . $file, json_encode($json));
}

function view_menu($file)
{
    $json = json_decode(file_get_contents(__DIR__ . "/../system/storage/" . $file), true);
    foreach ($json as $item) {
        echo $item["title"] . "," . $item["url"] . "\n";
    }
}

function page_content($page)
{
    echo file_get_contents(__DIR__ . "/../system/storage/pages/" . $page . ".html");
}

function save_pages($post_data)
{
    foreach ($post_data as $page_name => $page_content) {
        if (preg_match_all("@<body>(.*?)</body>@si", $page_content, $match)) {
            file_put_contents(__DIR__ . "/../system/storage/pages/" . $page_name . ".html", $match[1]);
        }
    }
}

function get_tracking_code($echo = false)
{
    if ($echo === true) {
        echo file_get_contents(__DIR__ . "/../system/storage/tracking.tpl");
    } else {
        return file_get_contents(__DIR__ . "/../system/storage/tracking.tpl");
    }
}

function get_user_ip()
{
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];
    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }
    return $ip;
}

function url_get_contents($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Niche Office - All in One Video Downloader');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function decode_version($string)
{
    $string = urlencode(base64_encode($string));
    return url_get_contents("http://api.nicheoffice.web.tr/verify/version/" . $string);
}

function create_fingerprint($string1, $string2)
{
    $fingerprint = sha1($string1 . $string2);
    return $fingerprint;
}

function changelog()
{
    $fingerprint = create_fingerprint(rtrim(config("url"), '/\\'), config("purchase_code"));
    $fingerprint = urlencode(base64_encode($fingerprint));
    $changelog = url_get_contents("http://api.nicheoffice.web.tr/download/changelog/" . $fingerprint);
    return $changelog;
}