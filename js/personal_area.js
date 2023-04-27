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
    question.querySelectorAll('.answer-group_radio-wrp input').forEach(elem => {
      if (elem.checked) {
        array.type = elem.value;
      }
    });

    array.text = encodeURI(question.querySelector('.question_name input').value);
    array.answers = [];

    if (question.querySelectorAll('.answer-group_input-answer') || question.querySelectorAll('.answer-group_input-answer').length > 0) {
      question.querySelectorAll('.answer-group_input-answer').forEach(elem => {
        array.answers.push(encodeURI(elem.querySelector('input').value));
      })
    }

    survey.questions.push(array)
  })
  // Возвращаем объект опроса в формате JSON
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
        
        let radioBtns = parent.querySelectorAll('.answer-group_radio-wrp input');
        radioBtns.forEach((radioBtn) => {
          radioBtn.addEventListener('click', function() {
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
              radioBtn.closest('.question-group').querySelectorAll('.answer-group_input-answer').forEach(elem => elem.style.display = 'block');
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
          <div class="answer-group">
              <span class='answer-group_title'>Тип ответа:</span>

              <div class='answer-group_radio-wrp'>
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

    let indexQuestion = 1;
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
        elem.querySelector('.question_name-span').textContent = `Вопрос ${ind+1}:`;
      })

      indexQuestion--;
    }

    document.querySelector('.delete-question').addEventListener('click', deleteQuestion);

  }
})();













// Создать опрос
function generateSurvey(data,surveyName, surveyContainer) {
  // Получаем контейнер для опроса из DOM
  // const surveyContainer = document.getElementById('survey-container');

  // Создаем форму
  const form = document.createElement('form');
  form.id = 'survey-form';
  surveyContainer.appendChild(form);

  // Добавляем заголовок опроса
  const title = document.createElement('h2');
  title.innerText = surveyName;
  form.appendChild(title);

  // Создаем вопросы
  for (let keyData in data) {
    // Создаем контейнер для вопроса
    const questionContainer = document.createElement('div');
    questionContainer.classList.add('question-container');
    form.appendChild(questionContainer);

    // Добавляем текст вопроса
    const questionText = document.createElement('h3');
    questionText.innerText = `${Number(keyData) + 1}. ${decodeURI(data[keyData]['text'])}`;
    questionText.className = 'question-text';
    questionContainer.appendChild(questionText);

    for (let keyAnswer in data[keyData]['answers']) {
      // console.log(decodeURI(data[keyData]['answers'][keyAnswer]))
      // Создаем контейнер для ответов
      const answerContainer = document.createElement('div');
      answerContainer.classList.add('answer-container');
      questionContainer.appendChild(answerContainer);

      // Добавляем элементы в зависимости от типа ответа
      if (data[keyData]['type'] === 'textarea') {
        // Тип ответа - текстовое поле
        const input = document.createElement('input');
        input.type = 'text';
        input.name = `question-${keyAnswer}-answer`;
        answerContainer.appendChild(input);
      } else if (data[keyData]['type'] === 'radio') {
        // Тип ответа - радио-кнопки
        const input = document.createElement('input');
        input.type = 'radio';
        input.name = `question-${keyAnswer}-answer`;
        input.value = decodeURI(data[keyData]['answers'][keyAnswer]);
        answerContainer.appendChild(input);

        const label = document.createElement('label');
        label.innerText = decodeURI(data[keyData]['answers'][keyAnswer]);
        answerContainer.appendChild(label);
        // выбор только одного ответа
        
      } else if (data[keyData]['type'] === 'checkbox') {
        // Тип ответа - чекбокс-кнопки
        const input = document.createElement('input');
        input.type = 'checkbox';
        input.name = `question-${keyAnswer}-answer`;
        input.value = decodeURI(data[keyData]['answers'][keyAnswer]);
        answerContainer.appendChild(input);

        const label = document.createElement('label');
        label.innerText = decodeURI(data[keyData]['answers'][keyAnswer]);
        answerContainer.appendChild(label);
      }
    }
  }

  // Добавляем кнопку для отправки формы
  const submitButton = document.createElement('button');
  submitButton.type = 'submit';
  submitButton.id = 'survey-submit';
  submitButton.innerText = 'Получить результаты';
  form.appendChild(submitButton);
}



// Эта функция не работает(!!preventDefault!!)
$("#survey-submit").click(function (e) {
  e.preventDefault();

  const answers = Array.from(document.querySelectorAll('.answer-container'));

  console.log(answers);
});



