<?php
    session_start();
    require_once( get_theme_file_path('processing.php') );
    $nname=$_POST['first_name'];
    $mail=strtolower($_POST['mail']);;
    $pass=$_POST['pass'];
    $pass_conf=$_POST['pass_conf'];
    $checkbox=$_POST['approval_check'];

    if($check_user=$db->query("SELECT mail FROM users WHERE mail=?s", $mail)){
      if($db->numRows($check_user)>0){
        $response=[
                "status"=> false,
                "message"=> "Такой пользователь уже существует.",
                "fields"=>['mail']
            ];
            echo json_encode($response);
      }else{
        $status=true;
        $response=[
          //"status"=> $status,
          "message"=> "Такой пользователь НЕ существует.",
          "fields"=>['mail']
        ];
        echo json_encode($response);
      }
    }









    //$check_user=mysqli_query($mysqli, "SELECT * FROM `users` WHERE `mail` = '$mail'");
    
  //   if (mysqli_num_rows($check_user)>0){
  //     $response=[
  //       "status"=> false,
  //       "type"=> 1,
  //       "message"=> "Такой пользователь уже существует.",
  //       "fields"=>['mail']
  //   ];
  //   echo json_encode($response);

  //   die();
  //   }

  //   $error_fields=[];

  //   if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,25}$/', $pass)) {
  //       $error_fields[]= "pass";
  //       $msg= "Пароль должен содержать не менее восьми знаков, включать буквы и цифры";
  //     }

  //   if(!$pass){
  //     $error_fields[]= "pass";
  //     $msg= "Введите пароль";
  //   }
    

  //   if (isset($mail)) {
  //     $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);
  //     if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
  //       $error_fields[]= "mail";
  //       $msg= "E-mail указан не корректно!";
  //     }
  //   }

  //   if (strlen($nname) < 2){
  //     $error_fields[]= "nname";
  //     $msg= "Укажите своё имя!";
  // }



  // if(!empty($error_fields)){

  //   $response=[
  //       "status"=> false,
  //       "type"=> 1,
  //       "message"=> $msg,
  //       "fields"=>$error_fields
  //   ];
    

  //   echo json_encode($response);

  //   die();
  // };




  //   if (strlen($pass) > 7 && !preg_match("[aA-zZ0-9]",$pass)) {

  //     $pass= md5($pass."lksd4fvm879");


  //     if($order){
  //       $mysqli->query("INSERT INTO `users`( `name`, `surname`, `mail`, `password`, `payment`) VALUES('$nname','$surname','$mail','$pass','$order') ");
  //     }else{
  //       $mysqli->query("INSERT INTO `users`( `name`, `surname`, `mail`, `password`) VALUES('$nname','$surname','$mail','$pass') ");
  //     };


  //   //Код для отправки mail сообщения или его импорт
  //     if(!$email->send()) {
  //       echo 'Error';
  //   } else {
  //               $response=[
  //           "status"=> true,
  //           "message"=> "Регистрация прошла успешно!",
  //         ];

  //         echo json_encode($response);

  //         //$mysqli->close();

  //   }


  //   } else {
  //     $response=[
  //       "status"=> false,
  //       "message"=> "Пароль должен содержать не менее восьми знаков, включать буквы, цифры и специальные символы",
  //     ];

  //     echo json_encode($response);
  //   }
?>