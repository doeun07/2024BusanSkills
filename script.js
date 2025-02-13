// 방문자 정보 가져오기
async function visitorsData() {
  const response = await fetch("./선수제공파일/B_Module/visitors.json");
  const data = await response.json();
  return data;
}

// 굿즈 정보 가져오기
async function goodsData() {
  const response = await fetch("./선수제공파일/B_Module/goods.json");
  const data = await response.json();
  return data;
}

// 사용자 선택에 따른 데이터 가져오기
async function chartView() {
  let data = await visitorsData();
  const league = document.querySelector("#league").value;
  const week = document.querySelector("#week").value;

  data = data.data[league].visitors[week].visitor;

  return data;
}

// 가로 차트 띄우기
let maxCount = 0;
async function widthChart() {
  const chartElem = document.querySelector("#chartDiv");
  chartElem.innerHTML = "";
  chartElem.className = "chart_width";

  const data = await chartView();

  // 변환된 데이터 형식 [[오전 10시,  200], [오후 2시, 170], [오후 4시, 180]]
  Object.entries(data).forEach(([time, count]) => {
    if (count >= 500) {
      maxCount = 500;
    } else {
      maxCount = count;
    }
    chartElem.innerHTML += `
    <div class="width_parents">
    <p>${time}</p>
    <div class="width" style="width: ${maxCount}px;">${count}명</div>
    </div>`;
  });
}

// 세로 차트 띄우기
async function heightChart() {
  const chartElem = document.querySelector("#chartDiv");
  chartElem.innerHTML = "";
  chartElem.className = "chart_height";

  const data = await chartView();

  // Object.entries은 배열로 변환
  // forEach는 배열의 모든 요소를 순차적으로 실행함
  Object.entries(data).forEach(([time, count]) => {
    if (count >= 500) {
      maxCount = 500;
    } else {
      maxCount = count;
    }
    chartElem.innerHTML += `
      <div class="height_parents">
        <div class="height" style="height: ${maxCount}px;">${count}명</div>
        <p>${time}</p>
      </div>`;
  });
}

// group 종류 추가
async function goodsGroupAdd() {
  const data = await goodsData();

  // 데이터에서 group 배열로 추출
  const goodsGroupList = [...new Set(data.data.map((item) => item.group))];

  // goodsGroupList 추가
  const goodsGroupElem = document.querySelector("#goodsGroup");
  goodsGroupElem.innerHTML = "";
  goodsGroupList.forEach((group) => {
    goodsGroupElem.innerHTML += `
      <div>
        <input id="${group}" value="${group}" type="checkbox" onchange="goodsListSort()" checked>
        <p>${group}</p>
      </div>`;
  });
}

// goodsList 추가 및 정렬
async function goodsListSort() {
  const data = await goodsData();
  const goodsListElem = document.querySelector("#goodsList");
  const bestGoodsListElem = document.querySelector("#bestGoods");
  const sortValue = document.querySelector("#sort").value;
  let goodsSortList = [];

  // group별 checkbox 값 가져오기
  const checkboxes = document.querySelectorAll(
    "#goodsGroup input[type='checkbox']"
  );

  // 체크된 그룹 값 추출 후 배열 변환
  const checkedGroups = Array.from(checkboxes)
    // 체크된 체크 박스만 필터링
    .filter((checkbox) => checkbox.checked)
    // 필터링 된 체크박스에서 값만 추출
    .map((checkbox) => checkbox.value);

  const filteredGoods = data.data.filter((item) =>
    checkedGroups.includes(item.group)
  );

  // 기준에 맞춰서 정렬
  if (sortValue == "saleDesc") {
    goodsSortList = [...filteredGoods].sort((a, b) => b.sale - a.sale);
  } else if (sortValue == "saleAsc") {
    goodsSortList = [...filteredGoods].sort((a, b) => a.sale - b.sale);
  } else if (sortValue == "priceDesc") {
    // 문자열 가격 숫자로 변환 후 계산
    goodsSortList = [...filteredGoods].sort(
      (a, b) =>
        Number(b.price.replace(",", "")) - Number(a.price.replace(",", ""))
    );
  } else if (sortValue == "priceAsc") {
    goodsSortList = [...filteredGoods].sort(
      (a, b) =>
        Number(a.price.replace(",", "")) - Number(b.price.replace(",", ""))
    );
  }

  bestGoodsListElem.innerHTML = ""; // 기존 리스트 초기화
  goodsListElem.innerHTML = ""; // 기존 리스트 초기화

  goodsSortList.forEach((item, index) => {
    if (index < 3) {
      bestGoodsListElem.innerHTML += `
          <div class="card" style="width: 18rem;">
          <img src="./선수제공파일/B_Module//${item.img}" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">[BEST 상품] ${item.title}</h5>
            <p class="card-text">판매량 : ${item.sale}개</p>
            <p class="card-text">가격 : ${item.price}원</p>
            <p class="card-text">분류 : ${item.group}</p>
            <button onclick="goodsEditModalShow(${item.idx})" class="btn btn-primary w-75">수정제안</button>
          </div>
        </div>
      `;
    } else {
      goodsListElem.innerHTML += `
        <div class="card" style="width: 18rem;">
          <img src="./선수제공파일/B_Module//${item.img}" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">${item.title}</h5>
            <p class="card-text">판매량 : ${item.sale}개</p>
            <p class="card-text">가격 : ${item.price}원</p>
            <p class="card-text">분류 : ${item.group}</p>
            <button onclick="goodsEditModalShow(${item.idx})" class="btn btn-primary w-75">수정제안</button>
          </div>
        </div>
      `;
    }
  });
}

