<?php
function config($type, $echo = false)
{
    $json_file = json_decode(file_get_contents(__DIR__ . "/storage/config.json"), true);
    if ($echo === true) {
        echo $json_file[$type];
    } else {
        return $json_file[$type];
    }
}

function api_key($type, $echo = false)
{
    $json_file = json_decode(file_get_contents(__DIR__ . "/storage/api.json"), true);
    if ($echo === true) {
        echo $json_file[$type];
    } else {
        return $json_file[$type];
    }
}

function template_config($type, $echo = false)
{
    $template_config = json_decode(file_get_contents(__DIR__ . "/storage/template.json"), true);
    if ($echo === true) {
        if (isset($template_config[$type])) {
            echo $template_config[$type];
        } else {
            return "";
        }
    } else {
        if (isset($template_config[$type])) {
            return $template_config[$type];
        } else {
            return "";
        }
    }
}

function update_config()
{
    $config_file = file_get_contents(__DIR__ . "/../system/storage/config.json");
    $config_data = json_decode($config_file, true);
    $config_data['fingerprint'] = $_POST["new_fingerprint"];
    if (isset($_POST['update_checksum']) == "true") {
        $config_data["checksum"] = sha1_file(__DIR__ . "/action.php");
    }
    if (isset($_POST['update_checksum']) != "") {
        $config_data['version'] = $_POST["new_version"];
    }
    file_put_contents(__DIR__ . "/../system/storage/config.json", json_encode($config_data));
    echo "true";
    die();
}

function menu_data()
{
    $template_config = json_decode(file_get_contents(__DIR__ . "/storage/template.json"), true);
    return $template_config["menu"];
}


function language_exists($language)
{
    if (file_exists(__DIR__ . "/../language/" . $language . ".php")) {
        return true;
    } else {
        return false;
    }
}

function get_ad($size)
{
    $code = file_get_contents(__DIR__ . "/storage/advertising-" . $size . ".tpl");
    echo $code;
}

function return_json($array)
{
    if (empty($array["links"]["0"]["url"])) {
        echo "error";
        die();
    } else {
        header('Content-Type: application/json');
        echo json_encode($array);
        die();
    }
}

function check_url($url)
{
    if (empty($url)) {
        echo "error";
        die();
    }
}

function redirect($url)
{
    header('Location: ' . $url);
}

function format_seconds($seconds)
{
    return gmdate(($seconds > 3600 ? "H:i:s" : "i:s"), $seconds);
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

function generate_string($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function create_fingerprint($string1, $string2)
{
    $fingerprint = sha1($string1 . $string2);
    return $fingerprint;
}

function format_size($bytes)
{
    switch ($bytes) {
        case $bytes < 1024:
            $size = $bytes . " B";
            break;
        case $bytes < 1048576:
            $size = round($bytes / 1024, 2) . " KB";
            break;
        case $bytes < 1073741824:
            $size = round($bytes / 1048576, 2) . " MB";
            break;
        case $bytes < 1099511627776:
            $size = round($bytes / 1073741824, 2) . " GB";
            break;
    }
    if (!empty($size)) {
        return $size;
    } else {
        return "";
    }
}

function integrity_check()
{
    $file = __DIR__ . "/action.php";
    $sha1 = sha1_file($file);
    if (hash_equals($sha1, url_get_contents("https://drive.google.com/uc?export=download&id=1wxkGsnTLVT0TkWPIunJJq_icSibF2fiI"))) {
        return true;
    } else {
        return false;
    }
}

function url_get_contents($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.10240');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function unshorten($url, $max_redirs = 3)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, $max_redirs);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Niche Office Link Checker 1.0');
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_exec($ch);
    $url=curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close ($ch);
    return $url;
}

function get_file_size($url, $format = true)
{
    $result = -1;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_NOBODY, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.10240');
    $data = curl_exec($curl);
    curl_close($curl);
    if ($data) {
        $content_length = "unknown";
        $status = "unknown";
        if (preg_match("/^HTTP\/1\.[01] (\d\d\d)/", $data, $matches)) {
            $status = (int)$matches[1];
        }
        if (preg_match("/Content-Length: (\d+)/", $data, $matches)) {
            $content_length = (int)$matches[1];
        }
        if ($status == 200 || ($status > 300 && $status <= 308)) {
            $result = $content_length;
        }
    }
    if ($result != -1) {
        if ($format === true) {
            return format_size($result);
        } else {
            return $result;
        }
    } else {
        return "?";
    }
}

function sanitize($string, $forceLowercase = false, $anal = false)
{
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
    $clean = ($forceLowercase) ?
        (function_exists('mb_strtolower')) ?
            mb_strtolower($clean, 'UTF-8') :
            strtolower($clean) :
        $clean;
    $specialChars = "\x00\x21\x22\x24\x25\x2a\x2f\x3a\x3c\x3e\x3f\x5c\x7c";
    $clean = str_replace(str_split($specialChars), '_', $clean);
    $clean = substr($clean, 0, 40);
    $clean = mb_convert_encoding($clean, 'UTF-8', 'UTF-8');
    return $clean;
}

function clear_string($data)
{
    $data = stripslashes(trim($data));
    $data = strip_tags($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

function xss_clean($data)
{
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

function force_download($url, $title, $type)
{
    $context_options = array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
        ),
    );
    $file_name = clear_string(xss_clean($title));
    $file_name = html_entity_decode($file_name, ENT_QUOTES, "UTF-8");
    if (empty($file_name)) {
        $file_name = generate_string();
    }
    $file_name = $file_name . "." . $type;
    header('Content-Disposition: attachment; filename="' . $file_name . '"');
    header("Content-Transfer-Encoding: binary");
    header('Expires: 0');
    header('Pragma: no-cache');
    $file_size = get_file_size($url, false);
    if ($file_size > 0) {
        header('Content-Length: ' . $file_size);
    }
    if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
    }
    ob_clean();
    ob_end_flush();
    readfile($url, "", stream_context_create($context_options));
    exit;
}

function generate_csrf_token()
{
    if (defined('PHP_MAJOR_VERSION') && PHP_MAJOR_VERSION > 5) {
        return bin2hex(random_bytes(32));
    } else {
        if (function_exists('mcrypt_create_iv')) {
            return bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        } else {
            return bin2hex(openssl_random_pseudo_bytes(32));
        }
    }
}