// Получить данные с опроса
function getSurveyResults() {
  // Получаем все ответы на опрос в виде массива
  const answers = Array.from(document.querySelectorAll('.answer-container'));

  // Создаем объект для хранения результатов опроса
  const results = {};

  // Итерируемся по массиву ответов
  answers.forEach(answer => {
    // Получаем id вопроса и значение ответа
    const questionId = answer.dataset.questionId;
    const answerValue = answer.value;

    // Если такой вопрос уже есть в объекте результатов,
    // то добавляем значение ответа к массиву ответов на этот вопрос
    if (results.hasOwnProperty(questionId)) {
      results[questionId].push(answerValue);
    }
    // Иначе создаем новый ключ в объекте результатов с этим вопросом и ответом
    else {
      results[questionId] = [answerValue];
    }
  });

  // Выводим результаты опроса в консоль
  console.log(results);
}




















// function createSurvey() {
//   // Получаем данные опроса из формы
//   const pollName = document.getElementById('poll_name').value;
//   const questionInputs = document.querySelectorAll('input[name="questions[]"]');
//   const answerInputs = document.querySelectorAll('input[name^="answers"]');

//   // Создаем объект опроса
//   const survey = {
//     name: pollName,
//     questions: []
//   };

//   // Добавляем вопросы и ответы в объект опроса
//   let currentQuestion = null;
//   for (let i = 0; i < answerInputs.length; i++) {
//     const input = answerInputs[i];
//     const nameParts = input.name.split('[');
//     const questionIndex = parseInt(nameParts[1]);
//     const answerIndex = parseInt(nameParts[2].replace(']', ''));

//     if (!currentQuestion || questionIndex !== currentQuestion.index) {
//       currentQuestion = {
//         index: questionIndex,
//         text: questionInputs[questionIndex].value,
//         answers: []
//       };
//       survey.questions.push(currentQuestion);
//     }
//     currentQuestion.answers.push(input.value);
//   }
//   // Возвращаем объект опроса в формате JSON
//   return (survey);
// }



// // Удаление вопроса
// function deleteQuestion(e) {
//   e.target.closest('.question-group').remove();
//   document.querySelectorAll('.question-group').forEach((elem, ind) => {
//     let index = ind+1;
//     if (elem.querySelector('.question_first-input')) {
//       elem.querySelector('.question_first-input').id = `question_${index}`;
//     }
//     elem.querySelector('.question_first-label').setAttribute('for', `question_${index}`);
//     elem.querySelector('.question_first-label').textContent = `Вопрос ${index}:`;
//     console.log(index, elem.querySelector('.question_first-label'))
// //     console.log(elem.querySelectorAll('input'));
// //     var tmpNode = document.getElementById('d7');
// // tmpNode.id = "d8";
// //     elem.querySelectorAll('input')
//   })
  
//   // $(this).closest('.question-group').remove();
//   // $('.question-group').each(function (index) {
//   //   $(this).find('label').first().text(`Вопрос ${index + 1}:`);
//   // });

//   questionIndex--;
// }

// // $('.delete-question').click(deleteQuestion);
// // document.querySelector('.delete-question').addEventListener('click', deleteQuestion);
// document.addEventListener('DOMContentLoaded', function() {
//   if (document.querySelector('.question-group')) {
//     document.querySelectorAll('.delete-question').forEach(element => {
//       element.addEventListener('click', deleteQuestion);
//     });
//   }
// })



// // $("#add_survey_btn").click(function (e) {
// //   e.preventDefault();
// //   const survey = createSurvey();
// //   console.log(survey);
// // });

// const questionGroup = (index) => {
//   return `
//     <div class="question-group">
//     <label for="question_${index}" class='question_first-label'>Вопрос ${index}:</label>
//     <input type="text" id="question_${index}" name="questions[]" class='question_first-input'>
//     <div class="answer-group">
//         <label id="question_type" for="question_type_${index}">Тип ответа:</label>
//         <input type="radio" id="question_type_${index}_choice" name="question_type_${index}" value="choice">
//         <label id="select_answer_choice" for="question_type_${index}_choice">Выбор ответа</label>
//         <input type="radio" id="question_type_${index}_text" name="question_type_${index}" value="text">
//         <label label id="select_answer_txt" for="question_type_${index}_text">Свободный ввод текста</label>
    
//         <label for="answer_${index}_1">Ответ:</label>
//         <input type="text" id="answer_${index}_1" name="answers[0][]">
//         <button type="button" class="delete-answer">Удалить ответ</button>
        
//     </div>
//     <button type="button" class="add-answer">Добавить ответ</button>
    