let editImgStatus = false;

// 수정제안 modal 띄우기
async function goodsEditModalShow(idx) {
  const data = await goodsData();
  const goods = data.data.find((a) => a.idx === idx);
  const goodsEditElem = document.querySelector("#goodsEditImg");
  if (editImgStatus == false) {
    goodsEditElem.innerHTML = `<h4>이미지를 추가해주세요 :)</h4>`;
  }
  const modalTitleElem = document.querySelector("#goodsModalTitle");
  modalTitleElem.innerHTML = `<h5 class="modal-title">${goods.title} 수정제안</h5>`;
  $("#goodsModal").modal("show");
}

// 이미지 입력 받기
function addImg() {
  editImgStatus = true;
  $("#imgInput").click();
}

// 수정제안 영역에 입력 받은 이미지 추가
function addEditImg() {
  // 입력 받은 이미지 중 첫번째 이미지 정보 들고오기
  const img = document.querySelector("#imgInput").files[0];

  const goodsEditElem = document.querySelector("#goodsEditImg");
  goodsEditElem.innerHTML = "";
  // createObjectURL : 임시 url 생성
  const imgUrl = URL.createObjectURL(img);

  goodsEditElem.style.backgroundImage = `url(${imgUrl})`;
}

let isMoveAndRotateEnabled = false; // 이동 및 회전 기능 활성화 상태
let selectedTextBox = null; // 선택된 글상자 전역 변수

// 글상자 추가 함수
let moveDistance = 10; // 글상자 이동 거리

// 글상자 추가 함수
function addTextBox() {
  if (editImgStatus === false) {
    alert("이미지 추가 후 글상자 추가 가능합니다.");
  } else {
    const goodsEditElem = document.querySelector("#goodsEditImg");

    // 글상자 생성
    const textBox = document.createElement("div");
    textBox.classList.add("textbox");
    textBox.contentEditable = true;
    textBox.textContent = "텍스트";

    // 글상자 클릭 시 선택 처리
    textBox.addEventListener("click", function () {
      // 이전에 선택된 글상자가 있으면 스타일 변경
      if (selectedTextBox) {
        selectedTextBox.style.border = ""; // 선택 해제 시 스타일 초기화
      }

      selectedTextBox = textBox; // 현재 선택된 글상자 저장
      textBox.style.border = "2px solid #000"; // 선택된 글상자 스타일 적용
    });

    // 글상자 추가
    goodsEditElem.appendChild(textBox);

    // 이동 및 회전 활성화 상태일 경우, 드래그 기능 활성화
    if (isMoveAndRotateEnabled) {
      $(textBox).draggable({
        containment: "#goodsEditImg", // 드래그 제한 범위 설정
        disabled: false, // 이동 기능 활성화
      });
    } else {
      $(textBox).draggable({
        containment: "#goodsEditImg", // 드래그 제한 범위 설정
        disabled: true, // 처음에는 이동 비활성화
      });
    }

    // 이동 시 비활성화 상태에서 경고창 띄우기
    textBox.addEventListener("mousedown", function () {
      if (!isMoveAndRotateEnabled) {
        alert("이동 및 회전 버튼을 클릭하여 이동과 회전을 활성화 시켜주세요.");
      }
    });

    // 키보드 방향키로 이동 기능 추가
    document.addEventListener("keydown", function (e) {
      // 선택된 글상자가 없거나, 이동 기능이 비활성화 되어 있으면 동작하지 않음
      if (!selectedTextBox || !isMoveAndRotateEnabled) return;

      let currentTop =
        parseInt(window.getComputedStyle(selectedTextBox).top) || 0;
      let currentLeft =
        parseInt(window.getComputedStyle(selectedTextBox).left) || 0;

      // 방향키에 따라 이동
      if (e.key === "ArrowUp") {
        selectedTextBox.style.top = `${currentTop - moveDistance}px`;
      } else if (e.key === "ArrowDown") {
        selectedTextBox.style.top = `${currentTop + moveDistance}px`;
      } else if (e.key === "ArrowLeft") {
        selectedTextBox.style.left = `${currentLeft - moveDistance}px`;
      } else if (e.key === "ArrowRight") {
        selectedTextBox.style.left = `${currentLeft + moveDistance}px`;
      }
    });
  }
}

