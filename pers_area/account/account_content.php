<?php
    require_once( get_theme_file_path('processing.php') );
    $payment= new Payment();
    CheckAuth();
    $user_data=$db->getRow("SELECT * FROM users WHERE id=?i", $_SESSION['id']);
    if(isset($user_data['avatar']) && !empty($user_data['avatar'])){
        $user_avatar='wp-content/uploads/permanent/'.$user_data['avatar'];
    }else{
    $user_avatar='';
    }
    if($user_data['sex']==1){
        $sex='Мужской';
    }elseif($user_data['sex']==2){
        $sex='Женский';
    }else{
        $sex='Пол';
    }
?>
<span class='price_944' data-price='<?php echo (get_post_meta(944, 'price', true))?>' style='display: none'></span>
<span class='price_945' data-price='<?php echo (get_post_meta(945, 'price', true))?>' style='display: none'></span>
<span class='price_946' data-price='<?php echo (get_post_meta(946, 'price', true))?>' style='display: none'></span>

<div class="account_section">
    <div class="container">
        <div class="account_sections-main">
            <div class="account_analytics-container">
                <div>Мой прогресс:</div>
                <img src="<?php img('sapiens.png') ?>" />
                <div class="account_analytics_not-result-text">Пока не готов результат</div>
                <a href="/survey" class='blue_btn account_analytics_survey-link'>Пройти опрос</a>
            </div>
            <form class="account_personal-data">
                <div class="account_image-wrap">
                    <img src='<?php echo $user_avatar; ?>' alt="photo" width="" height="" />
                    <label class="account_edit-img" for="account_input-img">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.4003 7.33998L16.6603 4.59998C16.3027 4.26408 15.8341 4.07134 15.3436 4.05843C14.8532 4.04553 14.3751 4.21335 14.0003 4.52998L5.0003 13.53C4.67706 13.8559 4.4758 14.2832 4.4303 14.74L4.0003 18.91C3.98683 19.0564 4.00583 19.2041 4.05596 19.3424C4.10608 19.4806 4.1861 19.6062 4.2903 19.71C4.38374 19.8027 4.49455 19.876 4.61639 19.9258C4.73823 19.9755 4.86869 20.0007 5.0003 20H5.0903L9.2603 19.62C9.71709 19.5745 10.1443 19.3732 10.4703 19.05L19.4703 10.05C19.8196 9.68095 20.0084 9.18849 19.9953 8.68052C19.9822 8.17254 19.7682 7.69049 19.4003 7.33998ZM9.0803 17.62L6.0803 17.9L6.3503 14.9L12.0003 9.31998L14.7003 12.02L9.0803 17.62ZM16.0003 10.68L13.3203 7.99998L15.2703 5.99998L18.0003 8.72998L16.0003 10.68Z"
                                fill="#111111" />
                        </svg>
                    </label>
                    <input type="file" name="account_input-img" id="account_input-img" />
                </div>
                <span class="text-error text-error_account_input-img">text error</span>
                <span class="account_personal-name">Мои данные</span>
                <div class="account_wrap-gender-age">
                    <div class="account_gender-select">
                        <div class="account_input-gender-wrapper">
                            <input class="account_input-gender account-input-custom" required="required" type="button"
                                value="<?php echo $sex; ?>" name="account_input-gender" />
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
                        <input type="text" id="account_input-age" class="account-input-custom" name="account_input-age"
                            value="<?php 
                            if ($user_data['age'] == '0000-00-00') {
                                echo '';
                            } else {
                                echo $user_data['age']; 
                            };
                            ?>" min="1900-01-01" max="2022-12-31" required="required" placeholder="ДД . ММ . ГГГГ"
                            onfocus="(this.type='date')"
                            onblur="(this.value == '' ? this.type='text' : this.type='date')">
                        <span class="text-error text-error_account_input-age">text error</span>
                    </div>
                </div>
                <input id="account_personal-name" class="account-input-custom" type="text" placeholder="Имя"
                    required="required" name="account_input-firstName" value="<?php echo $user_data['name']; ?>" />
                <span class="text-error text-error_account_input-firstName">text error</span>
                <input id="account_personal-lastName" class="account-input-custom" type="text" placeholder="Фамилия"
                    required="required" name="account_input-lastName" value="<?php echo $user_data['surname']; ?>" />
                <span class="text-error text-error_account_input-lastName">text error</span>
                <input id="account_personal-email" class="account-input-custom" type="email" placeholder="Почта"
                    required="required" name="account_input-email" value="<?php echo $user_data['mail']; ?>" readonly
                    disabled />
                <span class="text-error text-error_account_input-email">text error</span>
                <input id="account_personal-tel" class="account-input-custom" type="tel" placeholder="Телефон"
                    required="required" name="account_input-tel" value="<?php 
                    if ($user_data['telephone'] == '0') {
                        echo '';
                    } else {
                        echo $user_data['telephone']; 
                    };
                    ?>" />
                <span class="text-error text-error_account_input-tel">text error</span>
                <button id="upload_btn" class="account_btn-save blue_btn" name="account_btn-save">Сохранить</button>
                <span id='account-info-block' class='showInfo'>info upload text</span>
            </form>
        </div>

        <?php if ($payment->getCheckPayment()) { ?>
        <div class="account_sections-footer">
            <!-- Пока не готовы начать?  -->
            <span class='account_bth_payment-off'>Отменить&nbspподписку Нежно&nbspSpace</span>
        </div>
        <?php } else { ?>
        <div id='payment-banner' class='account_payment-banner pay-banner'>
            <div class='pay-banner_content'>
                <form class='pay-banner_promocode-wrap'>
                    <h4 class='pay-banner_promocode-title'>Промокод</h4>
                    <div class='pay-banner_promocode-input-wrap'>
                        <input name="promo" class='pay-banner_promocode-input' type="text" placeholder='Промокод'>
                        <span class="text-error text-error_promo">text error</span>
                    </div>
                    <div class='pay-banner_promocode-btn-wrap'>
                        <button name="promo_btn" class='blue_btn pay-banner_promocode-btn'
                            type='button'>Использовать</button>
                    </div>
                </form>
                <h4 class='pay-banner_title'>Оформить подписку:</h4>
                <ul class='pay-banner_options-wrap pay-banner_options-slider'>
                </ul>
            </div>

            <!-- <form action="payment.php" method="POST" class='promocode-post'>
                <input type="text" name="promocode" class='promocode_duble'/>
                <button type='submit' class='post-promocode-payment'></button>
            </form> -->
        </div>
        <?php  }; ?>
    </div>
