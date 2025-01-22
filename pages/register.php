<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER</title>
    <link rel="stylesheet" href="../선수제공파일/bootstrap-5.2.0-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../style.css">
</head>

<body>

    <div class="container">
        <div class="login">
            <div>
                <input type="text" id="username" placeholder="아이디를 입력하세요.">
                <button onclick="idCheck()" class="btn btn-dark">ID 중복 확인</button>
                <input type="text" id="name" placeholder="이름을 입력하세요.">
                <input type="password" id="password" placeholder="비밀번호를 입력하세요.">
                <button onclick="register()" class="btn btn-dark m-2">회원가입</button>
            </div>
        </div>
    </div>

    <script src="../선수제공파일/jquery-3.7.1.min.js"></script>
    <script src="../선수제공파일/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="../선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="../script.js"></script>
</body>

</html>