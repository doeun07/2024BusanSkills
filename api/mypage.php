<?php
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["payRequest"])) {
    $res_idx = $_POST["res_idx"];
    $sql = "UPDATE reservations SET pay_status = '결제요청' WHERE res_idx = :res_idx";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam("res_idx", $res_idx);
    $stmt->execute();

    echo "결제요청이 완료되었습니다.";
} else {
    echo "잘못된 요청입니다.";
}