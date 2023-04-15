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




















function createSurvey() {
  // Получаем данные опроса из формы
  const pollName = document.getElementById('poll_name').value;
  const questionInputs = document.querySelectorAll('input[name="questions[]"]');
  const answerInputs = document.querySelectorAll('input[name^="answers"]');

  // Создаем объект опроса
  const survey = {
    name: pollName,
    questions: []
  };

  // Добавляем вопросы и ответы в объект опроса
  let currentQuestion = null;
  for (let i = 0; i < answerInputs.length; i++) {
    const input = answerInputs[i];
    const nameParts = input.name.split('[');
    const questionIndex = parseInt(nameParts[1]);
    const answerIndex = parseInt(nameParts[2].replace(']', ''));

    if (!currentQuestion || questionIndex !== currentQuestion.index) {
      currentQuestion = {
        index: questionIndex,
        text: questionInputs[questionIndex].value,
        answers: []
      };
      survey.questions.push(currentQuestion);
    }
    currentQuestion.answers.push(input.value);
  }
  // Возвращаем объект опроса в формате JSON
  return (survey);
}







// $("#add_survey_btn").click(function (e) {
//   e.preventDefault();
//   const survey = createSurvey();
//   console.log(survey);
// });


// Добавление вопроса
let questionIndex = 1;
$('.add-question').click(function () {
  questionIndex++;
  const $questionGroup = $('.question-group').first().clone();
  $questionGroup.find('label').text(`Вопрос ${questionIndex}:`);
  $questionGroup.find('input').val('');
  $questionGroup.find('.answer-group').remove();
  $questionGroup.find('.add-answer').click(addAnswer);
  $questionGroup.find('.delete-question').click(deleteQuestion);
  $('.question-group').last().after($questionGroup);
});

// Добавление ответа
function addAnswer() {
  const $answerGroup = $(this).prev().clone();
  const answerIndex = $answerGroup.find('button').length + 1;
  // $answerGroup.find('#question_type').setAttribute(`for', 'question_type_${answerIndex}`);
  // $answerGroup.find('input').val('');
  $answerGroup.find('input').val('');
  $answerGroup.find('label').text(`Ответ ${answerIndex}:`);
  $answerGroup.find('input').val('');
  $answerGroup.find('.delete-answer').click(deleteAnswer);
  $(this).before($answerGroup);
}

$('.add-answer').click(addAnswer);

// Удаление вопроса
function deleteQuestion() {
  $(this).closest('.question-group').remove();
  $('.question-group').each(function (index) {
    $(this).find('label').first().text(`Вопрос ${index + 1}:`);
  });
  questionIndex--;
}

$('.delete-question').click(deleteQuestion);

// Удаление ответа
function deleteAnswer() {
  $(this).closest('.answer-group').remove();
  const $answerGroups = $(this).closest('.question-group').find('.answer-group');
  $answerGroups.each(function (index) {
    $(this).find('label').first().text(`Ответ ${index + 1}:`);
  });
}

$('.delete-answer').click(deleteAnswer);

// Отправка формы
$('#survey-form').submit(function (e) {
  e.preventDefault();
  const survey = createSurvey();
  console.log(survey);
});



// Добавляем обработчики событий на радио кнопки для выбора типа ответа
document.addEventListener('change', function (e) {
  if (e.target && e.target.matches('[name^="question_type"]')) {
    const questionIndex = e.target.name.replace('question_type_', '');
    console.log(questionIndex)
    // const questionType = e.target.value;
    // console.log(questionIndex);
    // const answerContainer = document.querySelector(`#question_${questionIndex} .answer-group`);
    // const answerInputs = answerContainer.querySelectorAll('input[type="text"]');

    // if (questionType === 'choice') {
    //   // Показываем кнопки "Добавить ответ" и "Удалить ответ" и делаем все поля ответа видимыми
    //   answerContainer.classList.remove('text-answer');
    //   const addButton = answerContainer.previousElementSibling;
    //   const deleteButton = answerContainer.querySelector('.delete-answer');
    //   addButton.style.display = 'inline-block';
    //   deleteButton.style.display = 'inline-block';
    //   answerInputs.forEach(function (input) {
    //     input.style.display = 'inline-block';
    //   });
    // } else if (questionType === 'text') {
    //   // Скрываем кнопки "Добавить ответ" и "Удалить ответ" и скрываем все поля ответа, кроме одного
    //   answerContainer.classList.add('text-answer');
    //   const addButton = answerContainer.previousElementSibling;
    //   const deleteButton = answerContainer.querySelector('.delete-answer');
    //   addButton.style.display = 'none';
    //   deleteButton.style.display = 'none';
    //   answerInputs.forEach(function (input, index) {
    //     if (index === 0) {
    //       input.style.display = 'inline-block';
    //     } else {
    //       input.style.display = 'none';
    //     }
    //   });
    // }
  }
});
