<?php
    //session_start();
    require_once( get_theme_file_path('processing.php') );
    $name=filter_var(trim($_POST['first_name']), FILTER_SANITIZE_STRING);
    $mail=filter_var(trim(strtolower($_POST['mail'])), FILTER_SANITIZE_STRING);
    $pass=filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);
    $pass_conf=$_POST['pass_conf'];
    $checkbox=$_POST['approval_check'];







    // Создаем массив для сбора ошибок
    $errors=[];

    //Name
    if($name == '') {$errors['first_name'] = "Введите Имя";}
    elseif (mb_strlen($name) < 3 || mb_strlen($name) > 50){$errors['first_name'] = "Недопустимая длина имени";}
    
    //Email
    if($mail == '') {$errors['mail'] = "Введите Email";}

    //Валидация email
    elseif (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $mail)) {$errors['mail'] = 'Неверно введен е-mail';}
    
    //Проверка на уникальность email
    elseif($check_user=$db->query("SELECT mail FROM users WHERE mail=?s", $mail)){
      if($db->numRows($check_user)>0){
        $errors['mail'] = 'Такой пользователь уже существует';
      }
    }

    //Password
    if($pass == '') {$errors['pass'] = "Введите пароль";}
    
    //Совпадение паролей
    elseif($pass != $pass_conf) {$errors['pass'] = "Повторный пароль введен не верно!";}
    
    //Недопустимая длина
    elseif (mb_strlen($pass) < 8){$errors['pass'] = "Недопустимая длина пароля";}

    //Проверка пароля
    elseif(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,}$/', $pass)){
      $errors['pass'] = "Слабый пароль";
    }




    if(empty($errors)) {
      // Хешируем пароль
      $hash_pass = password_hash($pass, PASSWORD_DEFAULT);
  
      // Сохраняем таблицу
      //$db->rawQuery("INSERT INTO `users`( `name`, `mail`, `password`) VALUES('$name','$mail','$hash_pass') ");
      $errors['status']=true;
    } else {
      //Возвращать все ошибки
      $errors['status']=false;
    };
    echo json_encode($errors);







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

//Не обращать внимания
  //     if($order){
  //       $mysqli->query("INSERT INTO `users`( `name`, `surname`, `mail`, `password`, `payment`) VALUES('$nname','$surname','$mail','$pass','$order') ");
  //     }else{
  //       $mysqli->query("INSERT INTO `users`( `name`, `surname`, `mail`, `password`) VALUES('$nname','$surname','$mail','$pass') ");
  //     };


  //  Код для отправки mail сообщения или его импорт
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