// 회전 기능을 document에 바인딩하여 `Ctrl + 오른쪽 화살표`로 회전
document.addEventListener("keydown", function (e) {
  // 선택된 글상자가 없거나, 이동 및 회전 기능이 비활성화 되어 있으면 동작하지 않음
  if (!selectedTextBox || !isMoveAndRotateEnabled) return;

  if (e.ctrlKey && e.keyCode === 39) {
    // Ctrl + 오른쪽 화살표
    let currentRotation = $(selectedTextBox).data("rotation") || 0;
    let newRotation = currentRotation + 90;
    $(selectedTextBox)
      .css({
        transform: `rotate(${newRotation}deg)`,
      })
      .data("rotation", newRotation);
  }
});

// 이동 및 회전 활성화/비활성화 함수
function toggleMoveAndRotate() {
  // 이동 및 회전 기능 활성화/비활성화 상태를 전환
  isMoveAndRotateEnabled = !isMoveAndRotateEnabled;

  // 모든 글상자에 대해 드래그 활성화/비활성화
  const textBoxes = document.querySelectorAll(".textbox");
  textBoxes.forEach(function (textBox) {
    $(textBox).draggable("option", "disabled", !isMoveAndRotateEnabled); // 드래그 활성화/비활성화
  });

  // 회전 기능 활성화/비활성화
  if (isMoveAndRotateEnabled) {
    alert("이동 및 회전 기능이 활성화되었습니다.");
  } else {
    alert("이동 및 회전 기능이 비활성화되었습니다.");
  }
}

// 이미지 안에 있는 요소 제거 (원래대로)
function deleteTextBox() {
  const textBoxs = Array.from(document.querySelectorAll("#goodsEditImg *")); // goodsEditImg 내부 요소 선택
  const editImg = document.querySelector("#goodsEditImg");

  if (editImgStatus === false) {
    alert("이미지를 추가해주세요!");
  } else if (textBoxs.length === 0) {
    alert("글상자 요소가 없습니다!");
  } else {
    editImg.innerHTML = ""; // 모든 내부 요소 제거
  }
}

// 입력받은 이미지 삭제
function deleteImg() {
  const editImgElem = document.querySelector("#goodsEditImg");
  editImgElem.style.backgroundImage = "";

  editImgElem.innerHTML = "<h4>이미지를 추가해주세요 :)</h4>";
  editImgStatus = false;
}

function textboxMoveAndRotation() {
  if (textboxMoveStatus == false) {
    alert("글상자 이동 및 회전이 활성화되었습니다!");
    textboxMoveStatus = true;
  } else {
    alert("글상자 이동 및 회전이 비활성화되었습니다!");
    textboxMoveStatus = false;
  }
}

