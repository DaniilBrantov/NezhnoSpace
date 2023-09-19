<?php
session_start();
require_once "connect.php";
if (!$_SESSION['user'] && $_SESSION['user']['payment']!==2) {
    header('Location: auth');
}
$survey_value=$_POST['survey_value'];
$less_num=$_POST['less_num'];
$users_id=$_SESSION['user']['id'];
if($_POST['rating']){
    $rating_star=$_POST['rating'];
    $rating_id=$_POST['id'];
    echo $rating_id;
    mysqli_query($mysqli,"UPDATE `users_individ_content` SET `rating_for_us` = '$rating_star' WHERE `users_individ_content`.`id_users` = '$users_id' AND `users_individ_content`.`less_number` = '$rating_id'"  );
}
if($survey_value && $less_num){
    $survey_array = serialize(explode('^', $survey_value));
    mysqli_query($mysqli,"INSERT INTO `survey` (`id`,`users_id`, `less_num`,`answers`) VALUES (NULL, '$users_id', '$less_num','$survey_array') ");
    header('Location: lesson?id='.$less_num);
}

?>