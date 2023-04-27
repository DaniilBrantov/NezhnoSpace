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



<div id="survey-container">

</div>


<script>   
    let surveyContainer = document.getElementById('survey-container');
    //выбирает последний опрос из базы данных
    let this_survey = <?php 
        echo($last_survey[count($last_survey)-1]["survey_questions"])
    ?>;
    let this_name = '<?php 
        echo($name_survey[count($name_survey)-1]["survey_name"])
    ?>';

</script>
<button onclick="generateSurvey(this_survey, this_name, surveyContainer)">Пройти
    опрос</button>


<form id="survey-form">
    <div class='survey_wrp-title'>
        <label>
            <span class='title-span'>Название опроса:</span>
            <input type="text" id="poll_name" name="poll_name">
        </label>
    </div>

    <div class="question-group">
        <label class='question_name'>
            <span class='question_name-span'>Вопрос 1:</span>
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

    <button type="button" class="add-question">Добавить вопрос</button>
    <button type="submit">Создать опрос</button>
</form>



<?php
get_footer();
?>