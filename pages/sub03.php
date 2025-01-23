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
                        <input id="res_date" type="date">
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

        }
        ?>
    </div>

    <script src="../선수제공파일/jquery-3.7.1.min.js"></script>
    <script src="../선수제공파일/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="../선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="../script.js"></script>
    <script>
        addLeagueTime();
    </script>
</body>

</html>