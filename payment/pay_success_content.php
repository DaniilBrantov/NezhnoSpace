<?php
//4276420030130206
//2202203215223233
require_once( get_theme_file_path('processing.php') );
require __DIR__ . '/../libs/yookassa/autoload.php';
use YooKassa\Client;


// $order_id = $_GET['orderId'];
// $shop_id='975491';
// $secret_key='test_ubpi1LK1auMcV-0o77C9Nn4ikb1h9RbzjaD0_2oFT7I';
// $userpwd=$shop_id.':'.$secret_key;

// $ch = curl_init('https://api.yookassa.ru/v3/payments/' . $order_id);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
// curl_setopt($ch, CURLOPT_HEADER, false);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Idempotence-Key: ' . uniqid('', true)));
// $res = curl_exec($ch);
// curl_close($ch);
// $res = json_decode($res, true);
// print_r($res);

// function gen_uuid() {
// 	return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
// 		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
// 		mt_rand( 0, 0xffff ),
// 		mt_rand( 0, 0x0fff ) | 0x4000,
// 		mt_rand( 0, 0x3fff ) | 0x8000,
// 		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
// 	);
// }



//Получение данных оплаты
    $client = new \YooKassa\Client();
    $client->setAuth('924292', 'live_K6zxD3oLhzUTmDPpr8If3fc2F5VlY6Ocmt8N8mJMek4');
    $paymentId = '2b59e547-000f-5000-a000-1e50e827dccb';
    $payment = $client->getPaymentInfo($paymentId);
    var_dump ($payment['id']);


// $res = json_decode($res, true);
// $payment_method_id=$res['items'][0]['payment_method']['id'];
// $status=$res['items'][0]['status'];
// $payment_data=$res["items"][0]["created_at"];
// if($status==='succeeded'){
//     if($db->query("UPDATE users SET pay_status=?s, payment_method=?s, payment_data=?s WHERE id=?i", $status, $payment_method_id, $payment_data, $_SESSION['id'])){
//         var_dump ($res["items"][0]["created_at"]);
//     }else{
//         echo 'Ошибка при отправке данных на сервер';
//     }
// }elseif($status==='pending'){
//     //header('Location: subscription');
// }else{
    
// };





//Autopay('2b59da25-000f-5000-a000-19ffc7c976cd','AutopayT');




    ?>