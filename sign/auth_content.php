

<div class="authorization">
    <div class="reg_auth">
        <div class="authorization_title">
            <h1>
                АВТОРИЗОВАТЬСЯ
            </h1>
        </div>
        <form class="authorization_form">
            <div class="pers_item">
                <label>Email</label>
                <input type="text" name="mail" placeholder="Введите email...">
                <span class="text-error text-error_mail">text error</span>
            </div>
            <div class="pers_item">
                <div class="pers_item_pass">
                    <label>Пароль</label>
                    <a href="reset_pass">
                        Забыли пароль?
                    </a>
                </div>
                <div class="pers_input">
                    <input type="password" name="pass" placeholder="Введите пароль...">
                    <span class="pass_eye"></span>
                    <span class="text-error text-error_pass">text error</span>
                </div>

            </div>
            <div class="pers_btn">
                <button id="auth_btn" name="auth_btn" type="submit" class="blue_btn">Войти</button>
            </div>
        </form>
        <div class="authorization_question">
            <p>Нет аккаунта?</p>
            <a href="registration">Зарегистрироваться</a>
        </div>
    </div>
    <div class="authorization_window-error">
        <span>window error</span>
        <button class="blue_btn authorization_window-error_btn">ок</button>
    </div>
</div>