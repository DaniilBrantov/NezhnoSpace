<?php
    session_start();

    if ($_SESSION['user']) {
        header('Location: my_account');
    }
?>
<div class="pers auth">
    <div class="figure"></div>
    <div class="steps">
            <div type="button" class=" step_item s_i_1" value="Click" onmousedown="openHint1()">
                <div class="main_circle">
                    <div class="small_circle"></div>
                </div>
                <p>1 шаг</p>
            </div>
            <div id="hint1" class="hint">
            <div id="line_1" class="line hint_line "></div>
                <p>
                    Регистрация
                </p>
            </div>
            <div class="line"></div>
            <div class=" step_item" type="button" value="Click" onmousedown="openHint2()">
                <div class="main_circle">
                    <div class="small_circle"></div>
                </div>
                <p>2 шаг</p>
            </div>
            <div id="hint2" class="hint">
            <div id="line_2" class="line hint_line"></div>
                <p>
                    Авторизация
                </p>
            </div>
            <div class="line"></div>
            <div class=" step_item s_i_1" type="button" value="Click" onmousedown="openHint3()">
                <div class="main_circle">
                    <div class="small_circle"></div>
                </div>
                <p>3 шаг</p>
            </div>
            <div id="hint3" class="hint">
            <div id="line_3" class="line hint_line"></div>
                <p>
                    Ваш личный кабинет
                </p>
            </div>
        </div>
    <div class="container">
    <h2 class="pers_title">Авторизация</h2>
        <form class="pers_form">
            <div class="pers_item">
                <input class="pers_input" type="text"  id="mail" name="mail" required><br>
                <label class="pers_label">E-mail</label>
            </div>
            <div class="pers_item">
                <input class="pers_input" type="password" id="pass" name="pass" required><br>
                <a class="password_control"></a>
                <label class="pers_label">Пароль</label>
            </div>
            <button class="auth_btn" id="auth_btn" type="submit">Войти</button>
            <div class="auth_links">
                <a class="pers_link" href="/registration">Регистрация</a>
                <a class="pers_link" href="/reset_password">Забыли пароль?</a>
            </div>
            <p class="auth_msg none">Lorem ipsum dolor sit amet.</p>
        </form>
    </div>
</div>
<script>    
var hint1=document.getElementById("hint1");
var hint2=document.getElementById("hint2");
var hint3=document.getElementById("hint3");
    function openHint1(){
        if (hint1.style.opacity == "1") {
            hint1.style.opacity = "0";
        }
        else{
            hint1.style.opacity = "1";
            hint2.style.opacity = "0";
            hint3.style.opacity = "0";
        }
    };

    function openHint2(){
        if (hint2.style.opacity == "1") {
            hint2.style.opacity = "0";
        }
        else{
            hint2.style.opacity = "1";
            hint1.style.opacity = "0";
            hint3.style.opacity = "0";
        }
    };

    function openHint3(){
        if (hint3.style.opacity == "1") {
            hint3.style.opacity = "0";
        }
        else{
            hint3.style.opacity = "1";
            hint1.style.opacity = "0";
            hint2.style.opacity = "0";
        }
    };
</script>