<?php
session_start();
require_once "connect.php";
if(!isset($_POST["send"])){
    exit("<p><strong>Ошибка!</strong> Вы зашли на эту страницу напрямую, поэтому нет данных для обработки. Вы можете перейти на <a href=".$address_site."> главную страницу </a>.</p>");
};
        $_SESSION["error_messages"] = '';
        $_SESSION["success_messages"] = '';





if(isset($_POST["email"])){
    $email = trim($_POST["email"]);
    if(!empty($email)){
        $email = htmlspecialchars($email, ENT_QUOTES);
        $reg_email = "/^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i";
        if( !preg_match($reg_email, $email)){
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: auth");
            exit();
        }
    }else{
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: reset_password");
        exit();
    }
}else{
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: reset_password");
    exit();
}



$result_query_select = mysqli_query($mysqli,"SELECT `mail` FROM `users` WHERE `mail` = '$email' ");
if(!$result_query_select){
    $_SESSION["error_messages"] = "Ошибка запроса на выборки пользователя из БД";
    header("HTTP/1.1 301 Moved Permanently");
    //header("Location: reset_password");
    exit();
}else{
    if($result_query_select->num_rows == 1){
        while(($row = $result_query_select->fetch_assoc()) !=false){
            $token=md5($email.time());
            $query_update_token = mysqli_query($mysqli,"UPDATE `users` SET `reset_pass_token`='$token' WHERE `mail`='$email'");
            if(!$query_update_token){
                $_SESSION["error_messages"] = "Ошибка сохранения токена.Описание ошибки: ".$mysqli->error."</p>";
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: reset_password");
                exit();
            }else{
                $link_reset_password = "set_new_password?email=$email&token=$token";
                $subject = "Восстановление пароля от сайта ".$_SERVER['HTTP_HOST'];
                $subject = "=?utf-8?B?".base64_encode($subject)."?=";
                $message = 'Здравствуйте! <br/> <br/> Для восстановления пароля от сайта <a href="http://'.$_SERVER['HTTP_HOST'].'"> '.$_SERVER['HTTP_HOST'].' </a>, перейдите по этой <a href="'.$link_reset_password.'">ссылке</a>.';
                $headers = "FROM: $email_admin\r\nReply-to: EatIntelligent \r\nContent-type: text/html; charset=utf-8\r\n";
                if(mail($email, $subject, $message, $headers)){
                    $_SESSION["success_messages"] = "<p class='success_message' >Ссылка на страницу установки нового пароля, была отправлена на указанный E-mail ($email) </p>";
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: reset_password");
                    exit();
                }else{
                    $_SESSION["error_messages"] = "Ошибка при отправлении письма на почту ".$email.", с сылкой на страницу установки нового пароля.";
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: reset_password");
                    exit();
                }
            }



        }
    }else{
        $_SESSION["error_messages"] = "Ошибка! Такой пользователь не зарегистрирован";
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: reset_password");
        exit();
    }
}
?>