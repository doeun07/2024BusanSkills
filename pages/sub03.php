<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESERVATION</title>
    <link rel="stylesheet" href="../선수제공파일/bootstrap-5.2.0-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="container">
        <?php
        if (isset($_SESSION["user_idx"]) && $_SESSION["mb_level"] == "일반회원") {
        ?>
            <div class="reservation_main">
                <h2>예약하기</h2>
                <div class="reservation">
                    <div>
                        <span>예약 날짜 : </span>
                        <input onchange="addLeagueTime();" id="res_date" type="date">
                    </div>
                    <div>
                        <span>리그 선택 : </span>
                        <select onchange="addLeagueTime()" name="" id="league">
                            <option value="나이트">나이트</option>
                            <option value="주말">주말</option>
                            <option value="새벽">새벽</option>
                        </select>
                    </div>
                    <div>
                        <span>시간 : </span>
                        <select name="" id="time"></select>
                    </div>
                    <div>
                        <span>최소인원 : </span>
                        <input onchange="totalPriceCal()" id="min_human" type="number" min="20" value="20">
                    </div>
                    <button onclick="reservation()" class="btn btn-dark">예약하기</button>
                    <h5 id="total_price">최종금액 : 0원</h5>
                </div>
            </div>

        <?php
        } else if (isset($_SESSION["user_idx"]) && $_SESSION["mb_level"] == "담당자") {
            $sql = "SELECT * FROM reservations
                        INNER JOIN users 
                        ON reservations.user_idx = users.user_idx
                        -- 승인불가는 안 가져옴 -> 삭제된 아이들이기 때문에
                        WHERE res_status = '승인대기' || res_status = '승인완료'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
            <div class="reservation_menu">
                <h2>예약 승인 페이지</h2>
                <button onclick="deleteReservationAll()" class="btn btn-danger">전체 삭제</button>
            </div>
            <table class="res_table table table-striped">
                <thead>
                    <tr>
                        <th scope="col">체크박스</th>
                        <th scope="col">예약자 ID</th>
                        <th scope="col">예약자 이름</th>
                        <th scope="col">리그</th>
                        <th scope="col">날짜</th>
                        <th scope="col">시간</th>
                        <th scope="col">인원</th>
                        <th scope="col">사용료</th>
                        <th scope="col">예약가능여부</th>
                        <th scope="col">예약승인버튼</th>
                        <th scope="col">예약삭제버튼</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($reservations as $reservation) {
                        $sql = "SELECT * FROM reservations
                            WHERE res_date = :res_date
                            AND res_time = :res_time
                            AND league = :league
                            AND res_status = '승인완료'";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(":res_date", $reservation["res_date"]);
                        $stmt->bindParam(":res_time", $reservation["res_time"]);
                        $stmt->bindParam(":league", $reservation["league"]);
                        $stmt->execute();
                        $yaeyakStatus = $stmt->fetch(PDO::FETCH_ASSOC);

                        $reservationHtml = "";

                        $reservationHtml .= "<tr>";
                        $reservationHtml .= "<td><input class='res_checkbox' value='" . $reservation["res_idx"] . "' type='checkbox'></td>";
                        $reservationHtml .= "<td>" . $reservation["username"] . "</td>";
                        $reservationHtml .= "<td>" . $reservation["name"] . "</td>";
                        $reservationHtml .= "<td>" . $reservation["league"] . "리그</td>";
                        $reservationHtml .= "<td>" . $reservation["res_date"] . "</td>";
                        $reservationHtml .= "<td>" . $reservation["res_time"] . "시</td>";
                        $reservationHtml .= "<td>" . $reservation["min_human"] . "명</td>";
                        $reservationHtml .= "<td>" . number_format($reservation["price"]) . "원</td>";

                        if (isset($yaeyakStatus["res_status"])) {
                            if ($yaeyakStatus["res_idx"] == $reservation["res_idx"] && $reservation["res_status"] == "승인완료") {
                                $reservationHtml .= "<td value='" . $reservation["res_idx"] . "'>예약완료</td>";
                                $reservationHtml .= "<td><button class='btn btn-primary' onclick='reservationApp(" . $reservation["res_idx"] . ")' disabled>예약승인</button></td>";
                                $reservationHtml .= "<td><button class='btn btn-danger' onclick='deleteReservation(" . $reservation["res_idx"] . ")' disabled>삭제</button></td>";
                            } else {
                                $reservationHtml .= "<td value='" . $reservation["res_idx"] . "'>승인불가</td>";
                                $reservationHtml .= "<td><button class='btn btn-primary' onclick='reservationApp(" . $reservation["res_idx"] . ")' disabled>예약승인</button></td>";
                                $reservationHtml .= "<td><button class='btn btn-danger' onclick='deleteReservation(" . $reservation["res_idx"] . ")'>삭제</button></td>";
                            }
                        } else if (!isset($yaeyakStatus["res_status"]) && $reservation["res_status"] == "승인대기") {
                            $reservationHtml .= "<td value='" . $reservation["res_idx"] . "'>예약가능</td>";
                            $reservationHtml .= "<td><button class='btn btn-primary' onclick='reservationApp(" . $reservation["res_idx"] . ")'>예약승인</button></td>";
                            $reservationHtml .= "<td><button class='btn btn-danger' onclick='deleteReservation(" . $reservation["res_idx"] . ")' disabled>삭제</button></td>";
                        }
                        $reservationHtml .= "</tr>";

                        echo $reservationHtml;
                    }
                    ?>
                </tbody>
            </table>
        <?php
        } else if (isset($_SESSION["user_idx"]) && $_SESSION["mb_level"] == "관리자") {
            $yesterDay = date("Y-m-d", strtotime("-1 days"));
            $sql = "SELECT * FROM reservations
                        INNER JOIN users 
                        ON reservations.user_idx = users.user_idx
                        WHERE res_status = '승인완료'
                        AND res_date > :yesterDay";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":yesterDay", $yesterDay);
            $stmt->execute();
            $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ?>
            <div class="holiday_admin res_admin">
                <h2>휴일 지정</h2>
                <div class="holiday_menu">
                    <div>
                        <span>휴일 지정 방법 선택 : </span>
                        <select onchange="holidaySelectWay()" name="" id="holiday_type">
                            <option value="date">날짜로 휴일 지정</option>
                            <option value="league">리그로 휴일 지정</option>
                        </select>
                    </div>
                    <div id="holiday_select"></div>
                </div>
            </div>
            <div class="res_admin">
                <h2>결제 승인</h2>
            </div>
            <table class="res_table table table-striped">
                <thead>
                    <tr>
                        <th scope="col">예약자 ID</th>
                        <th scope="col">예약자 이름</th>
                        <th scope="col">리그</th>
                        <th scope="col">날짜</th>
                        <th scope="col">시간</th>
                        <th scope="col">인원</th>
                        <th scope="col">금액</th>
                        <th scope="col">결제상태</th>
                        <th scope="col">결제승인버튼</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($reservations as $reservation) {
                        $reservationHtml = "";
                        $reservationHtml .= "<tr>";
                        $reservationHtml .= "<td>" . $reservation["username"] . "</td>";
                        $reservationHtml .= "<td>" . $reservation["name"] . "</td>";
                        $reservationHtml .= "<td>" . $reservation["league"] . "</td>";
                        $reservationHtml .= "<td>" . $reservation["res_date"] . "</td>";
                        $reservationHtml .= "<td>" . $reservation["res_time"] . "</td>";
                        $reservationHtml .= "<td>" . $reservation["min_human"] . "</td>";
                        $reservationHtml .= "<td>" . number_format($reservation["price"]) . "원</td>";
                        $reservationHtml .= "<td>" . $reservation["pay_status"] . "</td>";
                        if ($reservation["pay_status"] == "결제요청") {
                            $reservationHtml .= "<td><button class='btn btn-primary' onclick='reservationPayApp(" . $reservation["res_idx"] . ")'>결제 승인</button></td>";
                        } else {
                            $reservationHtml .= "<td><button class='btn btn-primary' disabled>결제 승인</button></td>";
                        }
                        $reservationHtml .= "</tr>";

                        echo $reservationHtml;
                    }

                    ?>
                </tbody>
            </table>

        <?php
        }
        ?>
    </div>

    <script src="../선수제공파일/jquery-3.7.1.min.js"></script>
    <script src="../선수제공파일/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="../선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="../script.js"></script>
    <script>
        holidaySelectWay();
    </script>
</body>

</html>