<?php
session_start();
require_once "connect.php";
if (!$_SESSION['user'] && $_SESSION['user']['payment']!==2) {
    header('Location: auth');
}
$survey_value=$_POST['survey_value'];
$less_num=$_POST['less_num'];
$users_id=$_SESSION['user']['id'];
if($survey_value && $less_num){
    $survey_array = serialize(explode('^', $survey_value));
    mysqli_query($mysqli,"INSERT INTO `survey` (`id`,`users_id`, `less_num`,`answers`) VALUES (NULL, '$users_id', '$less_num','$survey_array') ");
    header('Location: lesson?id='.$less_num);
}

?>