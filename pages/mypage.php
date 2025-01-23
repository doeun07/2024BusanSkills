<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MYPAGE</title>
    <link rel="stylesheet" href="../선수제공파일/bootstrap-5.2.0-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="container">
        <div class="mypage">
            <h2>예약 현황 확인</h2>
            <?php
            if (isset($_SESSION["user_idx"]) && $_SESSION["mb_level"] == "일반회원") {
                $user_idx = $_SESSION["user_idx"];
                $sql = "SELECT * FROM reservations WHERE user_idx = :user_idx";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":user_idx", $user_idx);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (isset($data)) {
            ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">날짜</th>
                                <th scope="col">리그</th>
                                <th scope="col">시간</th>
                                <th scope="col">인원</th>
                                <th scope="col">가격</th>
                                <th scope="col">예약승인상태</th>
                                <th scope="col">결제승인상태</th>
                                <th scope="col">결제요청버튼</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data as $value) {
                                $resTableHtml = "";
                                $resTableHtml .= "<tr>";
                                $resTableHtml .= "<td>" . $value["res_date"] . "</td>";
                                $resTableHtml .= "<td>" . $value["league"] . " 리그</td>";
                                $resTableHtml .= "<td>" . $value["res_time"] . "시</td>";
                                $resTableHtml .= "<td>" . $value["min_human"] . "명</td>";
                                $resTableHtml .= "<td>" . number_format($value["price"]) . "원</td>";
                                $resTableHtml .= "<td>" . $value["res_status"] . "</td>";
                                $resTableHtml .= "<td>" . $value["pay_status"] . "</td>";
                                if ($value["res_status"] == "승인완료" && $value["pay_status"] == "결제전") {
                                    $resTableHtml .= "<td><button class='btn btn-primary'>결제요청</button></td>";
                                } else {
                                    $resTableHtml .= "<td><button class='btn btn-primary' disabled>결제요청</button></td>";
                                }
                                $resTableHtml .= "</tr>";

                                echo $resTableHtml;
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
                } else {
                ?>
                    <h3>예약 내역이 없습니다.</h3>
                <?php
                }
                ?>
        </div>
    <?php
            }
    ?>
    <!-- <script>
            alert("로그인 후 이용가능한 페이지입니다!");
            location.href = "login";
        </script> -->

    </div>

    <script src="../선수제공파일/jquery-3.7.1.min.js"></script>
    <script src="../선수제공파일/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="../선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="../script.js"></script>
</body>

</html>