<?php
// session_start();
// ob_start();
require_once 'connect.php';

    $nname=$_POST['nname'];
    //$surname=$_POST['surname'];
    $mail=strtolower($_POST['mail']);;
    $pass=$_POST['pass'];
    $pass_conf=$_POST['pass_conf'];
    $checkbox=$_POST['reg_checkbox'];

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

    if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,25}$/', $pass)) {
        $error_fields[]= "pass";
        $msg= "Пароль должен содержать не менее восьми знаков, включать буквы и цифры";
      }

    if(!$pass){
      $error_fields[]= "pass";
      $msg= "Введите пароль";
    }
    

    // if ($mail === "" && !filter_var((string) $mail, FILTER_VALIDATE_EMAIL)){
    //     $error_fields[]= "mail";
    //     $msg= "E-mail указан не корректно!";
    // }

    if (isset($mail)) {
      $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);
      if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $error_fields[]= "mail";
        $msg= "E-mail указан не корректно!";
      }
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



      $user_name=@trim(stripslashes($mail));

      $name       =$user_name ;
      $from       = "EatIntelligent";
      $subject    ="Регистрация на EatIntelligent";
      $message    ="Вы Успешно Зарегистрировались на нашем сайте EatIntelligent.";
      $to         = $user_name;
    
      $headers = "MIME-Version: 1.0";
      $headers .= "Content-type: text/plain; charset=UTF-8";
      $headers .= "From: {$name} <{$from}>";
      $headers .= "Reply-To: <{$from}>";
      $headers .= "Subject: {$subject}";
      $headers .= "X-Mailer: PHP/".phpversion();
    
      $success=mail($to, $subject, $message,$headers);
    


    


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