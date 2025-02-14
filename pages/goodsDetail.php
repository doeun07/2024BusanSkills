<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOODS 상세페이지</title>
    <link rel="stylesheet" href="../선수제공파일/bootstrap-5.2.0-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="mt-2 mb-2 container text-center d-flex align-items-center">
        <?php
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
            $goodsHtml .= "<button disabled class='m-1 btn btn-danger'>관심굿즈등록</button>";
            $goodsHtml .= "<button disabled class='m-1 btn btn-success'>장바구니 담기</button>";
            $goodsHtml .= "<button disabled class='m-1 btn btn-primary'>구매하기</button>";
        } else {
            $goodsHtml .= "<button class='m-1 btn btn-danger' onclick='addGoodGoods(" . $goods["goods_idx"] . ")'>관심굿즈등록</button>";
            $goodsHtml .= "<button class='m-1 btn btn-success' onclick='addShopping(" . $goods["goods_idx"] . ")'>장바구니 담기</button>";
            $goodsHtml .= "<button class='m-1 btn btn-primary'>구매하기</button>";
        }
        $goodsHtml .= "</div>";
        $goodsHtml .= "</div>";
        $goodsHtml .= "";

        echo $goodsHtml;
        ?>
    </div>

    <script src="../선수제공파일/jquery-3.7.1.min.js"></script>
    <script src="../선수제공파일/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="../선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="../script.js"></script>
</body>

</html>