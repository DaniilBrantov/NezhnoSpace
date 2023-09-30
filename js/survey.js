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
  
        ['Женщина', 'Мужчина'].forEach((sex) => {
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
  
      // Функция для создания информационного блока
      function createInfoBlock(data, keyData) {
        const infoContainer = document.createElement('div');
        infoContainer.className = 'question-info';

        // Определите информацию в зависимости от индекса
        let info;
        let question_number = data[keyData]['index'] + 1;
        if (question_number === 12) {
            info = [
                "Мы все знаем, как делать НАДО.",
                "Как правильно питаться, принимать себя такой/таким как есть, не залипать в ленте соцсетей, не прокрастинировать, сократить количество быстрых углеводов, планировать день, дышать и медитировать. И не нервничать.",
                "Мы живем в реальном мире, в нем иногда не оправдываются ожидания, случаются свадьбы и разводы, падение курса валют, много неопределенности и стресса. Еда, шопинг, листание ленты новостей, сериалы, прокрастинация и очень-очень много работы — стратегии справляться со стрессом. Эти стратегии из разряда «никогда такого не было и вот опять». Примеры:",
                "1. Девушка, 30 лет, каждое утро просыпается с мыслью \"мне нужно худеть, я вчера слишком много себе позволила\", утро начинается с составления списка того, что было съедено вечером в предыдущий день, строго подсчитываются калории. Весь день превращается в наказание за переедание с большими физическими нагрузками и жесткими ограничениями в еде. Вечером эмоциональное напряжение доходит до пика, и снова случается пищевой срыв. А дальше по кругу.",
                "2. Мужчина, 39 лет, замечает, что весь день проходит достаточно стабильно и ровно, он может справляться с задачами и стрессом, прекрасно чувствует сигналы тела и свои эмоции. Но всегда после 17-18 часов у него поднимается уровень тревоги, которую ничем невозможно унять, без явной на то причины. Чтобы заглушить это он ест нон-стоп.",
                "3. Девушка, 21 год, совмещает учебу и работу, активно проводит свободное время с другими людьми, есть большая потребность в отдыхе и тишине, но девушка не привыкла расслабляться. Если не друзья и активности, то фоном сериалы под сладости и \"надуманные\" домашние дела.",
                "4. Мужчина, 45 лет, есть телесное ощущение черной дыры в груди и постоянно \"сосет под ложечкой\" от этой пустоты. Мужчина льет в нее кофе, книги, идеи, работу и все вокруг."
            ];
        } else if (question_number === 13) {
            info = [
                "Авторитарный стиль — все решения принимают родители, ребенок во всем должен подчиняться их воле. Родители ограничивают самостоятельность ребенка, не обосновывают свои требования, сопровождая их жестким контролем, суровыми запретами, наказаниями.",
                "Демократический стиль — родители поощряют личную ответственность и самостоятельность детей в соответствии с их возрастными возможностями. Родители требуют от детей осмысленного поведения и стараются помочь им, чутко относясь к их запросам. При этом проявляют твердость, заботятся о справедливости и последовательном соблюдении дисциплины.",
                "Попустительский стиль — ребенок должным образом не направляется, практически не знает запретов и ограничений со стороны родителей или не выполняет указаний родителей, для которых характерно неумение, неспособность или нежелание руководить детьми.",
                "Хаотический стиль — это отсутствие единого подхода к воспитанию, когда нет ясно выраженных, определенных, конкретных требований к ребенку или наблюдаются противоречия, разногласия в выборе воспитательных средств между родителями.",
                "Опекающий стиль — стремление постоянно быть с ребенком, решать за него все возникающие проблемы. Родители бдительно следят за поведением подростка, ограничивают его самостоятельное поведение, тревожатся, что с ним может что-то произойти."
            ];
        } else {
            info = data[keyData]['info'];
        }

        const infoIcon = `<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 22C17.4477 22 17 21.5523 17 21V15C17 14.4477 16.5523 14 16 14H14C13.4477 14 13 14.4477 13 15C13 15.5523 13.4477 16 14 16C14.5523 16 15 16.4477 15 17V21C15 21.5523 14.5523 22 14 22H13C12.4477 22 12 22.4477 12 23C12 23.5523 12.4477 24 13 24H19C19.5523 24 20 23.5523 20 23C20 22.4477 19.5523 22 19 22H18ZM16 8C15.7033 8 15.4133 8.08797 15.1666 8.2528C14.92 8.41762 14.7277 8.65189 14.6142 8.92597C14.5006 9.20006 14.4709 9.50166 14.5288 9.79264C14.5867 10.0836 14.7296 10.3509 14.9393 10.5607C15.1491 10.7704 15.4164 10.9133 15.7074 10.9712C15.9983 11.0291 16.2999 10.9994 16.574 10.8858C16.8481 10.7723 17.0824 10.58 17.2472 10.3334C17.412 10.0867 17.5 9.79667 17.5 9.5C17.5 9.10218 17.342 8.72064 17.0607 8.43934C16.7794 8.15804 16.3978 8 16 8Z" fill="#7264AA"/>
            <path d="M16 30C13.2311 30 10.5243 29.1789 8.22202 27.6406C5.91973 26.1022 4.12532 23.9157 3.06569 21.3576C2.00607 18.7994 1.72882 15.9845 2.26901 13.2687C2.80921 10.553 4.14258 8.05845 6.10051 6.10051C8.05845 4.14258 10.553 2.80921 13.2687 2.26901C15.9845 1.72882 18.7994 2.00607 21.3576 3.06569C23.9157 4.12532 26.1022 5.91973 27.6406 8.22202C29.1789 10.5243 30 13.2311 30 16C30 19.713 28.525 23.274 25.8995 25.8995C23.274 28.525 19.713 30 16 30ZM16 4.00001C13.6266 4.00001 11.3066 4.70379 9.33316 6.02237C7.35977 7.34095 5.8217 9.21509 4.91345 11.4078C4.0052 13.6005 3.76756 16.0133 4.23058 18.3411C4.69361 20.6689 5.83649 22.8071 7.51472 24.4853C9.19296 26.1635 11.3312 27.3064 13.6589 27.7694C15.9867 28.2325 18.3995 27.9948 20.5922 27.0866C22.7849 26.1783 24.6591 24.6402 25.9776 22.6668C27.2962 20.6935 28 18.3734 28 16C28 12.8174 26.7357 9.76516 24.4853 7.51472C22.2348 5.26429 19.1826 4.00001 16 4.00001Z" fill="#7264AA"/>
        </svg>`;
        infoContainer.innerHTML = infoIcon;

        infoContainer.addEventListener('click', () => displayInfo(info));
        return infoContainer;
      }

      // Функция для отображения информации
      function displayInfo(info) {
        const modalText = document.querySelector('.survey_modal-text');
        if (Array.isArray(info)) {
            const paragraphs = info.map(item => `<p>${decodeURI(item)}</p>`);
            modalText.innerHTML = paragraphs.join('');
        } else {
            modalText.innerHTML = decodeURI(info);
        }
        document.querySelector('.survey_modal-info').style.display = 'block';
      }

      // Использование функции для создания информационных блоков
      if (data[keyData]['info']) {
        const questionInfo = createInfoBlock(data, keyData);
        questionTitle.appendChild(questionInfo);
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
      //записать ответ на вопрос в хранилище
      if (questions[indexQuestion].classList.contains('question-container_textarea')) {
        let answerValue = questions[indexQuestion].querySelector('input').value;
        if (localStorage.getItem('survey')) {
          let array = JSON.parse(localStorage.getItem('survey'))
          array[indexQuestion] = answerValue
          localStorage.setItem('survey', JSON.stringify(array))
        } else {
          localStorage.setItem('survey', JSON.stringify({indexQuestion: answerValue}))
        }
      } else {
        let arrayAnswers = [];
        questions[indexQuestion].querySelectorAll('input').forEach((answer) => {
          if (answer.checked) {
            arrayAnswers.push(answer.value);
          }
        })
        let array = JSON.parse(localStorage.getItem('survey'))
        if (array) {
          array[indexQuestion] = arrayAnswers
          localStorage.setItem('survey', JSON.stringify(array))
        } else {
          let arr = {
            [indexQuestion]: arrayAnswers
          }
          localStorage.setItem('survey', JSON.stringify(arr))
        }
      }
  
      indexQuestion++;
      questions[indexQuestion].style.display = 'block';
      sizeProgress(indexQuestion + 1)
    }
    btnSurvey.addEventListener('click', prevAnswer);
  
    //заполнение опроса, если были сохраненные в хранилище ответы
    if (localStorage.getItem('survey')) {
      let local = JSON.parse(localStorage.getItem('survey'))
      Object.keys(local).map((item) => {
        if (questions[indexQuestion].classList.contains('question-container_textarea')) {
          questions[indexQuestion].querySelector('input').value = local[item]
        } else if (questions[indexQuestion].classList.contains('question-container_radio')) {
          let valueLocal = local[item][0];
          let value;
  
          let length = questions[indexQuestion].querySelectorAll('.slide-delimeter').length
          let slideContainer = questions[indexQuestion].querySelector('.slidecontainer');
          let styles = window.getComputedStyle(slideContainer.querySelector('.slide-delimeter_wrp'));
          let widthSlide = parseFloat(styles.width);
          let widthInput = window.getComputedStyle(slideContainer).width;
          widthInput = parseFloat(widthInput);
          let inputRange = questions[indexQuestion].querySelector('.slider-range');
          inputRange.max = widthInput;
          let paddingSize = ((widthInput - widthSlide) / 2);
          let pieceLength = widthInput / length;
  
          questions[indexQuestion].querySelectorAll('.slide-delimeter_text').forEach((text, ind) => {
            if (text.textContent === valueLocal) {
              value = widthInput / questions[indexQuestion].querySelectorAll('.slide-delimeter_text').length * ind
            }
          })
  
          for (let i = 0; i < length; i++) {
            if ((value > pieceLength * i - (pieceLength / 2 - paddingSize)) && (value <= (pieceLength * (i + 1) - (pieceLength / 2 - paddingSize)))) {
              inputRange.value = paddingSize + ((widthSlide / (length - 1)) * i);
              break;
            } else {
              inputRange.value = paddingSize + ((widthSlide / (length - 1)) * (length - 1));
            }
          }
          slideContainer.querySelector('.slidecontainer-checked').value = valueLocal;
        } else {
          questions[indexQuestion].querySelectorAll('input').forEach((input) => {
            local[item].forEach((it) => {
              if (input.value === it) {
                input.checked = true
              }
            })
          })
        }
        questions[indexQuestion].style.display = 'none';
        indexQuestion++
        questions[indexQuestion].style.display = 'block';
        sizeProgress(indexQuestion + 1)
      })
    }
  
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
        localStorage.removeItem('survey')
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