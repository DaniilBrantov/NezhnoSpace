const hideError = (val) => {
  document.querySelector(`input[name=${val}]`).addEventListener('focus', function (e) {
    if (document.querySelector(`input[name=${val}]`).classList.contains('error')) {
      document.querySelector(`input[name=${val}]`).classList.remove('error');
      document.querySelector(`.text-error_${val}`).style.opacity = '0';
    }
  })
  document.querySelector(`input[name=${val}]`).addEventListener('change', function (e) {
    if (document.querySelector(`input[name=${val}]`).classList.contains('error')) {
      document.querySelector(`input[name=${val}]`).classList.remove('error');
      document.querySelector(`.text-error_${val}`).style.opacity = '0';
      document.querySelector(`.text-error_${val}`).textContent = 'error';
    }
  })
};
//функция показа информации о состоянии отправляемых данных
function uploadInfoShow(opacity, color, text) {
  let infoBlockUpload = document.querySelector('#account-info-block');

  infoBlockUpload.style.opacity = opacity;
  infoBlockUpload.style.color = color;
  infoBlockUpload.textContent = text;
};

(() => {
  class AccountInfo {
    constructor(avatar, dropboxGender, arrayInput, inputPhone) {
      this.avatar = avatar;
      this.dropboxGender = dropboxGender;
      this.arrayInput = arrayInput;
      this.phone = inputPhone;
    }
    inputCustom() {
      this.arrayInput.forEach((input) => {
        function setCapitalLetter(str, elem) {
          if (str == "") return false;
          str = str[0].toUpperCase() + str.substring(1, str.length);
          elem.value = str;
        }
        if ((input.id === 'account_personal-name') || (input.id === 'account_personal-lastName')) {
          setCapitalLetter(input.value, input);

          input.addEventListener('keydown', function () {
            setCapitalLetter(input.value, input);
          })
        }

        if (input.id === 'account_personal-tel') {
          let tel = document.querySelector('#account_personal-tel');
          if (tel.value.length !== 0) {
            tel.value = `+${tel.value[0]} (${tel.value[1]}${tel.value[2]}${tel.value[3]}) ${tel.value[4]}${tel.value[5]}${tel.value[6]}-${tel.value[7]}${tel.value[8]}-${tel.value[9]}${tel.value[10]}`;
          }
        }

        if (sessionStorage.getItem(input.id)) {
          if (input.id === 'account_input-img') {
            sessionStorage.removeItem('account_input-img');
          };
          document.querySelector(`#${input.id}`).value = sessionStorage.getItem(input.id);
        }

        if (input.id === 'account_input-age') {
          if (input.value !== '') {
            input.type = 'date';
          }
        }

        input.addEventListener('input', (e) => {
          sessionStorage.setItem(input.id, input.value);
        });
      });
    }
    inputImgAvatar() {
      //смена аватарки в профиле
      this.avatar.addEventListener("change", function () {
        if (this.avatar.files[0]) {
          let fr = new FileReader();

          fr.addEventListener(
            "load",
            function () {
              document.querySelector(".account_image-wrap img").style.display = 'block';
              document.querySelector(".account_image-wrap img").src = fr.result;
            },
            false
          );

          fr.readAsDataURL(this.avatar.files[0]);
        }
      });
    }
    dropGender() {
      //выбор пола
      this.dropboxGender.addEventListener("click", function () {
        let inputGender = document.querySelector(".account_input-gender");
        let listGender = document.querySelectorAll(".account_gender-list span");

        document.querySelector(".account_gender-select svg").classList.toggle("dropdown");
        if (document.querySelector(".account_gender-select svg").classList.contains("dropdown")) {
          document.querySelector(".account_gender-list").style.display = "flex";
        } else {
          document.querySelector(".account_gender-list").style.display = "none";
        }

        listGender.forEach((item) => {
          item.addEventListener("click", function () {
            inputGender.value = item.innerText;
            document.querySelector(".account_gender-select svg").classList.remove("dropdown");
            document.querySelector(".account_gender-list").style.display = "none";
          });
        });
      });
    }
    inputPhone() {
      //ввод номера телефона
      let keyCode;
      function Mask(event) {
        event.keyCode && (keyCode = event.keyCode);
        let pos = this.selectionStart;
        if (pos < 3) event.preventDefault();
        let matrix = "+7 (___) ___-__-__",
          i = 0,
          def = matrix.replace(/\D/g, ""),
          val = this.value.replace(/\D/g, ""),
          newValue = matrix.replace(/[_\d]/g, function (a) {
            return i < val.length ? val.charAt(i++) || def.charAt(i) : a;
          });
        i = newValue.indexOf("_");
        if (i != -1) {
          i < 5 && (i = 3);
          newValue = newValue.slice(0, i);
        }
        let reg = matrix
          .substr(0, this.value.length)
          .replace(/_+/g, function (a) {
            return "\\d{1," + a.length + "}";
          })
          .replace(/[+()]/g, "\\$&");
        reg = new RegExp("^" + reg + "$");
        if (
          !reg.test(this.value) ||
          this.value.length < 5 ||
          (keyCode > 47 && keyCode < 58)
        )
          this.value = newValue;
        if (event.type == "blur" && this.value.length < 5) this.value = "";
      }

      this.phone.addEventListener("input", Mask, false);
      this.phone.addEventListener("focus", Mask, false);
      this.phone.addEventListener("blur", Mask, false);
      this.phone.addEventListener("keydown", Mask, false);
    }
    init() {
      this.inputCustom();
      this.inputImgAvatar();
      this.dropGender();
      this.inputPhone();
    }
  }

  if (document.querySelector('.account_personal-data')) {
    const accountInfo = new AccountInfo(document.querySelector("#account_input-img"), document.querySelector(".account_input-gender-wrapper"), document.querySelector('.account_personal-data').querySelectorAll('input'), document.querySelector("#account_personal-tel"));
    accountInfo.init();

    if (sessionStorage.getItem('anxiety')) {
      let user_alarm = sessionStorage.getItem('anxiety');
      var formData = new FormData();
      formData.append("user_alarm", user_alarm);
      $.ajax({
        url: "save_alarm",
        type: "POST",
        dataType: "json",
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success: function (data) {
          console.log(data);
        },
        error: function (jqxhr, status, errorMsg) {
          uploadInfoShow(1, 'red', 'При загрузке произошла неизвестная ошибка!');
        },
      });

    }
  }
})();

