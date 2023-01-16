<?php
CheckAuth();

//Autopay('2b57618b-000f-5000-8000-1967d24b5958','$description')

createPagePayment(1,'$description');
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