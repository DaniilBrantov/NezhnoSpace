<?php
    //session_start();
    require_once( get_theme_file_path('processing.php') );
    $name=filter_var(trim($_POST['first_name']), FILTER_SANITIZE_STRING);
    $mail=filter_var(trim(strtolower($_POST['mail'])), FILTER_SANITIZE_STRING);
    $pass=$_POST['pass'];
    $pass_conf=$_POST['pass_conf'];
    $checkbox=$_POST['approval_check'];



    $name="ashdashd";
    $mail="qasffe@sdf.ruswewn";
    $pass="12345fhgdsDFG";
    $pass_conf="12345fhgdsDFG";


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
  
      // Сохраняем таблицу
      //$db->query("INSERT INTO `users`( `name`, `mail`, `password`) VALUES('$name','$mail','$hash_pass') ");
      $errors['status']=true;

    } else {
      //Возвращать все ошибки
      $errors['status']=false;
    };
    if($errors['status'] && authLogin($url . "/auth-check", $mail, $pass)){
      echo $_SESSION['id'];
    }else{
      echo json_encode($errors);
    }



    function authLogin($url,$mail,$pass){
      $ch = curl_init();
      if(strtolower((substr($url,0,5))=='https')) { // если соединяемся с https
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      }
      curl_setopt($ch, CURLOPT_URL, $url);
      // откуда пришли на эту страницу
      curl_setopt($ch, CURLOPT_REFERER, $url);
      //cURL будет выводить подробные сообщения о всех производимых действиях
      curl_setopt($ch, CURLOPT_VERBOSE, 0);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS,"auth_btn=true&mail=".$mail."&pass=".$pass);
      curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
      //сохранять полученные COOKIE в файл
      curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookies.txt');
      $result=curl_exec($ch);
      // Убеждаемся что произошло перенаправление после авторизации
      //if(strpos($result,"Location: account")===true) die('Login incorrect');
      curl_close($ch);
      return $result;
  }

?>