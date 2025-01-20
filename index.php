<?php
session_start();
include("./config/DBconnect.php");
$request = $_SERVER['REQUEST_URI'];
$path = explode("?", $request);
$path[1] = isset($path[1]) ? $path[1] : null;
$resource = explode("/", $path[0]);

$page = "";
switch ($resource[1]) {
    case "":
        $page = "./pages/index.php";
        break;
    case "information":
        $page = "./pages/sub01.php";
        break;
    case "statistics":
        $page = "./pages/sub02.php";
        break;
    case "reservation":
        $page = "./pages/sub03.php";
        break;
    case "goods":
        $page = "./pages/sub04.php";
        break;
    default:
        echo "잘못된 접근입니다.";
        return 0;
}

include $page;
