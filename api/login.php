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
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "아이디 또는 비밀번호를 확인해주세요.";
    } else {
        $date = date("Y-m-d H:i:s");
        $sql2 = "UPDATE users SET login_date = :login_date WHERE user_idx = :user_idx";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam(":login_date", $date);
        $stmt2->bindParam(":user_idx", $user["user_idx"]);
        $stmt2->execute();

        $_SESSION["user_idx"] = $user["user_idx"];
        $_SESSION["mb_level"] = $user["mb_level"];
        $login_date = $user["login_date"];

        echo json_encode([
            "message" => "로그인이 완료되었습니다.",
            "login_date" => $login_date,
        ], JSON_UNESCAPED_UNICODE);
    }
}
