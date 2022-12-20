<?php
    session_start();
    require_once( get_theme_file_path('processing.php') );

    

    // $_POST['first_name']='dsfghjhghgf';
    // $_POST['mail']='hdqqwgf@dgh.fg';
    // $_POST['pass']='aasdasd1223';
    // $_POST['pass_conf']='aasdasd1223';

    $name=filter_var(trim($_POST['first_name']), FILTER_SANITIZE_STRING);
    $mail=filter_var(trim(strtolower($_POST['mail'])), FILTER_SANITIZE_STRING);
    $pass=$_POST['pass'];
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
    elseif($pass != $pass_conf) {$errors['pass_conf'] = "Повторный пароль введен не верно!";}
    
    //Недопустимая длина
    elseif (mb_strlen($pass) < 8){$errors['pass'] = "Недопустимая длина пароля";}

    //Проверка пароля
    elseif(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,}$/', $pass)){
      $errors['pass'] = "Слабый пароль";
    }


    if(empty($errors)) {
      // Хешируем пароль
      $hash_pass = password_hash($pass, PASSWORD_DEFAULT);
      $activation=md5($mail.time());
      $reg_date = time(); 
  
      // Сохраняем таблицу
      $db->query("INSERT INTO `users`( `name`, `mail`, `password`,`user_registered`,`activation`) VALUES('$name','$mail','$hash_pass','$reg_date','$activation') ");

      $errors['status']=true;
      // $errors['go_mail']=$msg;

    } else {
      //Возвращать все ошибки
      $errors['status']=false;
    };
    
    if($errors['status']){
      //cURL запрос из auth. Автоматическая авторизация
      $postData = array(
        'auth' => true,
        'mail' => $mail,
        'pass' => $pass,
        'auth_btn' => true
      );
      $ch = curl_init($url.'/auth-check');
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);
      curl_close($ch);
      $response=json_decode($response, true);
      extract($response);
      $_SESSION['id']=$response['id'];
      if(!$_SESSION['id']){
        $errors['status']=false;
      }else{
        echo json_encode($errors);
      }
    }else{
      echo json_encode($errors);
    }

?>