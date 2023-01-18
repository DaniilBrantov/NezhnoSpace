<div class="authorization">
    <div class="reg_auth">
        <div class="authorization_title">
            <h1>
                ЗАРЕГИСТРИРОВАТЬСЯ
            </h1>
        </div>
        <form class="authorization_form">
            <div class="pers_item">
                <label>Ваше имя</label>
                <input type="text" name="first_name" placeholder="Введите имя...">
                <span class="text-error text-error_first_name">text error</span>
            </div>
            <div class="pers_item">
                <label>Email</label>
                <p class="pers_item_txt">На указанный email придет код подтверждения</p>
                <input type="text" name="mail" placeholder="Введите email...">
                <span class="text-error text-error_mail">text error</span>
            </div>
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
            <div class="pers_approval pers_item_txt">
                <input type="checkbox" required class="visually-hidden" id="pers_approval_checkbox"
                    name="approval_check">
                <label for="pers_approval_checkbox">Я соглашаюсь с условиями публичной оферты</label>
            </div>
            <div class="pers_btn">
                <button id="reg_btn" class="blue_btn" type="submit">ЗАРЕГИСТРИРОВАТЬСЯ</button>
            </div>
        </form>
        <div class="authorization_question">
            <p>Есть аккаунт?</p>
            <a href="auth">Войти</a>
        </div>
    </div>
    <div class="authorization_window-error">
        <span>window error</span>
        <button class="blue_btn authorization_window-error_btn">ок</button>
    </div>
</div>

