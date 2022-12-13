<?php
    //require_once( get_theme_file_path('processing.php') );
    //var_dump(CheckAuth()) ;
?>

<div class="account_section">
    <div class="container">
        <ul class="account_navigation-list">
            <li class="active account_fullname"><a href="#">Ксения Ларькина</a></li>
            <li><a href="#">Моя подписка</a></li>
            <li><a href="#">Календарь</a></li>
        </ul>
        <div class="account_sections-main">
            <div class="account_analytics-container">блок графиков и аналитики</div>
            <form class="account_personal-data">
                <div class="account_image-wrap">
                    <img src='' alt="photo" width="" height="" />
                    <label class="account_edit-img" for="account_input-img">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.4003 7.33998L16.6603 4.59998C16.3027 4.26408 15.8341 4.07134 15.3436 4.05843C14.8532 4.04553 14.3751 4.21335 14.0003 4.52998L5.0003 13.53C4.67706 13.8559 4.4758 14.2832 4.4303 14.74L4.0003 18.91C3.98683 19.0564 4.00583 19.2041 4.05596 19.3424C4.10608 19.4806 4.1861 19.6062 4.2903 19.71C4.38374 19.8027 4.49455 19.876 4.61639 19.9258C4.73823 19.9755 4.86869 20.0007 5.0003 20H5.0903L9.2603 19.62C9.71709 19.5745 10.1443 19.3732 10.4703 19.05L19.4703 10.05C19.8196 9.68095 20.0084 9.18849 19.9953 8.68052C19.9822 8.17254 19.7682 7.69049 19.4003 7.33998ZM9.0803 17.62L6.0803 17.9L6.3503 14.9L12.0003 9.31998L14.7003 12.02L9.0803 17.62ZM16.0003 10.68L13.3203 7.99998L15.2703 5.99998L18.0003 8.72998L16.0003 10.68Z"
                                fill="#111111" />
                        </svg>
                    </label>
                    <input type="file" name="account_input-img" id="account_input-img" />
                </div>
                <span class="account_personal-name">Kseniya Larkina</span>
                <div class="account_wrap-gender-age">
                    <div class="account_gender-select">
                        <div class="account_input-gender-wrapper">
                            <input class="account_input-gender account-input-custom" required="required" type="button"
                                value="Пол" />
                            <svg width="40" height="16" viewBox="0 0 40 16" fill='none'
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M40 4L24.4472 11.7764C24.1657 11.9172 23.8343 11.9172 23.5528 11.7764L8 4"
                                    stroke="#421dd8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="account_gender-list">
                            <span>Женский</span>
                            <span>Мужской</span>
                        </div>
                    </div>
                    <div class="account_age-select">
                        <input type="date" id="account_input-age" class="account-input-custom" name="account_input-age"
                            value="" min="1900-01-01" max="2022-12-31" required="required">
                    </div>
                </div>
                <input id="account_personal-name" class="account-input-custom" type="text" placeholder="Имя"
                    required="required" />
                <input id="account_personal-lastName" class="account-input-custom" type="text" placeholder="Фамилия"
                    required="required" />
                <input id="account_personal-email" class="account-input-custom" type="email" placeholder="Почта"
                    required="required" />
                <input id="account_personal-tel" class="account-input-custom" type="tel" placeholder="Телефон"
                    required="required" />
                <button class="account_btn-save blue_btn" name="account_btn-save">Сохранить</button>
            </form>
        </div>
        <div class="account_sections-footer">
            Пока не готовы начать? <a>Отменить&nbspподписку Нежно&nbspSpace</a>
        </div>
    </div>
</div>