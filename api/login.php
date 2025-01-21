<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $mb_level = $_POST["mb_level"];

    $sql = "SELECT * FROM users WHERE username = :username AND password = :password AND mb_level = :mb_level";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $password);
    $stmt->bindParam(":mb_level", $mb_level);
    $user = $stmt->execute();

    if (!$user) {
        echo "아이디 또는 비밀번호를 확인해주세요.";
    } else {
        echo "로그인이 완료되었습니다.";
    }
}
