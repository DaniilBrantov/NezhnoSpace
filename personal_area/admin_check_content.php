<?php


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
    header('Location: /auth');
}







?>