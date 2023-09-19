<?php
session_start();

require_once( get_theme_file_path('processing.php') );
require __DIR__ . '/../libs/yookassa/autoload.php';
use YooKassa\Client;


$paymentId=$_SESSION["payment"]["id"];

if(SavePayment($paymentId)){
    echo "Платёж успешно завершён";
}else{
    echo "Что то пошло не так. Попробовать снова?";
}






//Autopay('2b59da25-000f-5000-a000-19ffc7c976cd','AutopayT');



// Здравствуйте. Нужно получить информацию о платеже пользователя, который только что оплатил. В документации пишут, что
// нужно вызвать этот запрос:

//   $paymentId = 'xxxxxxxxxxxxxxx';
//   $payment = $client->getPaymentInfo($paymentId);

// HTTP-уведомления включены, но ничего не отображает. $_GET пустой.
// Вопрос,как получить $paymentId?
    ?>