//Update Uploads
$("#upload_btn").click(function (e) {
  e.preventDefault();
  $("input").removeClass("error");
  //val()- взять инф-цию с данного эл-нта
  if (window.FormData === undefined) {
    alert('В вашем браузере загрузка файлов не поддерживается');
  } else {
    let gender = $('input[name="account_input-gender"]').val();
    let age = $('input[name="account_input-age"]').val();
    let first_name = $('input[name="account_input-firstName"]').val();
    let last_name = $('input[name="account_input-lastName"]').val();
    let email = $('input[name="account_input-email"]').val();
    let tel = $('input[name="account_input-tel"]').val();
    let send = $('input[name="account_btn-save"]').val();

    var formData = new FormData();
    formData.append("gender", gender);
    formData.append("age", age);
    formData.append("first_name", first_name);
    formData.append("last_name", last_name);
    formData.append("tel", tel);
    formData.append("email", email);
    formData.append("send", send);
    $.each($("#account_input-img")[0].files, function (key, input) {
      formData.append('image', input);
    });

    //обьект ajax со св-ми ,как было у формы.
    $.ajax({
      url: "account_check",
      type: "POST",
      dataType: "json",
      processData: false,
      contentType: false,
      cache: false,
      data: formData,
      success: function (data) {
        if (data.status === true) {
          uploadInfoShow(1, 'green', 'Данные успешно сохранены!');
          sessionStorage.clear();
        } else {
          for (let key in data) {
            if (key !== 'status') {
              let val;
              if (key === 'first_name') {
                val = `account_input-firstName`;
              } else if (key === 'last_name') {
                val = `account_input-lastName`;
              } else if (key === 'image') {
                val = `account_input-img`;
              } else {
                val = `account_input-${key}`;
              }
              showError(val, data[key]);
              hideError(val);
            }
          }
        }
      },
      error: function (jqxhr, status, errorMsg) {
        uploadInfoShow(1, 'red', 'При загрузке произошла неизвестная ошибка!');
      },
    });
  }
});