// 이미지 다운로드
function imgDownload() {
  const goodsEditElem = document.querySelector("#goodsEditImg");

  // 이미지가 추가되지 않았다면 경고창을 표시하고 종료
  if (!editImgStatus) {
    alert("이미지를 추가해주세요!");
    return;
  }

  // 캔버스 요소 생성
  const canvas = document.createElement("canvas");
  const context = canvas.getContext("2d");

  // goodsEditImg 요소의 크기를 가져와 캔버스 크기 설정
  const rect = goodsEditElem.getBoundingClientRect();
  canvas.width = rect.width;
  canvas.height = rect.height;

  // 배경 이미지 그리기
  const backgroundImage = new Image();
  const bgStyle = window.getComputedStyle(goodsEditElem).backgroundImage;
  const bgUrl = bgStyle.slice(5, -2); // 'url("...")' 형식에서 URL만 추출

  backgroundImage.src = bgUrl;
  backgroundImage.onload = () => {
    // 배경 이미지를 캔버스에 그리기
    context.drawImage(backgroundImage, 0, 0, canvas.width, canvas.height);

    // 모든 글상자 그리기
    const textboxes = goodsEditElem.querySelectorAll(".textbox");
    textboxes.forEach((textbox) => {
      const textboxRect = textbox.getBoundingClientRect();
      const x = textboxRect.left - rect.left; // 요소의 X 위치 계산
      const y = textboxRect.top - rect.top; // 요소의 Y 위치 계산

      // 글상자의 스타일 가져오기
      const textStyle = window.getComputedStyle(textbox);
      context.font = `${textStyle.fontSize} ${textStyle.fontFamily}`;
      context.fillStyle = textStyle.color;

      // 텍스트를 캔버스에 그리기
      context.fillText(
        textbox.textContent,
        x,
        y + parseFloat(textStyle.fontSize)
      );
    });

    // 캔버스를 이미지로 변환
    const imgDataUrl = canvas.toDataURL("image/png");

    // 입력받은 이미지 파일의 이름과 확장자 가져오기
    const imgInput = document.querySelector("#imgInput").files[0];
    const originalFileName = imgInput.name; // 파일 이름과 확장자 포함

    // 다운로드 링크 생성 및 파일 다운로드
    const downloadLink = document.createElement("a");
    downloadLink.href = imgDataUrl;
    downloadLink.download = originalFileName; // 원본 파일 이름 사용
    downloadLink.click();
  };

  // 배경 이미지 로드에 실패했을 때 에러 메시지 표시
  backgroundImage.onerror = () => {
    alert("배경 이미지를 로드할 수 없습니다.");
  };
}

const usernameInput = document.querySelector("#username");
let is_idCheck = false;
// 아이디 중복확인
function idCheck() {
  const username = document.querySelector("#username").value;

  if (!username) {
    alert("아이디를 입력해주세요!");
  } else {
    $.post("./api/register", {
      username: username,
      id_check: true,
    }).done(function (data) {
      if (data == "사용가능한 ID입니다.") {
        alert(data);
        usernameInput.readOnly = true;
        is_idCheck = true;
      } else {
        alert(data);
      }
    });
  }
}

// 한글만 입력
function nameCheck(name) {
  const regExp = /[ㄱ-ㅎㅏ-ㅣ가-힣]/g;
  if (regExp.test(name)) {
    return true;
  } else {
    return false;
  }
}

// 영어, 숫자만 입력
function usernameCheck(username) {
  const regExp = /^[a-zA-Z0-9]+$/;
  if (regExp.test(username)) {
    return true;
  } else {
    return false;
  }
}

// 회원가입
function register() {
  const username = document.querySelector("#username").value;
  const name = document.querySelector("#name").value;
  const password = document.querySelector("#password").value;

  if (!username) {
    alert("아이디를 입력해주세요!");
  } else if (!name) {
    alert("이름을 입력해주세요!");
  } else if (!password) {
    alert("비밀번호를 입력해주세요!");
  } else if (!is_idCheck) {
    alert("아이디 중복 확인을 해주세요!");
  } else if (!usernameCheck(username)) {
    alert("아이디는 영어와 숫자만 입력 가능합니다!");
    usernameInput.readOnly = false;
    is_idCheck = false;
  } else if (!nameCheck(name)) {
    alert("이름은 한글만 입력 가능합니다!");
  } else {
    $.post("./api/register", {
      username: username,
      name: name,
      password: password,
      is_register: true,
    }).done(function (data) {
      if (data == "회원가입이 완료되었습니다.") {
        alert(data);
        location.href = "login";
      } else {
        console.log(data);
      }
    });
  }
}

// 로그인
function login() {
  const username = document.querySelector("#username").value;
  const password = document.querySelector("#password").value;
  const mb_level = document.querySelector("#mb_level").value;

  if (!username) {
    alert("아이디를 입력해주세요!");
  } else if (!password) {
    alert("비밀번호를 입력해주세요!");
  } else if (!mb_level) {
    alert("회원등급을 선택해주세요!");
  } else {
    $.post("./api/login", {
      username: username,
      password: password,
      mb_level: mb_level,
    }).done((data) => {
      if (data == "아이디 또는 비밀번호를 확인해주세요.") {
        alert(data);
      } else {
        const login_data = JSON.parse(data);
        if (login_data.message === "로그인이 완료되었습니다.") {
          alert(`최신 로그인 일자 : ${login_data.login_date}`);
          location.href = "/";
        } else {
          console.log(login_data);
        }
      }
    });
  }
}

