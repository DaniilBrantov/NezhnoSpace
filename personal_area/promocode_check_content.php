<?php
session_start();
CheckAuth();
require_once( get_theme_file_path('processing.php') );


if($email = $db->getOne("SELECT mail FROM users WHERE id=?i", $_SESSION['id'])){
    if($promocode=$_POST["promocode"] && !empty($_POST["promocode"]) && isset($_POST["promocode"]) && $_POST["promocode"] !== NULL && $_POST["promocode"]!==""){
        
        
    }else{
        $response=[
            "status" => false,
            "message" => "Введите промокод",
        ];
    }
}else{
    $response=[
        "status" => false,
        "message" => "Произошла неизвестная ошибка",
    ];
}


if($promocode && $user_tel){
    if($promocode==""){
        $response= [
            "status" => false,
            "message" => "Введите промокод",
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