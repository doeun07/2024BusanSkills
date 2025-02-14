<?php
if (!isset($_SESSION["mb_level"])) {
    echo "로그인 후 이용가능한 기능입니다.";
} else {
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
    } else if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["shopping"])) {
        $goods_idx = $_POST["goods_idx"];
        $user_idx = $_SESSION["user_idx"];
        $count = $_POST["count"];

        $sql = "INSERT INTO shopping (goods_idx, user_idx, count) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $goods_idx);
        $stmt->bindParam(2,     $user_idx);
        $stmt->bindParam(3,     $count);
        $stmt->execute();

        echo "장바구니에 상품이 등록되었습니다.";
    }
}
