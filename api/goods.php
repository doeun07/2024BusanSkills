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
    } else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["shopping"])) {
        $goods_idx = $_POST["goods_idx"];
        $user_idx = $_SESSION["user_idx"];
        $count = $_POST["count"];

        $sql = "INSERT INTO shopping (goods_idx, user_idx, count) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $goods_idx);
        $stmt->bindParam(2,     $user_idx);
        $stmt->bindParam(3,     $count);
        $stmt->execute();

        $shopping_idx = $pdo->lastInsertId();

        $data = [
            'message' => '장바구니에 상품이 등록되었습니다.',
            'shopping_idx' => $shopping_idx
        ];

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    } else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["buy"])) {
        $goods_idx = $_POST["goods_idx"];
        $user_idx = $_SESSION["user_idx"];
        $count = $_POST["count"];

        $sql = "INSERT INTO shopping (goods_idx, user_idx, count) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $goods_idx);
        $stmt->bindParam(2,     $user_idx);
        $stmt->bindParam(3,     $count);
        $stmt->execute();

        $shopping_idx = $pdo->lastInsertId();

        $sql = "SELECT * FROM goods WHERE goods_idx = :goods_idx";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":goods_idx", $goods_idx);
        $stmt->execute();
        $goods = $stmt->fetch(PDO::FETCH_ASSOC);

        $total_price = $goods["price"] * $count;

        $sql = "INSERT INTO buy (shopping_idx, total_price) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$shopping_idx, $total_price]);

        echo "구매가 완료되었습니다.";
    } else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["shoppingBuy"])) {
        $shopping_idx = $_POST["shopping_idx"];

        $sql = "SELECT * FROM shopping AS s
        JOIN goods AS g ON s.goods_idx = g.goods_idx
        WHERE s.shopping_idx = :shopping_idx";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":shopping_idx", $shopping_idx, PDO::PARAM_INT);
        $stmt->execute();
        $goods = $stmt->fetch(PDO::FETCH_ASSOC);

        $total_price = $goods["price"] * $goods["count"];

        $sql = "INSERT INTO buy(shopping_idx, total_price) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$shopping_idx, $total_price]);

        echo "구매가 완료되었습니다.";
    } else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addGoods"])) {
        $title = $_POST['title'];
        $detail = $_POST['detail'];
        $price = $_POST['price'];
        $imgUrl = $_POST['img'];


        $sql = "INSERT INTO goods (name, detail, price) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $title);
        $stmt->bindParam(2, $detail);
        $stmt->bindParam(3, $price);
        $stmt->execute();

        $goods_idx = $pdo->lastInsertId();

        $imgBase64 = preg_replace('/^data:image\/\w+;base64,/', '', $imgUrl);

        $uniqueFileName = $goods_idx . '.jpg';

        $uploadDir = __DIR__ . "/../선수제공파일/B_Module/goods/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fullImgPath = $uploadDir . $uniqueFileName;

        file_put_contents($fullImgPath, base64_decode($imgBase64));

        echo "상품이 정상적으로 등록되었습니다.";
    }
}
