<?php
if ($_SERVER["REQUEST_METHOD"] = "POST") {
    if (isset($_POST["id_check"])) {
        $username = $_POST["username"];
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            echo "사용가능한 ID입니다.";
        } else {
            echo "중복된 ID입니다.";
        }
    } else if (isset($_POST["is_register"])) {
        $username = $_POST["username"];
        $name = $_POST["name"];
        $password = $_POST["password"];

        $sql = "INSERT INTO users (username, name, password, mb_level) VALUE (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $name, $password, "일반회원"]);

        echo "회원가입이 완료되었습니다.";
    }
}
