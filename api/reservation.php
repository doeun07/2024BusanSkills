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
    }
}