//уточнение отписки 
(() => {
  if (document.querySelector('.account_sections-footer')) {
    document.querySelector('.account_sections-footer .account_bth_payment-off').addEventListener('click', function () {
      document.querySelector('.account_payment-off_banner_background').style.display = 'block';
    })
  }
  if (document.querySelector('#payment-off_banner')) {
    if (document.querySelector('.account_payment-off_yes')) {
      document.querySelector('.account_payment-off_yes').addEventListener('click', function () {
        window.location.href = document.location.protocol + '//' + document.location.host + '/pay?autopay=turn_off';
      })
      document.querySelector('.account_payment-off_no').addEventListener('click', function () {
        document.querySelector('.account_payment-off_banner_background').style.display = 'none';
      })
      document.querySelector('.account_payment-off_banner .pay-banner_btnClose').addEventListener('click', function () {
        document.querySelector('.account_payment-off_banner_background').style.display = 'none';
      })
    }
    if (document.querySelector('.account_payment-off_buttons .blue_btn')) {
      document.querySelector('.account_payment-off_buttons .blue_btn').addEventListener('click', function () {
        window.location.href = document.location.protocol + '//' + document.location.host + '/account';
      })
      document.querySelector('.account_payment-off_banner .pay-banner_btnClose').addEventListener('click', function () {
        window.location.href = document.location.protocol + '//' + document.location.host + '/account';
      })
    }
  }
})();

function clickButtonReaction(btnSelect, btnNonSelect) {
  if (btnNonSelect.classList.contains('select')) {
    btnNonSelect.classList.remove('select');
  }
  btnSelect.classList.add('select');
}

function addLike(post_id, user_id, e) {
  let type = e.currentTarget.getAttribute('id');
  if (type == "like") {
    clickButtonReaction(like, dislike);
  } else if (type == "dislike") {
    clickButtonReaction(dislike, like);
  }

  $.ajax({
    type: "POST",
    url: 'add_like',
    data: {
      post_id: post_id,
      user_id: user_id,
      type: type
    },
    success: function (data) {
      data = JSON.parse(data);
    }
  });
}

(() => {
  if (document.querySelector('#like')) {
    let like = document.querySelector('#like');
    let dislike = document.querySelector('#dislike');
    let btns = [like, dislike];

    let userId = document.querySelector('.single_button-reaction').dataset.userId;
    let postId = document.querySelector('.single_button-reaction').dataset.postId;

    btns.forEach((btn) => {
      btn.addEventListener("click", (e) => addLike(postId, userId, e));
    })
  }
})();


// ADMIN ADD SURVEY

function createSurvey() {
  const pollName = document.getElementById('poll_name').value;
  const qroupsQuestions = document.querySelectorAll('.question-group');

  // Создаем объект опроса
  const survey = {
    name: pollName,
    questions: []
  };

  qroupsQuestions.forEach((question, ind) => {
    let array = {};
    array.index = ind;
    question.querySelectorAll('.answers-group input').forEach(elem => {
      if (elem.checked) {
        array.type = elem.value;
      }
    });

    array.title = encodeURI(question.querySelector('.question_name input').value);
    if (question.querySelector('.question_description input')) {
      array.description = encodeURI(question.querySelector('.question_description input').value);
    }
    if (question.querySelector('.question_info input')) {
      array.info = encodeURI(question.querySelector('.question_info input').value);
    }

    array.answers = [];

    if (question.querySelectorAll('.answer-group_input-answer') || question.querySelectorAll('.answer-group_input-answer').length > 0) {
      question.querySelectorAll('.answer-group_input-answer').forEach(elem => {
        array.answers.push(encodeURI(elem.querySelector('input').value));
      })
    }

    survey.questions.push(array)
  })
  // Возвращаем объект опроса в формате JSON
  console.log(survey)
  return (survey);
}

// Отправка формы
$('#survey-form').submit(function (e) {
  e.preventDefault();
  const survey = createSurvey();


  $.ajax({
    url: "add_survey_check",
    type: "POST",
    dataType: "json",
    data: { survey: survey },
    success: function (data) {
      console.log(data)
    },
    error: function (jqxhr, status, errorMsg) {
      console.log(errorMsg)
    },
  });
});


