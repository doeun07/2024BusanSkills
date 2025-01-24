<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["reservation"])) {
        $res_date = $_POST["res_date"];
        $league = $_POST["league"];
        $res_time = $_POST["res_time"];

        $holiday = null;

        $sql = "SELECT * FROM holiday WHERE league = :league AND date = :date AND time = :time";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam("league", $league);
        $stmt->bindParam("date", $res_date);
        $stmt->bindParam("time", $res_time);
        $stmt->execute();
        $holiday = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($holiday == false) {
            $user_idx = $_SESSION["user_idx"];
            $min_human = $_POST["min_human"];
            $price = $_POST["price"];

            $sql = "INSERT INTO reservations (user_idx, league, res_date, res_time, min_human, price) VALUE (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_idx, $league, $res_date, $res_time, $min_human, $price]);

            echo "예약이 완료되었습니다.";
        } else {
            echo "해당 날짜&시간은 휴일입니다!";
        }
    } else if (isset($_POST["res_app"])) {
        $res_idx = $_POST["res_idx"];
        $sql = "UPDATE reservations SET res_status = '승인완료' WHERE res_idx = :res_idx";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":res_idx", $res_idx);
        $stmt->execute();

        echo "예약 승인이 완료되었습니다.";
    } else if (isset($_POST["res_del"])) {
        $res_idx = $_POST["res_idx"];
        $sql = "UPDATE reservations SET res_status = '승인불가' WHERE res_idx = :res_idx";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":res_idx", $res_idx);
        $stmt->execute();

        echo "예약이 삭제 되었습니다.";
    } else if (isset($_POST["res_delAll"])) {
        $res_idxArr = $_POST["res_idxArr"];
        foreach ($res_idxArr as $res_idx) {
            $sql = "UPDATE reservations SET res_status = '승인불가' WHERE res_idx = :res_idx";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":res_idx", $res_idx);
            $stmt->execute();
        }
        echo "예약이 전체 삭제 되었습니다.";
    } else if (isset($_POST["resPay_app"])) {
        $res_idx = $_POST["res_idx"];
        $sql = "UPDATE reservations SET pay_status = '결제완료' WHERE res_idx = :res_idx";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":res_idx", $res_idx);
        $stmt->execute();

        echo "결제가 완료되었습니다.";
    } else if (isset($_POST["holiday"])) {
        $date = $_POST["date"];
        $league = $_POST["league"];
        $time = $_POST["time"];

        $sql = "INSERT INTO holiday (date, league, time) VALUE (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$date, $league, $time]);

        echo "휴일 지정이 완료되었습니다.";
    }
}
