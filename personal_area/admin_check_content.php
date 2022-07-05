<?php

require_once "connect.php";
$admin_gmail = "qqqqqq";
$admin_pass = "qqqqqq";

$gmail=$_POST['gmail'];
$password=$_POST['password'];

if($admin_gmail === $gmail && $admin_pass === $password){

    $_SESSION["admin"]=[
        "mail"=>$gmail,
        "pass"=>$password
    ];

    header('Location: /admin');
}else{
    if($_POST["publication_status"]){
        $publication=$_POST["publication_status"];
        $id_users=$_POST["publication_btn_val"][0];
        $less_num=$_POST["publication_btn_val"][1];
        mysqli_query($mysqli,"UPDATE `users_individ_content` SET `publication`='$publication' WHERE `id_users` = '$id_users' AND `less_number` = '$less_num' ");
    }else{
        header('Location: /auth');
    } 
    
};







?>