<?php
include(__DIR__ . "/functions.php");
ob_start("sanitize_output");
session_start();
switch (true) {
    default:
        include(__DIR__ . "/includes/login.php");
        break;
    case(isset($_SESSION["logged"]) === true):
        include(__DIR__ . "/includes/dashboard.php");
        break;
}