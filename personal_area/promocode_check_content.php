<?php
session_start();
require_once "connect.php";
$email= $_SESSION['user']['mail'];


$promocode=$_POST["promocode"];
$user_tel=$_POST["user_tel"];
if($promocode && $user_tel){
    if($promocode==""){
        $response= [
            "status" => false,
            "type"=> 1,
            "message" => "Введите промокод",
            "fields"=> "promocode"
        ];

        echo json_encode($response);
    };
    if($user_tel==""){
        $response= [
            "status" => false,
            "type"=> 2,
        ];

        echo json_encode($response);
    };
    $code="НЕТОЛОГИЯ";
    if($promocode==$code){
        mysqli_query($mysqli,"UPDATE `users` SET `payment`='3',`telephone`='$user_tel' WHERE `mail`='$email'");
        $_SESSION["user"]["payment"]='3';
        $response= [
            "status" => true,
        ];

        echo json_encode($response);
    }else{
        $response= [
            "status" => false,
            "type"=> 1,
            "message" => "Такого промокода не существует",
            "fields"=> "promocode"
        ];

        echo json_encode($response);
    }
}else{
}

?>