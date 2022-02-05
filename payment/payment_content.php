<?php
    session_start();
    require_once 'wp-content/themes/my-theme/personal_area/connect.php';
    if (!$_SESSION['user']) {
        header('Location: auth');
    }
    require_once 'pay_content.php';
?>
<div class="wrapper_payment">
    <div class="payment">
        <div class="payment_title">
            <h4><?php echo($pay_cnt); ?></h4>
            <p>Подтверждая оплату, вы тем самым соглашаетесь с условиями <a href="contract">публичной оферты</a>.</p>
            <h3><?php echo($payment["amount"]["value"]); ?>₽ </h3>
        </div>
        <div id="payment-form"></div>
        <script>
        const checkout = new window.YooMoneyCheckoutWidget({
            confirmation_token: '<?php echo($payment["confirmation"]["confirmationToken"]); ?>',
            return_url: 'https://eatintelligent.ru/pay-success',
                // customization: {
                //     payment_methods: ['google_pay']
                // },
            error_callback: function(error) {
                console.log(error);
                console.log('error');
            }
        });
        checkout.render('payment-form');

        </script>
    </div>
</div>
  





