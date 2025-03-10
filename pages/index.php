<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKILLS BASEBALL PARK</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="container">
        <!-- 비주얼 영역 시작 -->
        <div class="slide"></div>
        <!-- 비주얼 영역 끝 -->

        <!-- information 영역 시작 -->
        <div class="main">
            <h1>INFORMATION</h1>
            <div class="information">
                <div>
                    <p>Skills baseball park는 시민들의 복리증진을 위하여 설치되었으며, 시민들의 건강 및 복지향상과 시민들에게 편리한 시설물 이용을 위한 야구장입니다.</p>
                    <p>야구를 사랑하며 즐기는 생활체육인들이 모이는 곳</p>
                    <p>다양한 즐거움과 감동을 선사하는 곳</p>
                    <p>Skills baseball park</p>
                    <a href="./sub01.html">더 많은 정보 보러가기</a>
                </div>
            </div>
        </div>
        <!-- information 영역 끝 -->

        <!-- game schedule 영역 시작 -->
        <div class="main">
            <h1>GAME SCHEDULE</h1>
            <div class="today_games">
                <h2>금일 게임 현황</h2>
                <div class="today_game">
                    <div class="team">
                        <img class="teamLogo" src="./img/Team_Design_logo.png" alt="">
                        <h3>DESIGN</h3>
                    </div>
                    <div>
                        <h1>4 : <span>5</span></h1>
                    </div>
                    <div class="team">
                        <img class="teamLogo" src="./img/Team_Web_logo.png" alt="">
                        <h3>WEB</h3>
                    </div>
                </div>
            </div>

            <h2>2024년 4월</h2>
            <table class="calender">
                <tr>
                    <th>일</th>
                    <th>월</th>
                    <th>화</th>
                    <th>수</th>
                    <th>목</th>
                    <th>금</th>
                    <th>토</th>
                </tr>
                <tr>
                    <td></td>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>8</td>
                    <td>9</td>
                    <td>10</td>
                    <td>11</td>
                    <td>12</td>
                    <td>13</td>
                </tr>
                <tr>
                    <td>14</td>
                    <td>15</td>
                    <td>16</td>
                    <td>17</td>
                    <td>18</td>
                    <td>19</td>
                    <td><label for="calenderModal">20</label></td>
                </tr>
                <tr>
                    <td>21</td>
                    <td>22</td>
                    <td>23</td>
                    <td>24</td>
                    <td>25</td>
                    <td>26</td>
                    <td>27</td>
                </tr>
                <tr>
                    <td>28</td>
                    <td>29</td>
                    <td>30</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
        <!-- game schedule 영역 끝 -->

        <!-- ranking 영역 시작 -->
        <div class="main">
            <h1>RANKING</h1>
            <div class="ranking_menu">
                <ul>
                    <li>나이트 리그
                        <ul>
                            <li><label for="나이트투수label">투수</label></li>
                            <li><label for="나이트타자label">타자</label></li>
                        </ul>
                    </li>
                    <li>주말 리그
                        <ul>
                            <li><label for="주말투수label">투수</label></li>
                            <li><label for="주말타자label">타자</label></li>
                        </ul>
                    </li>
                    <li>새벽 리그
                        <ul>
                            <li><label for="새벽투수label">투수</label></li>
                            <li><label for="새벽타자label">타자</label></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <input id="나이트투수label" type="radio" name="tota">
            <input id="나이트타자label" type="radio" name="tota">
            <input id="주말투수label" type="radio" name="tota">
            <input id="주말타자label" type="radio" name="tota">
            <input id="새벽투수label" type="radio" name="tota">
            <input id="새벽타자label" type="radio" name="tota">

            <div class="tota" id="나이트투수">
                <h3>나이트 리그 투수 순위</h3>
                <p>1. 나일투</p>
                <p>2. 나이투</p>
                <p>3. 나삼투</p>
                <p>4. 나사투</p>
                <p>5. 나오투</p>
                <p>6. 나육투</p>
                <p>7. 나칠투</p>
            </div>
            <div class="tota" id="나이트타자">
                <h3>나이트 리그 타자 순위</h3>
                <p>1. 나일타</p>
                <p>2. 나이타</p>
                <p>3. 나삼타</p>
                <p>4. 나사타</p>
                <p>5. 나오타</p>
                <p>6. 나육타</p>
                <p>7. 나칠타</p>
            </div>

            <div class="tota" id="주말투수">
                <h3>주말 리그 투수 순위</h3>
                <p>1. 주일투</p>
                <p>2. 주이투</p>
                <p>3. 주삼투</p>
                <p>4. 주사투</p>
                <p>5. 주오투</p>
                <p>6. 주육투</p>
                <p>7. 주칠투</p>
            </div>
            <div class="tota" id="주말타자">
                <h3>주말 리그 타자 순위</h3>
                <p>1. 주일타</p>
                <p>2. 주이타</p>
                <p>3. 주삼타</p>
                <p>4. 주사타</p>
                <p>5. 주오타</p>
                <p>6. 주육타</p>
                <p>7. 주칠타</p>
            </div>

            <div class="tota" id="새벽투수">
                <h3>새벽 리그 투수 순위</h3>
                <p>1. 새일투</p>
                <p>2. 새이투</p>
                <p>3. 새삼투</p>
                <p>4. 새사투</p>
                <p>5. 새오투</p>
                <p>6. 새육투</p>
                <p>7. 새칠투</p>
            </div>
            <div class="tota" id="새벽타자">
                <h3>새벽 리그 타자 순위</h3>
                <p>1. 새일타</p>
                <p>2. 새이타</p>
                <p>3. 새삼타</p>
                <p>4. 새사타</p>
                <p>5. 새오타</p>
                <p>6. 새육타</p>
                <p>7. 새칠타</p>
            </div>

            <ul class="accordion">
                <li>
                    <input id="타율label" type="radio" name="top5">
                    <label for="타율label">타율</label>
                    <ul>
                        <li>TOP 1. 일타율</li>
                        <li>TOP 2. 이타율</li>
                        <li>TOP 3. 삼타율</li>
                        <li>TOP 4. 사타율</li>
                        <li>TOP 5. 오타율</li>
                    </ul>
                </li>
                <li>
                    <input id="홈런label" type="radio" name="top5">
                    <label for="홈런label">홈런</label>
                    <ul>
                        <li>TOP 1. 일홈런</li>
                        <li>TOP 2. 이홈런</li>
                        <li>TOP 3. 삼홈런</li>
                        <li>TOP 4. 사홈런</li>
                        <li>TOP 5. 오홈런</li>
                    </ul>
                </li>
                <li>
                    <input id="다승label" type="radio" name="top5">
                    <label for="다승label">다승</label>
                    <ul>
                        <li>TOP 1. 일다승</li>
                        <li>TOP 2. 이다승</li>
                        <li>TOP 3. 삼다승</li>
                        <li>TOP 4. 사다승</li>
                        <li>TOP 5. 오다승</li>
                    </ul>
                </li>
                <li>
                    <input id="평균자책label" type="radio" name="top5">
                    <label for="평균자책label">평균자책</label>
                    <ul>
                        <li>TOP 1. 일평자</li>
                        <li>TOP 2. 이평자</li>
                        <li>TOP 3. 삼평자</li>
                        <li>TOP 4. 사평자</li>
                        <li>TOP 5. 오평자</li>
                    </ul>
                </li>
                <li>
                    <input id="탈삼진label" type="radio" name="top5">
                    <label for="탈삼진label">탈삼진</label>
                    <ul>
                        <li>TOP 1. 일삼진</li>
                        <li>TOP 2. 이삼진</li>
                        <li>TOP 3. 삼삼진</li>
                        <li>TOP 4. 사삼진</li>
                        <li>TOP 5. 오삼진</li>
                    </ul>
                </li>
                <li>
                    <input id="세이브label" type="radio" name="top5">
                    <label for="세이브label">세이브</label>
                    <ul>
                        <li>TOP 1. 일세이</li>
                        <li>TOP 2. 이세이</li>
                        <li>TOP 3. 삼세이</li>
                        <li>TOP 4. 사세이</li>
                        <li>TOP 5. 오세이</li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- ranking 영역 끝 -->

        <!-- goods 영역 시작 -->
        <div class="main">
            <h1>GOODS</h1>
            <div class="goods">
                <img id="goods_item" src="./img/goods1.jpg" alt="">
                <img src="./img/goods2.jpg" alt="">
                <img src="./img/goods3.jpg" alt="">
                <img src="./img/goods4.jpg" alt="">
            </div>
        </div>
        <!-- goods 영역 끝 -->
    </div>

    <input id="calenderModal" type="checkbox">
    <!-- 모달 영역 시작 -->
    <div id="modal" class="modal">
        <div class="modal_content">
            <div class="modal_header">
                <h2>2024년 4월 20일</h2>
            </div>
            <div class="modal_body">
                <img src="./img/modal_baseball_img.png" alt="">
                <h3>아직 게임이 없습니다.</h3>
            </div>
            <div class="modal_footer">
                <label for="calenderModal">닫기</label>
            </div>
        </div>
    </div>
    <!-- 모달 영역 끝 -->
</body>

</html>