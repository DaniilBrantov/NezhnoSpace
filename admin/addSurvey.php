<?php
/**
* Template Name: add_survey
*

*/
get_header();
session_start();
require_once(get_theme_file_path('processing.php'));
CheckAuth();
checkAdmin();
header('Content-Type: text/html; charset=utf-8');



$db = new SafeMySQL();
$author_id=$_SESSION['id'];
// $last_survey = $db->getOne("SELECT survey_questions FROM add_survey");
// var_dump(json_decode($last_survey));



$name_survey = $db->getAll("SELECT survey_name FROM add_survey");
$last_survey = $db->getAll("SELECT survey_questions FROM add_survey");
?>

<script>
  // let surveyContainer = document.getElementById('survey-container');
  //выбирает последний опрос из базы данных
  let this_survey = <?php 
      echo($last_survey[count($last_survey)-1]["survey_questions"]);
  ?>;

  // console.log(this_survey)
</script>


<!-- опрос -->
<section class='survey'>
  <div class='background-elipse-1'></div>
  <div class='background-elipse-2'></div>
  <div class='background-elipse-3'></div>
  <div class='survey_opening-text'>
    <h2>Дорогие участники!</h2>
    <p>Благодарим вас за помощь в нашем исследовании. В этой анкете 30 вопросов, прохождение займет у вас 5-10 минут. Анкета анонимная. Ваши ответы помогают нам создать сервис психологической поддержки.</p>
    <p>Если вы хотите после прохождения теста получить от нас обратную связь и комментарии, то вы можете оставить нам свой ник 
      в телеграм (или номер телефона), и мы с вами свяжемся.</p>
  </div>
  <div id="survey-container">
  
  </div>
  <div class='buttons-wrp'>
    <button onclick="generateSurvey(this_survey, document.getElementById('survey-container'))" class='button-survey blue_btn'>Начать</button>
    <a href="/">Выйти из опроса</a>
  </div>

  <div class='survey_modal-info'>
    <div class='survey_modal-wrap'>
      <div class='survey_modal-content'>
        <div class='survey_modal_btn-close' onclick='closeModal()'>
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.0562 5.94383L5.67175 17.3282C5.30075 17.6992 5.30075 18.3008 5.67175 18.6718L5.74246 18.7425C6.11346 19.1135 6.71497 19.1135 7.08597 18.7425L18.4704 7.35804C18.8414 6.98705 18.8414 6.38554 18.4704 6.01454L18.3997 5.94383C18.0287 5.57283 17.4272 5.57283 17.0562 5.94383Z" fill="#111111"/>
            <path d="M18.0562 17.0562L6.67175 5.67175C6.30075 5.30075 5.69925 5.30075 5.32825 5.67175L5.25754 5.74246C4.88654 6.11346 4.88654 6.71497 5.25754 7.08597L16.642 18.4704C17.013 18.8414 17.6145 18.8414 17.9855 18.4704L18.0562 18.3997C18.4272 18.0287 18.4272 17.4272 18.0562 17.0562Z" fill="#111111"/>
          </svg>
        </div>
        <div class='survey_modal-text'></div>
      </div>
    </div>
  </div>
</section>

<script>
  function closeModal() {
    document.querySelector('.survey_modal-info').style.display = 'none';
  }
</script>

<!-- админка -->
<form id="survey-form">
    <div class='survey_wrp-title'>
        <label>
            <span class='title-span'>Название опроса:</span>
            <input type="text" id="poll_name" name="poll_name">
        </label>
    </div>
    <div class="question-group">
      <label class='question_name answers-group'>
          <span class='question_name-span'>Вопрос 1:</span>
          <span>Спросить пол</span>
          <input type="radio" value='sex' style='position: absolute;opacity: 0;height: 0;width: 0;' checked readonly>
      </label>
      <div class="question-actions">
        <button type="button" class="delete-question">Удалить вопрос</button>
      </div>
    </div>
    <div class="question-group">
      <label class='question_name answers-group'>
          <span class='question_name-span'>Вопрос 2:</span>
          <span>Спросить возраст</span>
          <input type="radio" value='age' style='position: absolute;opacity: 0;height: 0;width: 0;' checked readonly>
      </label>
      <div class="question-actions">
        <button type="button" class="delete-question">Удалить вопрос</button>
      </div>
    </div>
    <div class="question-group">
        <label class='question_name'>
            <span class='question_name-span'>Вопрос 3:</span>
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

    <button type="button" class="add-question">Добавить вопрос</button>
    <button type="submit" style='background-color: red;'>Создать опрос</button>
</form>

<?php
get_footer();
?>


