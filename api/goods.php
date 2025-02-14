<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["goodGoods"])) {
    $goods_idx = $_POST["goods_idx"];
    $user_idx = $_SESSION["user_idx"];
    $sql = "SELECT * FROM good WHERE goods_idx = :goods_idx AND user_idx = :user_idx";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":goods_idx", $goods_idx);
    $stmt->bindParam(":user_idx", $user_idx);
    $stmt->execute();
    $goodGoods = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$goodGoods) {
        $sql = "INSERT INTO good (goods_idx, user_idx) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $goods_idx);
        $stmt->bindParam(2,     $user_idx);
        $stmt->execute();

        echo "관심 굿즈 등록이 완료되었습니다.";
    } else {
        echo "이미 등록된 굿즈입니다!";
    }
}