(() => {
  if (document.querySelector('#survey-form')) {
    //радиокнопки в выборе типа ответа
    function radioListenerBtns() {
      let parents = document.querySelectorAll('.answer-group_radio-wrp');
      parents.forEach((parent) => {

        let radioBtns = parent.querySelectorAll('input');
        radioBtns.forEach((radioBtn) => {
          radioBtn.addEventListener('click', function () {
            radioBtns.forEach((btn) => {
              if (btn !== radioBtn) {
                btn.checked = false;
              }
            })
            radioBtn.checked = true;

            if (radioBtn.value === 'textarea') {
              radioBtn.closest('.question-group').querySelectorAll('.answer-group_input-answer').forEach(elem => elem.style.display = 'none');
              radioBtn.closest('.question-group').querySelector('.add-answer').style.display = 'none';
            } else {
              radioBtn.closest('.question-group').querySelectorAll('.answer-group_input-answer').forEach(elem => elem.style.display = 'flex');
              radioBtn.closest('.question-group').querySelector('.add-answer').style.display = 'block';
            }
          })
        })
      })
    }
    radioListenerBtns();

    //добавить ответ
    let inputAnswer = `
      <div class='answer-group_input-answer'>
        <label>
            <span>Ответ:</span>
            <input type="text">
        </label>
        <button type="button" class="delete-answer">Удалить ответ</button>
      </div>
    `;
    function addAnswer(e) {
      let parent = e.target.closest('.question-group');
      let array = parent.querySelectorAll('.answer-group_input-answer');
      if (array.length === 0) {
        parent.querySelector('.answer-group').insertAdjacentHTML("beforeend", inputAnswer)
      } else {
        array[array.length - 1].insertAdjacentHTML('afterend', inputAnswer);
      }
      array = parent.querySelectorAll('.answer-group_input-answer')
      array[array.length - 1].querySelector('.delete-answer').addEventListener('click', removeAnswer);
    }
    document.querySelector('.add-answer').addEventListener('click', addAnswer);

    //удалить ответ
    function removeAnswer(e) {
      if (e.target.closest('.answer-group').querySelectorAll('.answer-group_input-answer').length > 1) {
        e.target.closest('.answer-group_input-answer').remove();
      }
    }
    document.querySelector('.delete-answer').addEventListener('click', removeAnswer);

    //добавить вопрос
    let questionGroup = (index) => {
      return `
        <div class="question-group">
          <label class='question_name'>
              <span class='question_name-span'>Вопрос ${index}:</span>
              <input type="text">
          </label>
          <label class='question_description'>
              <span class='question_description-span'>Описание вопроса</span>
              <input type="text">
          </label>
          <label class='question_info'>
              <span class='question_info-span'>Дополнительная информация</span>
              <input type='text'>
          </label>
          <div class="answer-group">
              <span class='answer-group_title'>Тип ответа:</span>

              <div class='answer-group_radio-wrp answers-group'>
                  <label class='answer-group_radio'>
                      <input type="radio" value='radio' checked>
                      <span class=''>Выбор одного ответа</span>
                  </label>
                  <label class='answer-group_checkbox'>
                      <input type="radio" value='checkbox'>
                      <span class=''>Выбор нескольких ответов</span>
                  </label>
                  <label class='answer-group_textarea'>
                      <input type="radio" value='textarea'>
                      <span class=''>Свободный ввод текста</span>
                  </label>
              </div>

              <div class='answer-group_input-answer'>
                  <label>
                      <span>Ответ:</span>
                      <input type="text">
                  </label>
                  <button type="button" class="delete-answer">Удалить ответ</button>
              </div>
          </div>
          <button type="button" class="add-answer">Добавить ответ</button>
          <div class="question-actions">
              <button type="button" class="delete-question">Удалить вопрос</button>
          </div>
      </div>
      `;
    }

    let indexQuestion = 3;
    function addQuestion() {
      indexQuestion++;
      let array = document.querySelectorAll('.question-group');
      if (array.length === 0) {
        document.querySelector('.survey_wrp-title').insertAdjacentHTML("afterend", questionGroup(indexQuestion))
      } else {
        array[array.length - 1].insertAdjacentHTML('afterend', questionGroup(indexQuestion));
      }

      array = document.querySelectorAll('.question-group');
      let currentElem = array[array.length - 1];

      radioListenerBtns();
      currentElem.querySelector('.add-answer').addEventListener('click', addAnswer);
      currentElem.querySelectorAll('.delete-answer').forEach(elem => elem.addEventListener('click', removeAnswer));
      currentElem.querySelector('.delete-question').addEventListener('click', deleteQuestion);
    }

    document.querySelector('.add-question').addEventListener('click', addQuestion);

    function deleteQuestion(e) {
      e.target.closest('.question-group').remove();

      document.querySelectorAll('.question-group').forEach((elem, ind) => {
        elem.querySelector('.question_name-span').textContent = `Вопрос ${ind + 1}:`;
      })

      indexQuestion--;
    }

    document.querySelectorAll('.delete-question').forEach((deleteBtn) => {
      deleteBtn.addEventListener('click', deleteQuestion);
    })
  }
})();











// CREATE SURVEY

