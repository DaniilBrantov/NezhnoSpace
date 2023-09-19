<?php 
/**
 * Template Name: set_new_password
 *
 */
require_once( get_theme_file_path('processing.php') );

if(isset($_GET['token']) && !empty($_GET['token']) && isset($_GET['email']) && !empty($_GET['email'])){
    check();
}else{
    $error='Отсутствует проверочный код или e-mail';
}



function check(){
    $db = new SafeMySQL();
    $token = $_GET['token'];
    $mail=$_GET['email'];
    if($user_token = $db->getOne("SELECT reset_pass_token FROM users WHERE mail=?s",$_GET['email'])){
        if($token == $user_token){
            get_header(); 
            getPassForm($token);
            get_footer();
        }
    }
};


function getPassForm($token){
echo '    <div class="authorization">
        <div class="reg_auth">
            <div class="authorization_title">
                <h1>
                    Восстановление пароля
                </h1>
            </div>
            <form class="authorization_form">
                <input type="hidden" name="pass_token" value='.$token.'>
                <div class="pers_item">
                    <label>Пароль</label>
                    <div class="pers_input">
                        <input type="password" name="pass" placeholder="Введите пароль...">
                        <span class="pass_eye"></span>
                        <span class="text-error text-error_pass">text error</span>
                    </div>
                </div>
                <div class="pers_item">
                    <label>Подтвердите пароль</label>
                    <input type="password" name="pass_conf" placeholder="Подтвердите пароль...">
                    <span class="text-error text-error_pass_conf">text error</span>
                </div>
                <div class="pers_btn">
                    <button id="set_pass_btn" name="set_pass_btn" type="submit" class="blue_btn">Изменить</button>
                </div>
            </form>
            <div class="authorization_question">
                <p>Вернуться?</p>
                <a href="registration">Авторизация</a>
            </div>
        </div>
    </div>';
};