<?php
session_start();
include("./config/DBconnect.php");
$request = $_SERVER['REQUEST_URI'];
$path = explode("?", $request);
$path[1] = isset($path[1]) ? $path[1] : null;
$resource = explode("/", $path[0]);

$page = "";
if ($resource[1] == "api") {
    switch ($resource[2]) {
        case "register":
            $page = "./api/register.php";
            break;
        case "login":
            $page = "./api/login.php";
            break;
        case "reservation":
            $page = "./api/reservation.php";
            break;
        case "mypage":
            $page = "./api/mypage.php";
            break;
        case "goods":
            $page = "./api/goods.php";
            break;
        default:
            echo "잘못된 api 접근입니다.";
            break;
    }

    include $page;
} else {
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
        case "login":
            $page = "./pages/login.php";
            break;
        case "logout":
            $page = "./pages/logout.php";
            break;
        case "register":
            $page = "./pages/register.php";
            break;
        case "mypage":
            $page = "./pages/mypage.php";
            break;
        case "goodsDetail":
            $page = "./pages/goodsDetail.php";
            break;
        case "buy":
            $page = "./pages/buy.php";
            break;
        default:
            echo "잘못된 접근입니다.";
            return 0;
    }
    include "./component/header.php";
    include $page;
    include "./component/footer.php";
}
