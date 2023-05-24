<?php
    //session_start();
    require_once( get_theme_file_path('processing.php') );
    session_start();
    
    $name=filter_var(trim($_POST['first_name']), FILTER_SANITIZE_STRING);
    $mail=filter_var(trim(strtolower($_POST['mail'])), FILTER_SANITIZE_STRING);
    $pass=$_POST['pass'];
    $pass_conf=$_POST['pass_conf'];
    $checkbox=$_POST['approval_check'];
    $token=$_POST['token'];

$user_validation = new UserValidationErrors();
$errors=[];

if($user_validation->getName($name)){
    $errors['first_name']=$user_validation->getName($name);
}
if($user_validation->MatchingPasswords($pass, $pass_conf)){
    $errors['pass_conf']=$user_validation->MatchingPasswords($pass, $pass_conf);
}
if($user_validation->getCoincidenceUser($mail)){
    $errors['mail']=$user_validation->getCoincidenceUser($mail);
}
if($user_validation->getPassword($pass)){
    $errors['pass']=$user_validation->getPassword($pass);
}
if(!vb_reg_new_user()){
    $errors['first_name']=vb_reg_new_user();
}



if(empty($errors)){
    // Хешируем пароль
    $hash_pass = password_hash($pass, PASSWORD_DEFAULT);
    $activation=md5($mail.time());
    $reg_date = date("Y-m-d H:i:s");    

    // Проверка наличия статуса у пользователя
    $check_token = $user_validation->getCheckTokens($mail, $token);
    // $check_token = $user_validation->getCheckTokens('daniil.brantov04@mail.rq', '5LjUSkuxrY');
    if( isset($token) ){
        $errors['mail']=$check_token;
        if($check_token['status'] == 0){
            $errors['mail']=$check_token['msg'];
        }elseif($check_token['status'] == 1){
            // Сохраняем таблицу
            $status = $check_token['info']->status;
            $pay_choice = $check_token['info']->pay_choice;
            $db->query("INSERT INTO `users`( `status`, `name`, `mail`, `password`, `pay_choice`, `user_registered`, `activation` ) VALUES('$status','$name','$mail','$hash_pass','$pay_choice','$reg_date','$activation') ");
        }
    }else{
        // Сохраняем таблицу
        $db->query("INSERT INTO `users`(`name`, `mail`, `password`,`user_registered`,`activation`) VALUES('$name','$mail','$hash_pass','$reg_date','$activation') ");
    }

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
    if($_SESSION['id'] && $_SESSION['id']!== NULL){
        $errors['status']=true;
    }else{
        $errors['status']=false;
        $errors['mail']='Произошла неизвестная ошибка. Попробуйте позже';
    }
}else{
    $errors['status']=false;
    $errors['mail']='Произошла неизвестная ошибка';

};
echo json_encode($errors);








    // // Создаем массив для сбора ошибок
    // $errors=[];

    
    // //Email
    // if($mail == '') {$errors['mail'] = "Введите Email";}

    // //Валидация email
    // elseif (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $mail)) {$errors['mail'] = 'Неверно введен е-mail';}
    
    // //Проверка на уникальность email
    // elseif($check_user=$db->query("SELECT mail FROM users WHERE mail=?s", $mail)){
    //   if($db->numRows($check_user)>0){
    //     $errors['mail'] = 'Такой пользователь уже существует';
    //   }
    // }

    // //Password
    // if($pass == '') {$errors['pass'] = "Введите пароль";}
    
    // //Совпадение паролей
    // elseif($pass != $pass_conf) {$errors['pass_conf'] = "Повторный пароль введен не верно!";}
    
    // //Недопустимая длина
    // elseif (mb_strlen($pass) < 8){$errors['pass'] = "Недопустимая длина пароля";}

    // //Проверка пароля
    // elseif(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,}$/', $pass)){
    //   $errors['pass'] = "Слабый пароль";
    // }


    // if(empty($errors)) {
    //   // Хешируем пароль
    //   $hash_pass = password_hash($pass, PASSWORD_DEFAULT);
    //   $activation=md5($mail.time());
    //   $reg_date = date(); 
  
    //   // Сохраняем таблицу
    //   $db->query("INSERT INTO `users`( `name`, `mail`, `password`,`user_registered`,`activation`) VALUES('$name','$mail','$hash_pass','$reg_date','$activation') ");

    //   $errors['status']=true;
    //   // $errors['go_mail']=$msg;

    // } else {
    //   //Возвращать все ошибки
    //   $errors['status']=false;
    // };
    
    // if($errors['status']){
    //   //cURL запрос из auth. Автоматическая авторизация
    //   $postData = array(
    //     'auth' => true,
    //     'mail' => $mail,
    //     'pass' => $pass,
    //     'auth_btn' => true
    //   );
    //   $ch = curl_init($url.'/auth-check');
    //   curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //   $response = curl_exec($ch);
    //   curl_close($ch);
    //   $response=json_decode($response, true);
    //   extract($response);
    //   $_SESSION['id']=$response['id'];
    //   if(!$_SESSION['id'] || $_SESSION['id']== NULL){
    //     $errors['status']=false;
    //   }else{
    //     echo json_encode($errors);
    //   }
    // }else{
    //   echo json_encode($errors);
    // }

?>