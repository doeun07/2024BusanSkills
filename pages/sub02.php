<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STATISTICS</title>
    <link rel="stylesheet" href="./선수제공파일/bootstrap-5.2.0-dist/css/bootstrap.css">
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <!-- 헤더 시작 -->
    <header>
        <a href="./index.html"><img class="logo" src="./logo.png" alt=""></a>
        <ul>
            <li><a href="./sub01.html">INFORMATION</a></li>
            <li><a class="now" href="./sub02.html">STATISTICS</a></li>
            <li><a href="./sub03.html">RESERVATION</a></li>
            <li><a href="./sub04.html">GOODS</a></li>
        </ul>

        <ul>
            <li><a href="#">로그인</a></li>
            <li><a href="#">회원가입</a></li>
        </ul>
    </header>
    <!-- 헤더 끝 -->

    <div class="container chart_main">
        <!-- 방문자 차트 영역 시작 -->
        <h1>방문자 수 조회</h1>
        <div class="chart_menu">
            <select name="league" id="league">
                <option value="0">나이트 리그</option>
                <option value="1">주말 리그</option>
                <option value="2">새벽 리그</option>
            </select>

            <select name="week" id="week">
                <option value="0">월요일</option>
                <option value="1">화요일</option>
                <option value="2">수요일</option>
                <option value="3">목요일</option>
                <option value="4">금요일</option>
                <option value="5">토요일</option>
                <option value="6">일요일</option>
            </select>

            <button onclick="widthChart()">가로로 보기</button>
            <button onclick="heightChart()">세로로 보기</button>
        </div>

        <div id="chartDiv" class="chart_height"></div>
        <!-- 방문자 차트 영역 끝 -->

        <!-- GOODS 판매 영역 시작 -->
        <div class="main">
            <h1>GOODS 판매량 확인</h1>
            <div class="goodsSale_menu">
                <div id="goodsGroup"></div>
                <select id="sort" onchange="goodsListSort()">
                    <option value="saleDesc">판매량 내림차순</option>
                    <option value="saleAsc">판매량 오름차순</option>
                    <option value="priceDesc">가격 내림차순</option>
                    <option value="priceAsc">가격 오름차순</option>
                </select>
            </div>
            <div id="bestGoods"></div>
            <div id="goodsList"></div>
        </div>
        <!-- GOODS 판매 영역 끝 -->
    </div>

    <!-- 푸터 시작 -->
    <footer>
        <img class="logo" src="./logo.png" alt="">
        <div>
            <p>Copyrightⓒ Skills baseball park. All rights reserved.</p>
            <p>Call: 142-3677</p>
            <p>Email: help@skillsbaseballpark.com</p>
            <p>Address: (12345) 서울특별서 중구 중북로 71</p>
        </div>
    </footer>
    <!-- 푸터 끝 -->

    <!-- 수정제안 모달 시작 -->
    <div id="goodsModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div id="goodsModalTitle"></div>
                    <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
                        <span inert>&times;</span>
                      </button>
                </div>
                <div id="goodsEdit" class="modal-body">
                    <div id="goodsEditImg"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="addImg()" class="btn btn-primary">이미지 추가</button>
                    <input type="file" id="imgInput" onchange="addEditImg()">
                    <button type="button" onclick="addTextBox()" class="btn btn-warning">글상자 추가</button>
                    <button type="button" onclick="deleteImg()" class="btn btn-danger">삭제</button>
                    <a type="button" onclick="imgDownload()" class="btn btn-success">다운로드</a>
                    <button type="button" onclick="toggleMoveAndRotate()" class="btn btn-info">글상자 이동 및 회전</button>
                    <button type="button" onclick="deleteTextBox()" class="btn btn-secondary">원래대로</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 수정제안 모달 끝 -->

    <script src="./선수제공파일/jquery-3.7.1.min.js"></script>
    <script src="./선수제공파일/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="./선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="./script.js"></script>
    <script>
        widthChart()
        goodsGroupAdd()
        goodsListSort()
    </script>
</body>

</html>