<?php
/**
* Template Name: add_survey_check
*

*/
// session_start();
// require_once(get_theme_file_path('processing.php'));




        $survey=$_POST['survey'];
        $name=$survey['name'];
        $questions=$survey['questions'];
        $res=[];
        function addSurvey($name,$questions){
            session_start();
            require_once(get_theme_file_path('processing.php'));
            $db = new SafeMySQL();
            $author_id=$_SESSION['id'];
            $check_name = $db->query("SELECT * FROM add_survey WHERE survey_name=?s", $name);
            if($db->numRows($check_name) < 1){
                if($db->query("INSERT INTO `add_survey`( `survey_name`, `author_id`,`survey_questions`) VALUES('$name','$author_id','$questions') ")){
                    $res['status']=1;
                    $res['name']=$name;
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
        echo json_encode(addSurvey($name,$questions));


?>