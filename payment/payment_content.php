<?php
    session_start();
    require_once 'pay_content.php';
    require_once 'wp-content/themes/my-theme/personal_area/connect.php';


if(!$sum || empty($sum) || $sum==NULL){
    header('Location: subscription');
};
?>

<div class="wrapper_payment">
    <div class="payment">
        <div class="payment_title">
            <h4><?php echo($pay_cnt); ?></h4>
            <p>Подтверждая оплату, вы тем самым соглашаетесь с условиями <a href="contract">публичной оферты</a>.</p>
            <h3><?php echo $sum; ?>₽ </h3>
        </div>
        <script>
            var full_name='<?php echo $full_name;?>';
            var phone='<?php echo $phone;?>';
            var user_tel='<?php echo $user_tel["telephone"]; ?>';
            var session_user= '<?php echo $_SESSION['user']; ?>';
            if (full_name=='' && phone=="7") { 
                document.querySelector('.payment').style.padding="300px 20px 200px";
                var txt=`
                <div class="payment_check">
                    <form action="https://nezhno.space/your_type" method="post">
                        <div class="pers_item payment_check_item">
                            <input id="full_name" class="pers_input" type="text" placeholder="ФИО" name="form_name" maxlength="50" required>
                            <div id="error_name" class="none auth_msg">Введите ваше ФИО</div>
                        </div>`
                        if(!session_user){
                            txt=txt+`
                                <div class="pers_item payment_check_item">
                                    <input id="pay_mail" class="pers_input" type="text" placeholder="E-mail" name="form_mail" maxlength="50" required>
                                    <div id="error_mail" class="none auth_msg">Некорректный E-mail</div>
                                </div>`;
                        };
                        txt=txt+`<div class="pers_item payment_check_item">
                            <input id="phone" class="pers_input" type="tel" placeholder="+7 (999) 999 99 99" name="user_tel" maxlength="20" required>
                            <div id="error_phone" class="none auth_msg">Некорректный номер телефона</div>
                        </div>
                        <input id="pay_order" type="hidden" value="<?php echo $order; ?>" name="order">
                        <input id="pay_sum" type="hidden" value="<?php echo $sum; ?>" name="sum">
                        <input type="hidden" value="<?php echo $rate; ?>" name="rate">
                        <div class="curriculum_btn">
                            <button id="payment_check_btn" type="submit" disabled>
                                <img src="<?php echo get_template_directory_uri(); ?>/images/account_arrow.svg" alt="">
                            </button>
                        </div>
                    </form>
                </div>`;
                document.write(txt);
            }else if(full_name==''){
                document.querySelector('.payment').style.padding="300px 20px 200px";
                var txt=`
                <div class="payment_check">
                    <form action="https://nezhno.space/your_type" method="post">
                        <div class="pers_item payment_check_item">
                            <input id="full_name" class="pers_input" type="text" placeholder="ФИО" name="form_name" maxlength="50" required>
                            <div id="error_name" class="none auth_msg">Введите ваше ФИО</div>
                        </div>`;
                        if(!session_user){
                            txt=txt+`
                            <div class="pers_item payment_check_item">
                                <input id="pay_mail" class="pers_input" type="text" placeholder="E-mail" name="mail" maxlength="50" required>
                                <div id="error_mail" class="none auth_msg">Некорректный E-mail</div>
                            </div>`;
                        };
                        txt=txt+`<input type="hidden" value="<?php echo $order; ?>" name="order">
                        <input type="hidden" value="<?php echo $sum; ?>" name="sum">
                        <input type="hidden" value="<?php echo $rate; ?>" name="rate">
                        <div class="curriculum_btn">
                            <button id="payment_check_btn" type="submit" disabled>
                                <img src="<?php echo get_template_directory_uri(); ?>/images/account_arrow.svg" alt="">
                            </button>
                        </div>
                    </form>
                </div>`;
                document.write(txt);
            }else{
                var pay_form = document.createElement("div");
                document.querySelector('.payment_title').after(pay_form);
                pay_form.id='payment-form';
            
                    const checkout = new window.YooMoneyCheckoutWidget({
                    confirmation_token: '<?php echo($payment["confirmation"]["confirmationToken"]); ?>',
                    return_url: 'https://nezhno.space/pay-success',
                        // customization: {
                        //     payment_methods: ['google_pay']
                        // },
                    error_callback: function(error) {
                        console.log(error);
                    }
                });
                checkout.render('payment-form');
            }
        </script>
    </div>
</div>





