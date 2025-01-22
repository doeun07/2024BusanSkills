<header>
    <a href="./"><img class="logo" src="./logo.png" alt=""></a>
    <ul>
        <li><a href="information">INFORMATION</a></li>
        <li><a href="statistics">STATISTICS</a></li>
        <li><a href="reservation">RESERVATION</a></li>
        <li><a href="goods">GOODS</a></li>
    </ul>

    <ul>
        <?php
        if (isset($_SESSION["user_idx"])) {
            echo "<li><a href='logout'>로그아웃</a></li>";
            echo "<li><a href='mypage'>마이페이지</a></li>";
        } else {
            echo "<li><a href='login'>로그인</a></li>";
            echo "<li><a href='register'>회원가입</a></li>";
        }
        ?>
    </ul>
</header>