//     <div class="question-actions">
//       <button type="button" class="delete-question">Удалить вопрос</button>
//     </div>
//     </div>
//   `;
// }

// const questionGroupListener = (elem) => {
//   elem.querySelector('.delete-question').addEventListener('click', deleteQuestion);
// }

// // Добавление вопроса
// let questionIndex = 1;
// $('.add-question').click(function () {
//   questionIndex++;
//   let array = document.querySelectorAll('.question-group');

//   array[array.length - 1].insertAdjacentHTML('afterend', questionGroup(questionIndex));
//   array = document.querySelectorAll('.question-group');
//   let elem = array[array.length - 1];
//   questionGroupListener(elem)
//   // elem.querySelector('.delete-question').addEventListener('click', deleteQuestion);
//   // questionGroupListener(array[array.length - 1]);
  
//   // const $questionGroup = $('.question-group').first().clone();
//   // $questionGroup.find('label').text(`Вопрос ${questionIndex}:`);
//   // $questionGroup.find('input').val('');
//   // $questionGroup.find('.answer-group').remove();
//   // $questionGroup.find('.add-answer').click(addAnswer);
//   // $questionGroup.find('.delete-question').click(deleteQuestion);
//   // $('.question-group').last().after($questionGroup);
// });

// // Добавление ответа
// function addAnswer() {
//   const $answerGroup = $(this).prev().clone();
//   const answerIndex = $answerGroup.find('button').length + 1;
//   // $answerGroup.find('#question_type').setAttribute('for', `question_type_${answerIndex}`);

//   // $answerGroup.find('input').val('choice').setAttribute('id', `question_type_${answerIndex}_choice`).setAttribute('type', 'radio').setAttribute('name', `question_type_${answerIndex}`);
//   // $answerGroup.find('#select_answer_choice').setAttribute('for', `question_type_${answerIndex}_choice`);
//   // $answerGroup.find('input').val('choice').setAttribute('id', `question_type_${answerIndex}_text`).setAttribute('type', 'radio').setAttribute('name', `question_type_${answerIndex}`);
//   // $answerGroup.find('#select_answer_txt').setAttribute('for', `question_type_${answerIndex}_text`);

//   // !!! -->
//   $answerGroup.find('input').val('');
//   $answerGroup.find('label').text(`Ответ ${answerIndex}:`);
//   $answerGroup.find('input').val('');
//   $answerGroup.find('.delete-answer').click(deleteAnswer);
//   $(this).before($answerGroup);
// }

// $('.add-answer').click(addAnswer);


// // Удаление ответа
// function deleteAnswer() {
//   $(this).closest('.answer-group').remove();
//   const $answerGroups = $(this).closest('.question-group').find('.answer-group');
//   // $answerGroups.each(function (index) {
//   //   $(this).find('label').first().text(`Ответ ${index + 1}:`);
//   // });
// }

// $('.delete-answer').click(deleteAnswer);





// // Добавляем обработчики событий на радио кнопки для выбора типа ответа
// document.addEventListener('change', function (e) {
//   if (e.target && e.target.matches('[name^="question_type"]')) {
//     // const questionIndex = e.target.name.replace('question_type_', '');
//     const questionType = e.target.value;
//     console.log(questionType);
//     const answerContainer = document.querySelector(`#question_1~.answer-group`);
//     console.log(answerContainer)
//     const answerInputs = answerContainer.querySelectorAll('input[type="text"]');

//     if (questionType === 'choice') {
//       // Показываем кнопки "Добавить ответ" и "Удалить ответ" и делаем все поля ответа видимыми
//       answerContainer.classList.remove('text-answer');
//       const addButton = answerContainer.previousElementSibling;
//       const deleteButton = answerContainer.querySelector('.delete-answer');
//       addButton.style.display = 'inline-block';
//       deleteButton.style.display = 'inline-block';
//       answerInputs.forEach(function (input) {
//         input.style.display = 'inline-block';
//       });
//     } else if (questionType === 'text') {
//       // Скрываем кнопки "Добавить ответ" и "Удалить ответ" и скрываем все поля ответа, кроме одного
//       answerContainer.classList.add('text-answer');
//       const addButton = answerContainer.previousElementSibling;
//       const deleteButton = answerContainer.querySelector('.delete-answer');
//       addButton.style.display = 'none';
//       deleteButton.style.display = 'none';
//       answerInputs.forEach(function (input, index) {
//         if (index === 0) {
//           input.style.display = 'inline-block';
//         } else {
//           input.style.display = 'none';
//         }
//       });
//     }
//   }
// });






