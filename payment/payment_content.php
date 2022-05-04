<?php
    session_start();
    require_once 'pay_content.php';
    require_once 'wp-content/themes/my-theme/personal_area/connect.php';
    if (!$_SESSION['user']) {
        header('Location: auth');
    }




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
            if (full_name=='' || phone=='') { 
                document.querySelector('.payment').style.padding="300px 20px 200px";
                var txt=`
                <div class="payment_check">
                    <form action="https://eatintelligent.ru/payment" method="post">
                        <div class="pers_item">
                            <input id="full_name" class="pers_input" type="text" placeholder="ФИО" name="full_name" maxlength="50" required>
                        </div>
                        <div class="pers_item">
                            <input class="pers_input" type="text" placeholder="+7 (999) 999 99 99" name="phone" maxlength="20" required>
                        </div>
                        <input type="hidden" value="<?php echo $order; ?>" name="order">
                        <input type="hidden" value="<?php echo $sum; ?>" name="sum">
                        <div class="curriculum_btn">
                            <button id="payment_check_btn" type="submit">
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
                    return_url: 'https://eatintelligent.ru/pay-success',
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






