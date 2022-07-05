<?php
    session_start();
    require_once "wp-content/themes/my-theme/personal_area/connect.php";

    $_SESSION["error_messages"] = '';
    $_SESSION["success_messages"] = '';

if(isset($_POST["reset_send"])){
        if(isset($_POST["reset_email"])){
            $email = trim($_POST["reset_email"]);
            if(!empty($email)){
                $email = htmlspecialchars($email, ENT_QUOTES);
                $reg_email = "/^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i";
                if( !preg_match($reg_email, $email)){
                    $_SESSION["error_messages"] = "<p class='mesage_error' >Вы ввели неправильный email</p>";
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: ".$address_site."reset_password");
                    exit();
                }
            }else{
                $_SESSION["error_messages"] = "<p class='mesage_error' > <strong>Ошибка!</strong> Поле для ввода почтового адреса(email) не должна быть пустой.</p>";
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."reset_password");
                exit();
            }
        }else{
            $_SESSION["error_messages"] = "<p class='mesage_error' > <strong>Ошибка!</strong> Отсутствует поле для ввода Email</p>";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$address_site."reset_password");
            exit();
        }



        $result_query_select = $mysqli->query("SELECT mail FROM `users` WHERE mail = '".$email."'");
        
        if(!$result_query_select){
            $_SESSION["error_messages"] = "<p class='mesage_error' > Ошибка запроса на выборки пользователя из БД</p>";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$address_site."reset_password");
            exit();
        }else{
            if($result_query_select->num_rows == 1){
                while(($row = $result_query_select->fetch_assoc()) !=false){

                    $token=md5($email.time());
                    $query_update_token = $mysqli->query("UPDATE users SET reset_pass_token = '$token' WHERE mail='$email'");
                    if(!$query_update_token){
                        $_SESSION["error_messages"] = "<p class='mesage_error' >Ошибка сохранения токена</p><p><strong>Описание ошибки</strong>: ".$mysqli->error."</p>";
                        header("HTTP/1.1 301 Moved Permanently");
                        header("Location: ".$address_site."reset_password");
                        exit();
                    }else{
                        $link_reset_password = $address_site."set_new_password?email=$email&token=$token";

                        $send_email = new \PHPMailer\PHPMailer\PHPMailer();
                        $send_email->CharSet = 'utf-8';
                        $send_email->isSMTP();
                        $send_email->Host = 'smtp.yandex.ru';
                        $send_email->SMTPAuth = true;                              
                        $send_email->Username = 'support@eatintelligent.ru'; 
                        $send_email->Password = 'Eat123Intelligent123';
                        $send_email->SMTPSecure = 'ssl';
                        $send_email->Port = 465; 
                        $send_email->setFrom('support@eatintelligent.ru');
                        $send_email->addAddress($email);    
                        $send_email->isHTML(true);                                 
                        $send_email->Subject = 'Нежно: восстановление пароля ';

                        $send_email->Body    =  '
                            <div class="send_mail" style="
                                background: #111;
                                color: #D7D7D7;
                                border-radius: 30px;
                                padding: 30px 60px;
                                margin: 20px;
                                font-size: 20px;
                            ">
                                <div class="send_mail_title">
                                    <h1>
                                        Чао Белла! 
                                    </h1>
                                </div>
                                <div class="send_mail_txt">
                                    <p>
                                        Ты можешь установить новый пароль для платформы <a style="color: whitesmoke;" href="https://'.$_SERVER['HTTP_HOST'].'">Нежно</a> . 
                                    </p>
                                    <p>
                                        Ждём тебя по этой <a style="color: whitesmoke;" href="'.$link_reset_password.'">ссылке</a> .
                                    </p>
                                </div>
                            </div>
                        ';
                        $send_email->AltBody = '';


                        if($send_email->send()) {
                            $_SESSION["success_messages"] = "<p class='success_message' >Ссылка на страницу установки нового пароля, была отправлена на указанный E-mail ($email) </p>";
                            header("HTTP/1.1 301 Moved Permanently");
                            header("Location: ".$address_site."reset_password");
                            exit();
                        }else{
                            $_SESSION["error_messages"] = "<p class='mesage_error' >Ошибка при отправлении письма на почту ".$email.", с сылкой на страницу установки нового пароля. </p>";
                            header("HTTP/1.1 301 Moved Permanently");
                            header("Location: ".$address_site."reset_password");
                            exit();
                        }
                    }
                } // End while
            }else{
                $_SESSION["error_messages"] = "<p class='mesage_error' ><strong>Ошибка!</strong> Такой пользователь не зарегистрирован</p>";
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."reset_password");
                exit();
            }
        }
}else{
    exit("<p><strong>Ошибка!</strong> Вы зашли на эту страницу напрямую, поэтому нет данных для обработки. Вы можете перейти на <a href=".$address_site."> главную страницу </a>.</p>");
}
?>