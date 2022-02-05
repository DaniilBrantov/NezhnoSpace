<?php
session_start();


if(!$_SESSION["user"]){
    header('Location: /auth');
}

require_once "connect.php";

$change_name=$_POST["change_name"];
$change_surname=$_POST["change_surname"];
$change_age=$_POST["change_age"];
//$change_mail=$_POST["change_mail"];
$change_sex=$_POST["change_sex"];
$id=$_SESSION['user']['id'];
$change_save=$_POST['change_save'];


if(isset($change_save)){
    mysqli_query($mysqli, "UPDATE `users` SET `name` = '$change_name', `surname` = '$change_surname', `age` = '$change_age', `sex` = '$change_sex' WHERE `users`.`id` = $id ");
    $sex_query=mysqli_query($mysqli, "SELECT * FROM `users`  WHERE `users`.`id` = $id ");
    if (mysqli_num_rows($sex_query)>0){
        $sex=mysqli_fetch_assoc($sex_query)["sex"];
    }
    if (isset ($change_name) && strlen($change_name)>2 && strlen($change_name)<15) {
        $change_name= ucwords($change_name);
        $_SESSION['user']['name']= $change_name;
    }else{header('Location: /my_account');}
    if (isset ($change_surname) && strlen($change_surname)>2 && strlen($change_surname)<15) {
        $change_surname= ucwords($change_surname);
        $_SESSION['user']['surname']= $change_surname;
    }else{header('Location: /my_account');}
    $_SESSION['user']['age']= $change_age;
    $_SESSION['user']['sex']= $change_sex;
    header('Location: /my_account');
}







?>