// reservation 페이지 -> 일반회원
// 리그에 따른 시간 옵션 추가
let leaguePrice = 0;
let totalPrice = 0;
function addLeagueTime() {
  const league = document.querySelector("#league").value;
  const timeElem = document.querySelector("#time");
  timeElem.innerHTML = "";
  if (league == "나이트") {
    timeElem.append(new Option("19시", "19"));
    timeElem.append(new Option("23시", "23"));
    leaguePrice = 50000;
  } else if (league == "주말") {
    timeElem.append(new Option("9시", "09"));
    timeElem.append(new Option("13시", "13"));
    timeElem.append(new Option("15시", "15"));
    leaguePrice = 100000;
  } else if (league == "새벽") {
    timeElem.append(new Option("4시", "04"));
    timeElem.append(new Option("7시", "07"));
    leaguePrice = 30000;
  }

  totalPriceCal();
}

// 최종금액 계산
function totalPriceCal() {
  const min_human = document.querySelector("#min_human").value;
  const totalPriceElem = document.querySelector("#total_price");
  totalPrice = leaguePrice;
  if (min_human < 20) {
    alert("최소인원은 20명 이상입니다.");
  } else if (min_human > 20) {
    totalPrice += (min_human - 20) * 1000;
  }

  totalPriceElem.innerText = `최종금액 : ${totalPrice.toLocaleString()}원`;
}

function reservation() {
  const res_date = document.querySelector("#res_date").value;
  const league = document.querySelector("#league").value;
  const time = document.querySelector("#time").value;
  const min_human = document.querySelector("#min_human").value;
  // 사용자가 선택한 날짜가 무슨 요일인지 변환
  const holiday = new Date(res_date).getDay();

  if (!res_date) {
    alert("예약할 날짜를 선택해주세요!");
  } else if (!league) {
    alert("예약할 리그를 선택해주세요!");
  } else if (!time) {
    alert("예약할 시간을 선택해주세요!");
  } else if (!min_human) {
    alert("예약할 인원을 입력해주세요!");
  } else if (min_human < 20) {
    alert("최소인원은 20명 이상입니다.");
  } else if (holiday == 1 && time == 4) {
    alert("해당 날짜는 휴일로 지정되었습니다.");
  } else {
    $.post("./api/reservation", {
      reservation: true,
      res_date: res_date,
      league: league,
      res_time: time,
      min_human: min_human,
      price: totalPrice,
    }).done((data) => {
      if (data == "예약이 완료되었습니다.") {
        alert(data);
        location.href = "mypage";
      } else if (data == "해당 날짜는 휴일로 지정되었습니다.") {
        alert(data);
      } else {
        console.log(data);
      }
    });
  }
}

// 담당자 예약 승인
function reservationApp(res_idx) {
  $.post("./api/reservation", {
    res_app: true,
    res_idx: res_idx,
  }).done((data) => {
    if (data == "예약 승인이 완료되었습니다.") {
      alert(data);
      location.href = "reservation";
    } else {
      console.log(data);
    }
  });
}

// 담당자 예약 삭제
function deleteReservation(res_idx) {
  $.post("./api/reservation", {
    res_del: true,
    res_idx: res_idx,
  }).done((data) => {
    if (data == "예약이 삭제 되었습니다.") {
      alert(data);
      location.href = "reservation";
    } else {
      console.log(data);
    }
  });
}

// 담당자 예약 전체 삭제
function deleteReservationAll() {
  const checkbox = document.querySelectorAll(".res_checkBox:checked");

  let res_status = 0;
  let res_idxArr = [];
  checkbox.forEach((elem) => {
    res_status =
      elem.parentElement.parentElement.querySelector(
        "td:nth-child(9)"
      ).innerText;
    if (res_status == "승인불가") {
      res_idxArr.push(elem.value);
    }
  });
  $.post("./api/reservation", {
    res_delAll: true,
    res_idxArr: res_idxArr,
  }).done((data) => {
    if (data == "예약이 전체 삭제 되었습니다.") {
      alert(data);
      location.href = "reservation";
    } else {
      console.log(data);
    }
  });
}

