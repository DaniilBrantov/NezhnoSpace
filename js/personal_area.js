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
        window.location.href = 'https://my.cloudpayments.ru/';
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


























