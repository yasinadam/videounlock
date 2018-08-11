<?php
include(__DIR__ . "/functions.php");
session_start();
if (isset($_POST["email"]) != "" && isset($_POST["password"]) != "") {
    if ($_POST["email"] == config("email") && check_password($_POST["password"]) === true) {
        $_SESSION["logged"] = true;
        redirect(config("url") . "/admin");
    }else{
        redirect(config("url") . "/admin/?failed-login=1");
    }
} else {
    redirect(config("url") . "/admin/?failed-login=1");
}