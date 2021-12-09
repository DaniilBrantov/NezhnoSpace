<?php
// session_start();
// ob_start();
require_once 'connect.php';

    $nname=$_POST['nname'];
    $surname=$_POST['surname'];
    $mail=$_POST['mail'];
    $pass=$_POST['pass'];
    $pass_conf=$_POST['pass_conf'];

    $check_user=mysqli_query($mysqli, "SELECT * FROM `users` WHERE `mail` = '$mail'");
    
    if (mysqli_num_rows($check_user)>0){
      $response=[
        "status"=> false,
        "type"=> 1,
        "message"=> "Такой пользователь уже существует.",
        "fields"=>['mail']
    ];
    echo json_encode($response);

    die();
    }

    $error_fields=[];

    if($pass=== ""){
      $error_fields[]= "pass";
      $msg= "Введите пароль";
  }

    if ($mail === "" && !filter_var($mail,FILTER_VALIDATE_EMAIL)){
        $error_fields[]= "mail";
        $msg= "E-mail указан не корректно!";
    }

    if(strlen($surname) < 2){
        $error_fields[]= "surname";
        $msg= "Укажите свою фамилию!";
    }

    if (strlen($nname) < 2){
      $error_fields[]= "nname";
      $msg= "Укажите своё имя!";
  }


  if(!empty($error_fields)){

    $response=[
        "status"=> false,
        "type"=> 1,
        "message"=> $msg,
        "fields"=>$error_fields
    ];
    

    echo json_encode($response);

    die();
};




    if (strlen($pass) > 7 && !preg_match("[aA-zZ0-9]",$pass)) {

      $pass= md5($pass."lksd4fvm879");

      $mysqli->query("INSERT INTO `users`( `name`, `surname`, `mail`, `password`) VALUES('$nname','$surname','$mail','$pass') ");



      $user_name=@trim(stripslashes($_SESSION["user"]["mail"]));

    $name       =$user_name ;
    $from       = "EatIntelligent";
    $subject    ="EatIntelligent";
    $message = "{$user_name}\nЗдравствуйте!\n Вы успешно зарегистрировались на сайте: https://eatintelligent.ru/";
    $to= "daniil.brantov04@mail.ru" ;

    $headers = "MIME-Version: 1.0";
    $headers .= "Content-type: application/javascript;charset=utf-8";
    $headers .= "From: {$name} <{$from}>";
    $headers .= "Subject: {$subject}";
    $headers .= "X-Mailer: PHP/".phpversion();

    mail($to, $subject, $message,$headers);


      $response=[
        "status"=> true,
        "message"=> "Регистрация прошла успешно!",
      ];

      echo json_encode($response);

      //$mysqli->close();

    } else {
      $response=[
        "status"=> false,
        "message"=> "Пароль должен содержать не менее восьми знаков, включать буквы, цифры и специальные символы",
      ];

      echo json_encode($response);
    }
?>