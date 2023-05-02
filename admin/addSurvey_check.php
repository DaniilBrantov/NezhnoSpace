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
}elseif($_POST['user_result']){
    $user_result = $_POST['user_result'];
    echo json_encode(saveUserSurveyData($user_result));
}

function saveUserSurveyData($user_result){
    session_start();
    require_once(get_theme_file_path('processing.php'));
    $db = new SafeMySQL();
    $user_id=$_SESSION['id'];
    $checking = $db->query("SELECT * FROM add_survey WHERE survey_questions=?s", $user_result);
    $questions = json_encode($user_result, JSON_FORCE_OBJECT);
            if($db->numRows($checking) === 1){
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