// 관리자 예약 결제 승인
function reservationPayApp(res_idx) {
  $.post("./api/reservation", {
    resPay_app: true,
    res_idx: res_idx,
  }).done((data) => {
    if (data == "결제가 완료되었습니다.") {
      alert(data);
      location.href = "reservation";
    } else {
      console.log(data);
    }
  });
}

function holidaySelectWay() {
  const holidayElem = document.querySelector("#holiday_select");
  const holiday_type = document.querySelector("#holiday_type").value;

  if (!holiday_type) {
    alert("휴일 지정 방법을 선택해주세요.");
  } else if (holiday_type == "date") {
    holidayElem.innerHTML = `
          <div>
            <span>예약 날짜 : </span>
            <input id="date" type="date">
          </div>
          <button class="btn btn-danger" onclick="resDateHoliday()">휴일 지정</button>
          `;
  } else {
    holidayElem.innerHTML = `
          <div>
              <span>예약 날짜 : </span>
              <input id="date" type="date">
          </div>
          <div>
              <span>리그 :</span>
              <select name="" onchange="holidayTimeAdd()" id="league">
                  <option value="나이트">나이트 리그</option>
                  <option value="주말">주말 리그</option>
                  <option value="새벽">새벽 리그</option>
              </select>
          </div>
          <div>
              <span>시간 :</span>
              <select name="" id="time"></select>
          </div>
          <button class="btn btn-danger" onclick="resLeagueHoliday()">휴일 지정</button>
          `;
    holidayTimeAdd();
  }
}

function holidayTimeAdd() {
  const league = document.querySelector("#league").value;
  const timeElem = document.querySelector("#time");
  timeElem.innerHTML = "";
  if (league == "나이트") {
    timeElem.append(new Option("19시", "19"));
    timeElem.append(new Option("23시", "23"));
    leaguePrice = 50000;
  } else if (league == "주말") {
    timeElem.append(new Option("9시", "09"));
    timeElem.append(new Option("13시", "13"));
    timeElem.append(new Option("15시", "15"));
    leaguePrice = 100000;
  } else if (league == "새벽") {
    timeElem.append(new Option("4시", "04"));
    timeElem.append(new Option("7시", "07"));
    leaguePrice = 30000;
  }
}

// 날짜로 휴일 지정
function resDateHoliday() {
  const date = document.querySelector("#date").value;
  const nightLeague = ["19", "23"];
  const weekLeague = ["09", "13", "15"];
  const dawnLeague = ["04", "07"];

  if (!date) {
    alert("날짜를 입력해주세요!");
  } else {
    nightLeague.forEach((item) => {
      $.post("./api/reservation", {
        holiday: true,
        date: date,
        league: "나이트",
        time: item,
      }).done((data) => {
        if (data != "휴일 지정이 완료되었습니다.") {
          console.log(data);
        }
      });
    });
    weekLeague.forEach((item) => {
      $.post("./api/reservation", {
        holiday: true,
        date: date,
        league: "주말",
        time: item,
      }).done((data) => {
        if (data != "휴일 지정이 완료되었습니다.") {
          console.log(data);
        }
      });
    });
    dawnLeague.forEach((item) => {
      $.post("./api/reservation", {
        holiday: true,
        date: date,
        league: "새벽",
        time: item,
      }).done((data) => {
        if (data != "휴일 지정이 완료되었습니다.") {
          console.log(data);
        }
      });
    });
    alert("휴일 지정이 완료되었습니다.");
    location.href = "reservation";
  }
}

// 리그로 휴일 지정
function resLeagueHoliday() {
  const date = document.querySelector("#date").value;
  const league = document.querySelector("#league").value;
  const time = document.querySelector("#time").value;

  if (!date) {
    alert("날짜를 입력 해주세요!");
  } else if (!league) {
    alert("리그를 선택해주세요!");
  } else if (!time) {
    alert("시간을 선택해주세요!");
  } else {
    $.post("./api/reservation", {
      holiday: true,
      date: date,
      league: league,
      time: time,
    }).done((data) => {
      if (data == "휴일 지정이 완료되었습니다.") {
        alert(data);
      } else {
        console.log(data);
      }
    });
  }
}

function payRequest(res_idx) {
  $.post("./api/mypage", {
    payRequest: true,
    res_idx: res_idx,
  }).done((data) => {
    if (data == "결제요청이 완료되었습니다.") {
      alert(data);
      location.href = "./mypage";
    } else {
      console.log(data);
    }
  });
}