// Создать опрос
function generateSurvey(data, surveyContainer, id, nameSurvey) {
  document.querySelector('.survey_opening-text').style.display = 'none';
  let btnSurvey = document.querySelector('.button-survey');
  btnSurvey.onclick = null;

  // Создаем форму
  const formSection = `<form id="form-survey">
  <div class='survey-form_header'>
      <div class='survey-form_header__text'>
          <button type="button" class="survey_prev-btn"></button>
          <div class='survey-form_header__progress'>
              <span class='progress_passed'>1</span>
              <span>/</span>
              <span class='progress_all'>32</span>
          </div>
      </div>
      <div class="progress-bar">
          <div data-size="10" class="progress"></div>
      </div>
  </div>
</form>`;

  surveyContainer.insertAdjacentHTML('beforeend', formSection);
  const form = document.querySelector('#form-survey');

  //выставление начального прогресса прохождения опроса
  let passedProgress = form.querySelector('.progress_passed');
  let countQuestion = form.querySelector('.progress_all');
  countQuestion.textContent = `${Object.keys(data).length + 1}`;
  let progressBar = form.querySelector('.progress');

  function sizeProgress(num) {
    passedProgress.textContent = num;
    let size = 100 / (Object.keys(data).length + 1);
    size *= num;
    progressBar.style.width = 0;
    progressBar.style.width = `${size}%`;
  }
  sizeProgress(1)

  //создаем кнопку назад
  const prevBtn = document.querySelector('.survey_prev-btn');

  // Создаем вопросы
  for (let keyData in data) {
    // Создаем контейнер для вопроса
    const questionContainer = document.createElement('div');
    questionContainer.classList.add(`question-container`);
    questionContainer.classList.add(`question-container_${data[keyData]['type']}`);
    form.appendChild(questionContainer);

    // Добавляем заголовок вопроса
    const questionTitle = document.createElement('h3');
    questionTitle.innerText = `${decodeURI(data[keyData]['title'])}`;
    questionTitle.className = 'question-title';
    questionContainer.appendChild(questionTitle);

    if (data[keyData]['type'] === 'sex') {
      questionTitle.innerText = `Ваш пол`;

      const container = document.createElement('div');
      container.classList.add('container-sex');
      questionContainer.appendChild(container);

      ['Женщина', 'Мужчина', 'Не бинарный'].forEach((sex) => {
        const answerContainer = document.createElement('div');
        answerContainer.classList.add('answer-container');
        container.appendChild(answerContainer);

        const label = document.createElement('label');
        label.innerText = sex;
        label.className = 'label-sex';
        answerContainer.appendChild(label);

        const input = document.createElement('input');
        input.type = 'radio';
        input.name = 'sex';
        input.value = sex;
        label.appendChild(input);

        let checkmark = document.createElement('span');
        checkmark.className = 'checkmark';
        label.appendChild(checkmark);
      })

    }

    if (data[keyData]['type'] === 'age') {
      questionContainer.classList.add(`question-container_textarea`);

      questionTitle.innerText = `Сколько вам лет?`;

      const answerContainer = document.createElement('div');
      answerContainer.classList.add('answer-container');
      questionContainer.appendChild(answerContainer);

      const input = document.createElement('input');
      input.type = 'text';
      input.placeholder = 'ДД.ММ.ГГГГ';
      input.min = "1900-01-01";
      input.max = "2022-12-31";
      input.addEventListener('focus', (e) => e.target.type = 'date');
      input.addEventListener('blur', (e) => e.target.value == '' ? e.target.type = 'text' : e.target.type = 'date')

      answerContainer.appendChild(input);
    }

    //доп.информация
    if (data[keyData]['info']) {
      let questionInfo = document.createElement('div');
      questionInfo.className = 'question-info';
      questionInfo.innerHTML += `<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
      <g clip-path="url(#clip0_56_7392)">
      <path d="M18 22C17.4477 22 17 21.5523 17 21V15C17 14.4477 16.5523 14 16 14H14C13.4477 14 13 14.4477 13 15C13 15.5523 13.4477 16 14 16C14.5523 16 15 16.4477 15 17V21C15 21.5523 14.5523 22 14 22H13C12.4477 22 12 22.4477 12 23C12 23.5523 12.4477 24 13 24H19C19.5523 24 20 23.5523 20 23C20 22.4477 19.5523 22 19 22H18ZM16 8C15.7033 8 15.4133 8.08797 15.1666 8.2528C14.92 8.41762 14.7277 8.65189 14.6142 8.92597C14.5006 9.20006 14.4709 9.50166 14.5288 9.79264C14.5867 10.0836 14.7296 10.3509 14.9393 10.5607C15.1491 10.7704 15.4164 10.9133 15.7074 10.9712C15.9983 11.0291 16.2999 10.9994 16.574 10.8858C16.8481 10.7723 17.0824 10.58 17.2472 10.3334C17.412 10.0867 17.5 9.79667 17.5 9.5C17.5 9.10218 17.342 8.72064 17.0607 8.43934C16.7794 8.15804 16.3978 8 16 8Z" fill="#7264AA"/>
      <path d="M16 30C13.2311 30 10.5243 29.1789 8.22202 27.6406C5.91973 26.1022 4.12532 23.9157 3.06569 21.3576C2.00607 18.7994 1.72882 15.9845 2.26901 13.2687C2.80921 10.553 4.14258 8.05845 6.10051 6.10051C8.05845 4.14258 10.553 2.80921 13.2687 2.26901C15.9845 1.72882 18.7994 2.00607 21.3576 3.06569C23.9157 4.12532 26.1022 5.91973 27.6406 8.22202C29.1789 10.5243 30 13.2311 30 16C30 19.713 28.525 23.274 25.8995 25.8995C23.274 28.525 19.713 30 16 30ZM16 4.00001C13.6266 4.00001 11.3066 4.70379 9.33316 6.02237C7.35977 7.34095 5.8217 9.21509 4.91345 11.4078C4.0052 13.6005 3.76756 16.0133 4.23058 18.3411C4.69361 20.6689 5.83649 22.8071 7.51472 24.4853C9.19296 26.1635 11.3312 27.3064 13.6589 27.7694C15.9867 28.2325 18.3995 27.9948 20.5922 27.0866C22.7849 26.1783 24.6591 24.6402 25.9776 22.6668C27.2962 20.6935 28 18.3734 28 16C28 12.8174 26.7357 9.76516 24.4853 7.51472C22.2348 5.26429 19.1826 4.00001 16 4.00001Z" fill="#7264AA"/>
      </g>
      <defs>
      <clipPath id="clip0_56_7392">
      <rect width="32" height="32" fill="white"/>
      </clipPath>
      </defs>
      </svg>`;
      questionTitle.appendChild(questionInfo);
      questionInfo.addEventListener('click', function () {
        document.querySelector('.survey_modal-text').innerHTML = decodeURI(data[keyData]['info']);
        document.querySelector('.survey_modal-info').style.display = 'block';
      })
    }

    // Добавляем описание вопроса
    if (data[keyData]['description']) {
      const questionDescription = document.createElement('p');
      questionDescription.innerText = `${decodeURI(data[keyData]['description'])}`;
      questionDescription.className = 'question-description';
      questionContainer.appendChild(questionDescription);
    }

    function inputRange(length, array, questionContainer) {
      const answerContainer = document.createElement('div');
      answerContainer.classList.add('answer-container');
      questionContainer.appendChild(answerContainer);

      answerContainer.insertAdjacentHTML('beforeend', `
        <div class="slidecontainer">
          <input type="range" min="1" max="" value="" class="slider-range">
          <div class="slidecontainer_range-wrp">
            <div class="slide-delimeter_wrp"></div>
          </div>
          <div class="slide-delimeter_wrp"></div>
          <input class="slidecontainer-checked" value='' type='radio' checked>
        </div>`);

      let slideContainer = answerContainer.querySelector('.slidecontainer');

      //расстановка штифтов
      for (let i = 0; i < length; i++) {
        slideContainer.querySelector('.slide-delimeter_wrp').innerHTML += `<span class='slide-delimeter'></span>`;
      }
      let styles = window.getComputedStyle(slideContainer.querySelector('.slide-delimeter_wrp'));
      let widthSlide = parseFloat(styles.width);
      let left = 0;
      slideContainer.querySelector('.slide-delimeter_wrp').querySelectorAll('.slide-delimeter').forEach((elem, ind) => {
        elem.style.left = left + 'px';
        left += (widthSlide / (length - 1));
        elem.innerHTML += `<span class='slide-delimeter_text'>${decodeURI(array[ind])}</span>`;
        elem.querySelector('.slide-delimeter_text').style.left = '-' + parseFloat(window.getComputedStyle(elem.querySelector('.slide-delimeter_text')).width) / 2 + 'px';
      });
      let checkedValue = array[0];
      let widthInput = window.getComputedStyle(slideContainer).width;
      widthInput = parseFloat(widthInput);
      answerContainer.querySelector('.slidecontainer input[type="range"]').style.width = widthInput + 22 + 'px';
      let inputRange = answerContainer.querySelector('.slider-range');
      inputRange.max = widthInput;
      let paddingSize = ((widthInput - widthSlide) / 2);
      let pieceLength = widthInput / length;
      inputRange.value = paddingSize + ((widthSlide / (length - 1)) * 0);
      slideContainer.querySelector('.slidecontainer-checked').value = decodeURI(checkedValue);
      // console.log(slideContainer.querySelector('.slidecontainer-checked').value);
      inputRange.addEventListener('change', function (e) {
        let value = e.target.value;
        for (let i = 0; i < length; i++) {
          if ((value > pieceLength * i - (pieceLength / 2 - paddingSize)) && (value <= (pieceLength * (i + 1) - (pieceLength / 2 - paddingSize)))) {
            e.target.value = paddingSize + ((widthSlide / (length - 1)) * i);
            checkedValue = array[i];
            break;
          } else {
            e.target.value = paddingSize + ((widthSlide / (length - 1)) * (length - 1));
            checkedValue = array[i];
          }

        }
        slideContainer.querySelector('.slidecontainer-checked').value = decodeURI(checkedValue);
        // console.log(slideContainer.querySelector('.slidecontainer-checked').value)
      })
    }

    // Тип ответа - RADIO-кнопки
    if (data[keyData]['type'] === 'radio') {
      inputRange(Object.keys(data[keyData]['answers']).length, data[keyData]['answers'], questionContainer);

      // window.addEventListener('resize', inputRange(Object.keys(data[keyData]['answers']).length, data[keyData]['answers'], questionContainer));
    }
    // Тип ответа - чекбокс-кнопки
    if (data[keyData]['type'] === 'checkbox') {
      const answersContainer = document.createElement('div');
      answersContainer.classList.add('answers-container');
      questionContainer.appendChild(answersContainer);

      for (let keyAnswer in data[keyData]['answers']) {
        // Создаем контейнер для ответов
        const answerContainer = document.createElement('div');
        answerContainer.classList.add('answer-container');
        answersContainer.appendChild(answerContainer);

        const label = document.createElement('label');
        label.innerText = decodeURI(data[keyData]['answers'][keyAnswer]);
        answerContainer.appendChild(label);

        const input = document.createElement('input');
        input.type = 'checkbox';
        // input.name = `question-${keyAnswer}-answer`;
        input.value = decodeURI(data[keyData]['answers'][keyAnswer]);
        label.appendChild(input);
        let checkmark = document.createElement('span');
        checkmark.className = 'checkmark';
        label.appendChild(checkmark);
      }
    }

    // Тип ответа - текстовое поле
    if (data[keyData]['type'] === 'textarea') {
      for (let keyAnswer in data[keyData]['answers']) {
        // Создаем контейнер для ответов
        const answerContainer = document.createElement('div');
        answerContainer.classList.add('answer-container');
        questionContainer.appendChild(answerContainer);

        const label = document.createElement('label');
        label.innerText = decodeURI(data[keyData]['answers'][keyAnswer]);
        answerContainer.appendChild(label);
        const input = document.createElement('input');
        input.type = 'text';
        input.placeholder = 'Развернутый ответ';
        // input.name = `question-${keyAnswer}-answer`;
        label.appendChild(input);
      }
    }
  }

  //последний вопрос про стресс 
  const questionContainer = document.createElement('div');
  questionContainer.classList.add(`question-container`);
  questionContainer.classList.add(`question-container_stress`);
  form.appendChild(questionContainer);

  // Добавляем заголовок вопроса
  const questionTitle = document.createElement('h3');
  questionTitle.innerText = 'Укажите ваш уровень стресса';
  questionTitle.className = 'question-title';
  questionContainer.appendChild(questionTitle);

  questionContainer.innerHTML += `  <div class='question-container_stress-description'>
  <p>1 — у меня нет стресса, я легко концентрируюсь, чувствую себя физически хорошо;</p>
  <p>2 - в целом все идет хорошо, но иногда я легко раздражаюсь;</p>
  <p>3 - я нервничаю и тревожусь чаще. Хуже концентрируюсь, но могу выполнять все личные и рабочие задачи;</p>
  <p>4 - мне сложно выносить неопределенность и сюрпризы. Чувствую себя взвинченным, часто бываю уставшим и подавленным;</p>
  <p>5 - мне кажется, что сложности и проблемы только наваливаются, и я уже не могу ничего с ними сделать. Не могу сконцентрироваться или расслабиться, плохо сплю.</p>
  </div>`;

  function inputStressRange() {
    inputRange(5, ['1', '2', '3', '4', '5'], questionContainer);
  }
  inputStressRange()

  let indexQuestion = 0;
  let questions = document.querySelectorAll('.question-container');
  //кнопка назад
  prevBtn.addEventListener('click', function () {
    if (indexQuestion > 0) {
      questions[indexQuestion].style.display = 'none';
      indexQuestion--;
      questions[indexQuestion].style.display = 'block';
      sizeProgress(indexQuestion + 1)

      // если нажата кнопка назад на последнем вопросе
      if (btnSurvey.textContent !== 'Далее') {
        btnSurvey.textContent = 'Далее';
        btnSurvey.removeEventListener('click', resultsClick);
        btnSurvey.addEventListener('click', prevAnswer);
      }
    }
  })

  //кнопка далее
  btnSurvey.textContent = 'Далее';
  questions[0].style.display = 'block';
  for (let i = 1; i < questions.length; i++) {
    questions[i].style.display = 'none';

  }
  function prevAnswer() {
    questions[indexQuestion].style.display = 'none';
    if (!((indexQuestion + 1) < questions.length - 1)) {
      //кнопка завершения опроса
      btnSurvey.removeEventListener('click', prevAnswer);
      results(btnSurvey);
    }
    indexQuestion++;
    questions[indexQuestion].style.display = 'block';
    sizeProgress(indexQuestion + 1)
  }
  btnSurvey.addEventListener('click', prevAnswer);

  // получение результата
  function results(btnSurvey) {
    btnSurvey.innerText = 'Получить результаты';
    btnSurvey.type = 'submit';
    btnSurvey.addEventListener('click', resultsClick);
  }

  function resultsClick(e) {
    getSurveyResults(e, id, nameSurvey, data);
  }
}

