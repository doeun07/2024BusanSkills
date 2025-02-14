<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOODS</title>
    <link rel="stylesheet" href="../선수제공파일/bootstrap-5.2.0-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="container text-center">
        <h1>GOODS LIST</h1>
        <table class="goods_table table table-striped text-center">
            <thead>

                <tr>
                    <th scope="col">연번</th>
                    <th scope="col">이미지</th>
                    <th scope="col">굿즈명</th>
                    <th scope="col">상세내용보기</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!isset($_SESSION["mb_level"]) || $_SESSION["mb_level"] == "일반회원") {
                    $sql = "SELECT * FROM goods";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $goods = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($goods as $data) {
                        $goodsHtml = "";
                        $goodsHtml .= "<tr>";
                        $goodsHtml .= "<td>" . $data["goods_idx"] . "</td>";
                        if ($data["goods_idx"] < 10) {
                            $goodsHtml .= "<td><img class='goods_img' src='../선수제공파일/B_Module/goods/0" . $data["goods_idx"] . ".jpg' alt=''></td>";
                        } else {
                            $goodsHtml .= "<td><img class='goods_img' src='../선수제공파일/B_Module/goods/" . $data["goods_idx"] . ".jpg' alt=''></td>";
                        }
                        $goodsHtml .= "<td>" . $data["name"] . "</td>";
                        $goodsHtml .= "<td><a href='goodsDetail?goods_idx=" . $data["goods_idx"] . "' class='btn btn-dark'>상세페이지</a></td>";
                        $goodsHtml .= "</tr>";

                        echo $goodsHtml;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="../선수제공파일/jquery-3.7.1.min.js"></script>
    <script src="../선수제공파일/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="../선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="../script.js"></script>
</body>

</html>