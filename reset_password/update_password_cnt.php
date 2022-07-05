<?php
    session_start();
    require_once("wp-content/themes/my-theme/personal_area/connect.php");

    if(isset($_POST["set_new_password"]) && !empty($_POST["set_new_password"])){
        
        if(isset($_POST['token']) && !empty($_POST['token'])){
            $token = $_POST['token'];
        }else{
            $_SESSION["error_messages"] = "<p class='mesage_error' ><strong>Ошибка!</strong> Отсутствует проверочный код ( Передаётся скрытно ).</p>";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$address_site."set_new_password?email=$email&token=$token");
            exit();
        }
        if(isset($_POST['email']) && !empty($_POST['email'])){
            $email = $_POST['email'];
        }else{
            $_SESSION["error_messages"] = "<p class='mesage_error' ><strong>Ошибка!</strong> Отсутствует адрес электронной почты ( Передаётся скрытно ).</p>";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$address_site."set_new_password?email=$email&token=$token");
            exit();
        }
        if(isset($_POST["password"])){
            //Обрезаем пробелы с начала и с конца строки
            $password = trim($_POST["password"]);
            //Проверяем, совпадают ли пароли
            if(isset($_POST["confirm_password"])){
                //Обрезаем пробелы с начала и с конца строки
                $confirm_password = trim($_POST["confirm_password"]);
                if($confirm_password != $password){
                    $_SESSION["error_messages"] = "<p class='mesage_error' >Пароли не совпадают</p>";
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: ".$address_site."set_new_password?email=$email&token=$token");
                    exit();
                }
            }else{
                $_SESSION["error_messages"] = "<p class='mesage_error' >Отсутствует поле для повторения пароля</p>";
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."set_new_password?email=$email&token=$token");
                exit();
            }
            if(!empty($password)){
                $password = htmlspecialchars($password, ENT_QUOTES);
                $password = md5($password."lksd4fvm879"); 
            }else{
                $_SESSION["error_messages"] = "<p class='mesage_error' >Пароль не может быть пустым</p>";
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."set_new_password?email=$email&token=$token");
                exit();
            }
        }else{
            $_SESSION["error_messages"] = "<p class='mesage_error' >Отсутствует поле для ввода пароля</p>";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$address_site."set_new_password?email=$email&token=$token");
            exit();
        }
        
        $query_update_password = $mysqli->query("UPDATE `users` SET `password`='$password' WHERE `mail`='$email'");
        if(!$query_update_password){
            $_SESSION["error_messages"] = "<p class='mesage_error' >Возникла ошибка при изменении пароля.</p><p><strong>Описание ошибки</strong>: ".$mysqli->error."</p>";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$address_site."set_new_password?email=$email&token=$token");
            exit();
        }else{
            echo '
                <div class="wrapper_subscription_lesson">
                    <div class="subscription_lesson">
                        <h1>Пароль успешно изменён!</h1>
                        <a href="auth" class="auth_link">Войти</a>
                    </div>

                </div>
            ';
            
        }
    }else{
        exit("<p><strong>Ошибка!</strong> Вы зашли на эту страницу напрямую, поэтому нет данных для обработки. Вы можете перейти на <a href=".$address_site."> главную страницу </a>.</p>");
    }
?>