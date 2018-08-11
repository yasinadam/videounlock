<?php
function config_2($type, $echo = false)
{
    $json_file = json_decode(file_get_contents(__DIR__ . "/storage/config.json"), true);
    if ($echo === true) {
        echo $json_file[$type];
    } else {
        return $json_file[$type];
    }
}
session_start();
if (isset($_SESSION["current_language"]) != "") {
    require_once(__DIR__ . "/../language/" . $_SESSION["current_language"] . ".php");
} else {
    require_once(__DIR__ . "/../language/" . config_2("language") . ".php");
}
include(__DIR__ . "/functions.php");
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = generate_csrf_token();
}