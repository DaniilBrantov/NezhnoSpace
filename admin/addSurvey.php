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




?>

<!-- <form id="survey-form">
    <label for="poll_name">Название опроса:</label>
    <input type="text" id="poll_name" name="poll_name">

    <div class="question-group">
        <label for="question_1" class='question_first-label'>Вопрос 1:</label>
        <input type="text" id="question_1" name="questions[]" class='question_first-input'>
        <div class="answer-group">

            <label id="question_type" for="question_type_1">Тип ответа:</label>
            <input type="radio" id="question_type_1_choice" name="question_type_1" value="choice">
            <label id="select_answer_choice" for="question_type_1_choice">Выбор ответа</label>
            <input type="radio" id="question_type_1_text" name="question_type_1" value="text">
            <label label id="select_answer_txt" for="question_type_1_text">Свободный ввод текста</label>

            <label for="answer_1_1">Ответ:</label>
            <input type="text" id="answer_1_1" name="answers[0][]">
            <button type="button" class="delete-answer">Удалить ответ</button>
        </div>
        <button type="button" class="add-answer">Добавить ответ</button>

        <div class="question-actions">
            <button type="button" class="delete-question">Удалить вопрос</button>
        </div>
    </div>
    <button type="button" class="add-question">Добавить вопрос</button>
    <button type="submit">Создать опрос</button>
</form> -->

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