// Получить данные с опроса
function getSurveyResults(e, id, nameSurvey, data) {
  e.preventDefault();
  // Получаем все ответы на опрос в виде массива
  const questions = document.querySelectorAll('.question-container');
  // Создаем объект для хранения результатов опроса
  const ID = id;
  const NAME = nameSurvey;
  const results = {};

  // Итерируемся по массиву ответов
  questions.forEach((question, ind) => {
    let questionId = ind + 1;
    if (question.classList.contains('question-container_textarea')) {
      let answerValue = question.querySelector('input').value;

      results[questionId] = answerValue;
    } else {
      results[questionId] = [];
      question.querySelectorAll('input').forEach((answer) => {
        if (answer.checked) {
          results[questionId].push(answer.value);
        }
      })
    }
  })

  // Отправляем данные на сервер
  // console.log(results);
  const DATA = {
    id: ID,
    survey_questions: data,
    survey_name: NAME,
    user_result: results
  };
  // console.log(DATA)
  $.ajax({
    url: "add_survey_check",
    type: "POST",
    dataType: "json",
    data: { user_answers: DATA },
    success: function (data) {
      // console.log(data)
      document.querySelector('.survey_modal-info').style.display = 'block';
      document.querySelector('.survey_modal-info').querySelector('.survey_modal_btn-close').style.display = 'none';
      document.querySelector('.survey_modal-info').querySelector('.survey_modal-text').innerHTML = `
        <h2 style='text-align: center;'>Спасибо за прохождение опроса</h2>
        <p style='text-align: center; margin-top: 10px; margin-bottom: 10px;'>Теперь рекомендации будут более персонализированными и эффективными для вас.</p>
        <a href="/subscription" class='blue_btn account_analytics_survey-link'>Выйти</a>
      `;
    },
    error: function (jqxhr, status, errorMsg) {
      console.log(errorMsg)
      // document.querySelector('.survey_modal-info').style.display = 'block';
      // document.querySelector('.survey_modal-info').querySelector('.survey_modal_btn-close').style.display = 'none';
      // document.querySelector('.survey_modal-info').querySelector('.survey_modal-text').innerHTML = `
      //   <h2 style='text-align: center;'>Спасибо за прохождение опроса</h2>
      //   <a href="/account" class='blue_btn account_analytics_survey-link'>Выйти</a>
      // `;
      // document.querySelector('.survey_modal-info').querySelector('.survey_modal-text').innerHTML += '<h2>Спасибо за прохождение опроса</h2>';
    },
  });

}














