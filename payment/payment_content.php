<?php
session_start();
CheckAuth();
require_once( get_theme_file_path('processing.php') );
require __DIR__ . '/../libs/yookassa/autoload.php';
use YooKassa\Client;

$service_number=1;
$price=1;
$mail = $db->getOne("SELECT mail FROM users WHERE id=?i",$_SESSION['id']);

$description=$mail . ' Купил услугу №' . $service_number;


$payment_result=connectionPayment(createPagePayment($price, $description));
$payment_url=$payment_result['confirmation']['confirmation_url'];
header('Location: ' . $payment_url , true, 301);
exit();

?>
















<!-- <div id="payment-form"></div> -->
<!-- <script>
// const conf_token = "<?php // createWidgetPayment($price,$description); ?>";

// const checkout = new window.YooMoneyCheckoutWidget({
//     confirmation_token: conf_token,
//     return_url: 'https://nezhno.space/pay_success',

//     customization: {
//         colors: {
//             control_primary: '#421DD8',
//             background: '#F2F3F5'
//         }
//     },
//     error_callback: function(error) {
//         console.log(error)
//     }
// });

// //Отображение платежной формы в контейнере
// checkout.render('payment-form');
</script> -->