<?php 
require_once("wp-content/themes/my-theme/personal_area/connect.php");
if(isset($_GET['token']) && !empty($_GET['token'])){
    $token = $_GET['token'];
}else{
    exit("<p><strong>Ошибка!</strong> Отсутствует проверочный код.</p>");
}
if(isset($_GET['email']) && !empty($_GET['email'])){
    $email = $_GET['email'];
}else{
    exit("<p><strong>Ошибка!</strong> Отсутствует адрес электронной почты.</p>");
}
$query_select_user = $mysqli->query("SELECT reset_pass_token FROM `users` WHERE `mail` = '".$email."'");

if(($row = $query_select_user->fetch_assoc()) != false){
    if($query_select_user->num_rows == 1){
        if($token == $row['reset_pass_token']){
            ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    "use strict";
                    var password = $('input[name=password]');
                    var confirm_password = $('input[name=confirm_password]');
                    password.blur(function(){
                        if(password.val() != ''){
                            if(password.val().length < 7){
                                $('#valid_password_message').text('Минимальная длина пароля 6 символов');
                                //проверяем, если пароли не совпадают, то выводим сообщение об ошибке
                                if(password.val() !== confirm_password.val()){
                                    $('#valid_confirm_password_message').text('Пароли не совпадают');
                                }
                                $('input[type=submit]').attr('disabled', true);
                            }else{
                                if(password.val() !== confirm_password.val()){
                                    $('#valid_confirm_password_message').text('Пароли не совпадают');
                                    $('input[type=submit]').attr('disabled', true);
                                }else{
                                    $('#valid_confirm_password_message').text('');
                                    $('input[type=submit]').attr('disabled', false);
                                }
                                $('#valid_password_message').text('');
                            }
                        }else{
                            $('#valid_password_message').text('Введите пароль');
                        }
                    });
                    confirm_password.blur(function(){
                        if(password.val() !== confirm_password.val()){
                            $('#valid_confirm_password_message').text('Пароли не совпадают');
                            $('input[type=submit]').attr('disabled', true);
                        }else{
                            if(password.val().length > 6){
                                $('#valid_password_message').text('');
                                $('input[type=submit]').attr('disabled', false);
                            }
                            $('#valid_confirm_password_message').text('');
                        }
                    });
                });
            </script>

            <div class="wrapper_reset_pass">
                <div class="container">
                    <h2 class="pers_title">Новый пароль</h2>
                    <!-- Форма установки нового пароля -->
                    <form class="pers_form" action="update_password" method="post">
                        <div class="pers_item">
                            <input class="pers_input" type="password" name="password" required><br>
                            <label class="pers_label">Пароль</label>
                        </div>
                        <span id="valid_password_message" class="mesage_error"></span>
                        <div class="pers_item">
                            <input class="pers_input" type="password" name="confirm_password" required><br>
                            <label class="pers_label">Повторите пароль</label>
                        </div>
                        <span id="valid_confirm_password_message" class="mesage_error"></span>
                        <input type="hidden" name="token" value="<?=$token?>">
                        <input type="hidden" name="email" value="<?=$email?>">
                        <input class="auth_btn" type="submit" name="set_new_password" value="Изменить пароль" />
                    </form>
                </div>
                
            </div>









<?php
        }else{
            exit("<p><strong>Ошибка!</strong> Неправильный проверочный код.</p>");
        }
    }else{
        exit("<p><strong>Ошибка!</strong> Такой пользователь не зарегистрирован </p>");
    }
}else{
    exit("<p><strong>Ошибка!</strong> Сбой при выборе пользователя из БД. </p>");
}
$query_select_user->close();
$mysqli->close();
?>