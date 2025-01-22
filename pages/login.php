<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STATISTICS</title>
    <link rel="stylesheet" href="../선수제공파일/bootstrap-5.2.0-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../style.css">
</head>

<body>

    <div class="container">
        <div class="login">
            <div>
                <input type="text" id="username" placeholder="아이디를 입력하세요.">
                <input type="password" id="password" placeholder="비밀번호를 입력하세요.">
                <select name="" id="mb_level">
                    <option value="일반회원">일반회원</option>
                    <option value="담당자">담당자</option>
                    <option value="관리자">관리자</option>
                </select>
                <button onclick="login()" class="btn btn-dark m-2">로그인</button>
            </div>
        </div>
    </div>

    <script src="../선수제공파일/jquery-3.7.1.min.js"></script>
    <script src="../선수제공파일/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="../선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="../script.js"></script>
</body>

</html>