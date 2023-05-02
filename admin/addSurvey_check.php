<?php
/**
* Template Name: add_survey_check
*

*/
// session_start();
// require_once(get_theme_file_path('processing.php'));



if($_POST['survey']){
    $survey=$_POST['survey'];
    $name=$survey['name'];
    $questions=$survey['questions'];
    $res=[];
    echo json_encode(addSurvey($name,$questions));
}elseif($_POST['user_answers']){
    $user_answers = $_POST['user_answers'];
    
    echo json_encode(saveUserSurveyData($user_answers));
}else{
    echo json_encode('Попробуйте позже...');
}

function saveUserSurveyData($user_answers){
    session_start();
    require_once(get_theme_file_path('processing.php'));
    $db = new SafeMySQL();
    $user_id=$_SESSION['id'];
    $survey_id = $user_answers['id'];
    $survey_name = $user_answers['survey_name'];
    $user_result = $user_answers['user_result'];
    $checking_add_survey = $db->query("SELECT * FROM add_survey WHERE id=?i AND survey_name=?s", $survey_id, $survey_name);
    $checking_survey = $db->query("SELECT * FROM survey WHERE survey_id=?i AND survey_name=?s AND users_id=?i", $survey_id, $survey_name, $user_id);
    $answers = json_encode($user_result, JSON_FORCE_OBJECT);
    if($db->numRows($checking_add_survey) === 1){
        //Проверка на существование прохождения опроса юзером
        if( $db->numRows($checking_survey) > 1 ){
            if($db->query("UPDATE `survey`(`survey_id`,`survey_name`,`users_id`,`answers`) VALUES('$survey_id','$survey_name','$user_id','$answers') ")){
                $res['status']=1;
                $res['name']=$survey_name;
            }else{
                $res['status']=0;
                $res['err']="Что-то пошло не так";
            }
        }else{
            if($db->query("INSERT INTO `survey`(`survey_id`,`survey_name`,`users_id`,`answers`) VALUES('$survey_id','$survey_name','$user_id','$answers') ")){
                $res['status']=1;
                $res['name']=$survey_name;
            }else{
                $res['status']=0;
                $res['err']="Что-то пошло не так";
            }
        }
    }else{
        $res['status']=0;
        $res['err']="Что-то пошло не так";
    }
    return $res;
}

        function addSurvey($name,$questions){
            session_start();
            require_once(get_theme_file_path('processing.php'));
            $db = new SafeMySQL();
            $author_id=$_SESSION['id'];
            $check_name = $db->query("SELECT * FROM add_survey WHERE survey_name=?s", $name);
            $questions = json_encode($questions, JSON_FORCE_OBJECT);
            if($db->numRows($check_name) < 1){
                if($db->query("INSERT INTO `add_survey`( `survey_name`, `author_id`,`survey_questions`) VALUES('$name','$author_id','$questions') ")){
                    $res['status']=1;
                    $res['name']=$name;
                    $res['questions']=$questions;
                }else{
                    $res['status']=0;
                    $res['err']="Что-то пошло не так";
                }
            }else{
                $res['status']=0;
                $res['err']="Такой опрос уже существует";
            }
            return $res;
        };


?>