<?php
CheckAuth();
$price = 990;
$description = 'описание';


require __DIR__ . '/lib/autoload.php';
use YooKassa\Client;
    $client = new Client();


//     $client->setAuth('924292', 'live_3RpyTpaK4mfe9cMn2AfQWUNWlHoed9BiRLWoOubbL2E');
//     $client->createPayment(
//         array(
//             'amount' => array(
//                 'value' => 2,
//                 'currency' => 'RUB',
//             ),
//             'payment_method_data' => array(
//                 'type' => 'sberbank',
//                 'phone' => '79506276012',
//             ),
//             'confirmation' => array(
//                 'type' => 'redirect',
//                 'return_url' => 'https://nezhno.space/pay_success',
//             ),
//             'description' => 'Заказ №72',
//         ),
//         uniqid('', true)
//     );


?>
<div id="payment-form"></div>


<script src="https://static.yoomoney.ru/checkout-js/v1/checkout.js">
const checkout = YooMoneyCheckout('924292');
const checkout = YooMoneyCheckout('924292', {
    language: 'ru'
});

checkout.tokenize({
    number: document.querySelector('.number').value,
    cvc: document.querySelector('.cvc').value,
    month: document.querySelector('.expiry_month').value,
    year: document.querySelector('.expiry_year').value
}).then(res => {
    if (res.status === 'success') {
        const {
            paymentToken
        } = res.data.response;

        return paymentToken;
    }
});
console.log(checkout);
</script>






<script>
// const conf_token = "<?php //createNewPayment($price,$description) ?>";

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
</script>