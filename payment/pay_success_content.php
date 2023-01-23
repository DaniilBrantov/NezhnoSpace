<?php
session_start();

require_once( get_theme_file_path('processing.php') );
require __DIR__ . '/../libs/yookassa/autoload.php';
use YooKassa\Client;


$paymentId=$_SESSION["payment"]["id"];

//Save Payment
    if($paymentId){
        $payment_info=getPaymentInformation($paymentId);
        if($payment_info){
            if($payment_info["status"]==='succeeded'){
                $payment_date=(array)($payment_info["created_at"]);
                if($db->query("UPDATE users SET status=?i, pay_choice=?i, payment_method=?s, payment_date=?s WHERE id=?i", 2, $_SESSION["payment"]["service_id"], $payment_info['payment_method']['id'], $payment_date["date"], $_SESSION['id'])){
                    $answer = true;
                }
            }
        }
    }
    
var_dump(isset($answer) );





//Autopay('2b59da25-000f-5000-a000-19ffc7c976cd','AutopayT');



// Здравствуйте. Нужно получить информацию о платеже пользователя, который только что оплатил. В документации пишут, что
// нужно вызвать этот запрос:

//   $paymentId = 'xxxxxxxxxxxxxxx';
//   $payment = $client->getPaymentInfo($paymentId);

// HTTP-уведомления включены, но ничего не отображает. $_GET пустой.
// Вопрос,как получить $paymentId?
    ?>