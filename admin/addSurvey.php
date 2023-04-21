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

function checkAdmin(){
    $id=$_SESSION['id'];
    $db = new SafeMySQL();
    $status=$db->getOne("SELECT status FROM users WHERE id=?i", $id);
    if($status === '4'){
        return TRUE;
    }else{
        header('Location: auth');
    }
};


?>

<form id="survey-form">
    <label for="poll_name">Название опроса:</label>
    <input type="text" id="poll_name" name="poll_name">

    <div class="question-group">
        <label for="question_1">Вопрос 1:</label>
        <input type="text" id="question_1" name="questions[]">
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
</form>



<?php
get_footer();
?>