</div>

<section class='account_payment-off_banner_background'>
    <div id='payment-off_banner' class='account_payment-off_banner payment-off_banner'>
        <button class='pay-banner_btnClose' type='button'></button>
        <div class='pay-banner_content'>
            <h4 class='pay-banner_title'>Вы уверены, что хотите отписаться от подписки Нежно&nbspSpace?</h4>
            <div class='pay-banner_text'>Вам ещё доступны материалы оплаченного месяца до <span
                    class='pay-banner_text-date'>05.03.2023</span></div>
            <div class='account_payment-off_buttons'>
                <button class='account_payment-off_button account_payment-off_yes'>Да</button>
                <button class='account_payment-off_button account_payment-off_no'>Нет</button>
            </div>
        </div>
    </div>
</section>

<div id="popupContainer">
  <div id="popupContent">
  <form>
        <div class="pers_item">
            <label>Email</label>
            <input id="email" type="email" name="email" placeholder="Введите email">
            <span class="text-error text-error_email">text error</span>
        </div>
        <div class="pers_item">
            <label>Номер телефона</label>
            <input type="tel" id="phone" name="phone" placeholder="Введите номер телефона">
            <span class="text-error text-error_phone">text error</span>
        </div>
        <div class="pers_btn">
            <button id="mail-phone_btn" name="mail-phone_btn" type="submit" class="blue_btn">Сохранить</button>
        </div>
    </form>
  </div>
</div>
