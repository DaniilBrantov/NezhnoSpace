<?php 

//if($_COOKIE['user']== ''): 
?>

<div class="pers">
    <div class="figure"></div>
    <div class="container">
        <div class="steps">
            <div type="button" class=" step_item" value="Click" onmousedown="openHint1()">
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
            <div class=" step_item s_i_1" type="button" value="Click" onmousedown="openHint2()">
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
            <div class="line reg_line"></div>
            <div class=" step_item s_i_2" type="button" value="Click" onmousedown="openHint3()">
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
        <h2 class="pers_title">Регистрация</h2>
            <form class="pers_form">
                <div class="pers_item" id="pers_i1">
                    <input class="pers_input" type="text" id="nname" name="nname" required><br>
                    <label class="pers_label">Имя</label>
                </div>
                <p class="name_msg none">Некорректное поле ввода!</p>
                <!-- <div class="pers_item">
                    <input class="pers_input" type="text" id="surname" name="surname" required><br>
                    <label class="pers_label">Фамилия</label>
                </div> -->
                <div class="pers_item">
                    <input class="pers_input" type="text" id="mail" name="mail" required><br>
                    <label class="pers_label">Email</label>
                </div>
                <div class="pers_item">
                    <input class="pers_input" type="password" id="pass" name="pass" required><br>
                    <a class="password_control"></a>
                    <label class="pers_label">Пароль</label>
                </div>
                <button  class="reg_btn" type="submit">Зарегистрироваться</button>
                <p class="pers_link">У вас уже есть аккаунт? - <a href="/auth">авторизируйтесь</a>!</p>
                <p class="auth_msg none">Lorem ipsum dolor sit amet.</p>

            </form>
    </div>
</div>
<script>    
    function openHint1(){
        if (document.getElementById("hint1").style.opacity == "1") {
            document.getElementById("hint1").style.opacity = "0";
        }
        else{
            document.getElementById("hint1").style.opacity = "1";
            document.getElementById("hint2").style.opacity = "0";
            document.getElementById("hint3").style.opacity = "0";
        }
    };

    function openHint2(){
        if (document.getElementById("hint2").style.opacity == "1") {
            document.getElementById("hint2").style.opacity = "0";
        }
        else{
            document.getElementById("hint2").style.opacity = "1";
            document.getElementById("hint1").style.opacity = "0";
            document.getElementById("hint3").style.opacity = "0";
        }
    };

    function openHint3(){
        if (document.getElementById("hint3").style.opacity == "1") {
            document.getElementById("hint3").style.opacity = "0";
        }
        else{
            document.getElementById("hint3").style.opacity = "1";
            document.getElementById("hint1").style.opacity = "0";
            document.getElementById("hint2").style.opacity = "0";
        }
    };
</script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-3.5.1.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/personal_area.js"></script>
<?php //else: require_once 'my_account_content.php';
    //endif;  ?>


