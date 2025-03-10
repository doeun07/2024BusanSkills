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
            <h2>예약 정보 확인</h2>
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
                                <th scope="col">승인상태</th>
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
                                if ($value["res_status"] == "승인대기") {
                                    $resTableHtml .= "<td>예약 신청</td>";
                                } else if ($value["pay_status"] == "결제전" && $value["res_status"] == "승인완료") {
                                    $resTableHtml .= "<td><button onclick='payRequest(" . $value["res_idx"] . ")' class='btn btn-primary'>결제요청</button></td>";
                                } else if ($value["pay_status"] == "결제요청") {
                                    $resTableHtml .= "<td>결제 승인 전</td>";
                                } else {
                                    $resTableHtml .= "<td>" . $value["pay_status"] . "</td>";
                                }
                                $resTableHtml .= "</tr>";

                                echo $resTableHtml;
                            }
                            ?>
                        </tbody>
                    </table>
                    <h2 class="mt-2">관심 굿즈 LIST</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">굿즈 아이디</th>
                                <th scope="col">사진</th>
                                <th scope="col">굿즈명</th>
                                <th scope="col">가격</th>
                                <th scope="col">장바구니</th>
                                <th scope="col">구매하기</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM good AS d 
                            JOIN goods AS s ON d.goods_idx = s.goods_idx
                            WHERE d.user_idx = :user_idx";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(":user_idx", $user_idx);
                            $stmt->execute();
                            $goods = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($goods as $data) {
                                $goodHtml = "";
                                $goodHtml .= "<tr>";
                                $goodHtml .= "<td>" . $data["goods_idx"] . "</td>";
                                $goodHtml .= "<td><img class='goods_img' src='../선수제공파일/B_Module/goods/0" . $data["goods_idx"] . ".jpg' alt=''>";
                                $goodHtml .= "<td><a href='goodsDetail?goods_idx=" . $data["goods_idx"] . "'>" . $data["name"] . "</a></td>";
                                $goodHtml .= "<td>" . number_format($data["price"]) . "원</td>";
                                $goodHtml .= "<td><a href='goodsDetail?goods_idx=" . $data["goods_idx"] . "' class='btn btn-success'>장바구니</a></td>";
                                $goodHtml .= "<td><a href='buy?goods_idx=" . $data["goods_idx"] . "' class='btn btn-primary'>구매하기</a></td>";
                                $goodHtml .= "</tr>";

                                echo $goodHtml;
                            }
                            ?>
                        </tbody>
                    </table>

                    <h2 class="mt-2">장바구니 LIST</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">굿즈명</th>
                                <th scope="col">가격</th>
                                <th scope="col">갯수</th>
                                <th scope="col">총 가격</th>
                                <th scope="col">구매하기</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $user_idx = $_SESSION["user_idx"];
                            $sql = "SELECT * FROM shopping AS s 
                            JOIN goods AS d ON d.goods_idx = s.goods_idx
                            LEFT JOIN buy AS b ON b.shopping_idx = s.shopping_idx
                            WHERE s.user_idx = :user_idx";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(":user_idx", $user_idx);
                            $stmt->execute();
                            $goods = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($goods as $data) {
                                $goodHtml = "";
                                $goodHtml .= "<tr>";
                                $goodHtml .= "<td>" . $data["name"] . " </td>";
                                $goodHtml .= "<td>" . number_format($data["price"]) . "원</td>";
                                $goodHtml .= "<td>" . $data["count"] . "개</td>";
                                $goodHtml .= "<td>" . number_format($data["price"] * $data["count"]) . "원</td>";
                                if (isset($data["buy_idx"])) {
                                    $goodHtml .= "<td><button disabled onclick='buyPage(" . $data["shopping_idx"] . ")' class='btn btn-primary'>구매하기</button></td>";
                                } else {
                                    $goodHtml .= "<td><button onclick='buyPage(" . $data["shopping_idx"] . ")' class='btn btn-primary'>구매하기</button></td>";
                                }
                                $goodHtml .= "</tr>";

                                echo $goodHtml;
                            }
                            ?>
                        </tbody>
                    </table>

                    <h2 class="mt-2">구매 LIST</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">굿즈명</th>
                                <th scope="col">가격</th>
                                <th scope="col">갯수</th>
                                <th scope="col">총 가격</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $user_idx = $_SESSION["user_idx"];
                            $sql = "SELECT * FROM shopping AS s 
                            JOIN goods AS d ON d.goods_idx = s.goods_idx
                            JOIN buy AS b ON b.shopping_idx = s.shopping_idx
                            WHERE s.user_idx = :user_idx
                            ORDER BY b.total_price DESC";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(":user_idx", $user_idx);
                            $stmt->execute();
                            $goods = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($goods as $data) {
                                $goodHtml = "";
                                $goodHtml .= "<tr>";
                                $goodHtml .= "<td>" . $data["name"] . " </td>";
                                $goodHtml .= "<td>" . number_format($data["price"]) . "원</td>";
                                $goodHtml .= "<td>" . $data["count"] . "개</td>";
                                $goodHtml .= "<td>" . number_format($data["total_price"]) . "원</td>";
                                $goodHtml .= "</tr>";

                                echo $goodHtml;
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


    </div>

    <script src="../선수제공파일/jquery-3.7.1.min.js"></script>
    <script src="../선수제공파일/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="../선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="../script.js"></script>
</body>

</html>