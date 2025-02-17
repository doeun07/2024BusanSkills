<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>결제하기</title>
    <link rel="stylesheet" href="../선수제공파일/bootstrap-5.2.0-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="mt-2 mb-2 container text-center d-flex align-items-center">
        <?php
        if (isset($_SESSION["mb_level"])) {
            // 장바구니에 담겨 있을 때 구매 페이지
            if (isset($_GET["shopping_idx"])) {
                $shopping_idx = $_GET["shopping_idx"];
                $sql = "SELECT * FROM shopping AS s
                JOIN goods AS d ON s.goods_idx = d.goods_idx
                WHERE shopping_idx = :shopping_idx";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":shopping_idx", $shopping_idx);
                $stmt->execute();
                $buyData = $stmt->fetch(PDO::FETCH_ASSOC);

                $buyHtml = "";
                $buyHtml .= "<div>";
                if ($buyData["goods_idx"] < 10) {
                    $buyHtml .= "<img class='goodsDetail_img' src='../선수제공파일/B_Module/goods/0" . $buyData["goods_idx"] . ".jpg' alt=''>";
                } else {
                    $buyHtml .= "<img class='goodsDetail_img' src='../선수제공파일/B_Module/goods/" . $buyData["goods_idx"] . ".jpg' alt=''>";
                }
                $buyHtml .= "</div>";
                $buyHtml .= "<div class='text-left'>";
                $buyHtml .= "<h2>" . $buyData["name"] . "</h2>";
                $buyHtml .= "<p>가격 : " . number_format($buyData["price"]) . "원</p>";
                $buyHtml .= "<p>갯수 : " . $buyData["count"] . "개</p>";
                $buyHtml .= "<p>총 가격 : " . number_format($buyData["price"] * $buyData["count"]) . "원</p>";
                $buyHtml .= "<hr>";
                $buyHtml .= "<div class='m-3'>";
                $buyHtml .= "<button onclick='ShoppingAddBuy(" . $shopping_idx . ")' class='m-1 btn btn-primary'>구매하기</button>";
                $buyHtml .= "</div>";
                $buyHtml .= "</div>";
                $buyHtml .= "";

                echo $buyHtml;
            } else if ($_GET["goods_idx"]) {
                $goods_idx = $_GET["goods_idx"];
                $sql = "SELECT * FROM goods WHERE goods_idx = :goods_idx";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam("goods_idx", $goods_idx);
                $stmt->execute();
                $goods = $stmt->fetch(PDO::FETCH_ASSOC);

                $goodsHtml = "";
                $goodsHtml .= "<div>";
                if ($goods["goods_idx"] < 10) {
                    $goodsHtml .= "<img class='goodsDetail_img' src='../선수제공파일/B_Module/goods/0" . $goods["goods_idx"] . ".jpg' alt=''>";
                } else {
                    $goodsHtml .= "<img class='goodsDetail_img' src='../선수제공파일/B_Module/goods/" . $goods["goods_idx"] . ".jpg' alt=''>";
                }
                $goodsHtml .= "</div>";
                $goodsHtml .= "<div class='text-left'>";
                $goodsHtml .= "<h2>" . $goods["name"] . "</h2>";
                $goodsHtml .= "<p>" . number_format($goods["price"]) . "원</p>";
                $goodsHtml .= "<p>" . $goods["detail"] . "</p>";
                $goodsHtml .= "<hr>";
                $goodsHtml .= "<div class='d-flex justify-content-center'>";
                $goodsHtml .= "<p class='m-2'>갯수 : </p>";
                $goodsHtml .= "<input id='count' class='goodsDetail_input' type='number' value='1' min='1'>";
                $goodsHtml .= "</div>";
                $goodsHtml .= "<div class='m-3'>";
                if (!isset($_SESSION["mb_level"])) {
                    $goodsHtml .= "<button disabled class='m-1 btn btn-primary'>구매하기</button>";
                } else {
                    $goodsHtml .= "<button onclick='addBuy(" . $goods_idx . ")' class='m-1 btn btn-primary'>구매하기</button>";
                }
                $goodsHtml .= "</div>";
                $goodsHtml .= "</div>";
                $goodsHtml .= "";

                echo $goodsHtml;
            }
        } else {
            echo "<script>
                alert('로그인 후 이용가능한 페이지입니다.');
                location.href = '/login';
            </script>";
        }
        ?>
    </div>

    <script src="../선수제공파일/jquery-3.7.1.min.js"></script>
    <script src="../선수제공파일/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="../선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="../script.js"></script>
</body>

</html>