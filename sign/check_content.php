<?php
    session_start();
    require_once( get_theme_file_path('processing.php') );

    $user_validation = new UserValidationErrors();
    $site_url=$url;
    $user_data=[
        'first_name' => filter_var(trim($_POST['first_name']), FILTER_SANITIZE_STRING),
        'mail' => $_POST['mail'],
        'pass' => $_POST['pass'],
        'pass_conf' => $_POST['pass_conf'],
        'checkbox' => $_POST['approval_check'],
        'token' => $_POST['token']
    ];

    $validation_rules = [
        'first_name' => 'getName',
        'pass_conf' => 'MatchingPasswords',
        'mail' => 'getCoincidenceUser',
        'pass' => 'getPassword',
    ];

    $errors = [];

    foreach ($validation_rules as $key => $rule) {
        // $result = $user_validation->$rule($$key);
        if( $key == 'pass_conf' ){
            $result = $user_validation->MatchingPasswords($user_data['pass'], $user_data['pass_conf']);
        }else{
            $result = $user_validation->$rule($user_data[$key]);
        }

        if ($result) {
            $errors[$key] = $result;
        }
    }
    if (!vb_reg_new_user()) {
        $errors['first_name'] = vb_reg_new_user();
    }
    

    if(empty($errors)){
        if(UserReg( $errors, $user_data )['status']){
            if($auth_curl = AuthcURL($user_data, $url)){
                $errors['status']=1;
            }else{ 
                $errors['mail']="Произошла ошибка. Попробуйте авторизоваться";
                $errors['status']=0;
            }
        }else{
            $errors['mail']=UserReg( $errors, $user_data )['err'];
            $errors['status']=0;
        }
    };
    // var_dump($errors);
    echo json_encode($errors);

    function UserReg( $errors, $user_data ){
        require_once( get_theme_file_path('processing.php') );
            $user_validation = new UserValidationErrors();
            $db = new SafeMySQL();
            if($check_token = $user_validation->getCheckTokens($user_data['mail'], $user_data['token'])){
                $name = $user_data['first_name'];
                $mail = $user_data['mail'];
                $hash_pass = password_hash($user_data['pass'], PASSWORD_DEFAULT);
                $reg_date = date("Y-m-d H:i:s");
                $activation=md5($mail.time());
                $status = $check_token['info']->status;
                $pay_choice = $check_token['info']->pay_choice;
                $res['status']=0;
                if( isset($user_data['token']) &&  !empty($user_data['token']) && $user_data['token']!=='null'){
                    if($check_token['status'] == 1){
                        $res['status']=$db->query("INSERT INTO `users`( `status`, `name`, `mail`, `password`, `pay_choice`, `user_registered`, `payment_date`, `created_payment`, `activation` ) VALUES('$status','$name','$mail','$hash_pass','$pay_choice','$reg_date','$reg_date','$reg_date','$activation') ");
                    }else{
                        $res['err']=$user_data['token'];
                    }
                }else{
                    // Сохраняем таблицу
                    $res['status']=$db->query("INSERT INTO `users`( `name`, `mail`, `password`, `user_registered`, `activation` ) VALUES('$name','$mail','$hash_pass','$reg_date','$activation') ");
                };
            }else{
                $res['err']='Не правильный токен! Убедитесь в правильности ссылки';
            }
        return $res;
    };


    function AuthcURL($user_data, $site_url){
        require_once( get_theme_file_path('processing.php') );
        session_start();

        //cURL запрос из auth. Автоматическая авторизация
        $mail=$user_data['mail'];
        $pass=$user_data['pass'];
        $postData = array(
            'auth' => true,
            'mail' => $mail,
            'pass' => $pass,
            'auth_btn' => true
        );

        $ch = curl_init($site_url.'/auth-check');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response=json_decode($response, true);
        extract($response);
        
        $_SESSION['id'] = $response['id'];

        if($response && $response!==NULL){
            return 1;
        }else{
            return $site_url;
        }
    };

    





    
    // $name=filter_var(trim($_POST['first_name']), FILTER_SANITIZE_STRING);
    // $mail=filter_var(trim(strtolower($_POST['mail'])), FILTER_SANITIZE_STRING);
    // $pass=$_POST['pass'];
    // $pass_conf=$_POST['pass_conf'];
    // $checkbox=$_POST['approval_check'];
    // $token=$_POST['token'];

    // if($user_validation->getName($name)){
    //     $errors['first_name']=$user_validation->getName($name);
    // }
    // if($user_validation->MatchingPasswords($pass, $pass_conf)){
    //     $errors['pass_conf']=$user_validation->MatchingPasswords($pass, $pass_conf);
    // }
    // if($user_validation->getCoincidenceUser($mail)){
    //     $errors['mail']=$user_validation->getCoincidenceUser($mail);
    // }
    // if($user_validation->getPassword($pass)){
    //     $errors['pass']=$user_validation->getPassword($pass);
    // }
    // if(!vb_reg_new_user()){
    //     $errors['first_name']=vb_reg_new_user();
    // }


    // $_POST['first_name']='dsf';
    // $_POST['mail']='dan2@mail.ru';
    // $_POST['pass']='daniilbrantov2004BR';
    // $_POST['pass_conf']=$_POST['pass'];




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