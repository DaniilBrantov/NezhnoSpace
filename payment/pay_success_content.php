<?php
//4276420030130206
//2202203215223233
require_once( get_theme_file_path('processing.php') );
require __DIR__ . '/../libs/yookassa/autoload.php';
use YooKassa\Client;


$order_id = $_POST['orderId'];
var_dump(getPaymentData($order_id)) ;

//Получение данных оплаты
function getPaymentData($order_id){
    $client = new \YooKassa\Client();
    $client->setAuth('975491', 'test_ubpi1LK1auMcV-0o77C9Nn4ikb1h9RbzjaD0_2oFT7I');
    $params = array(
        'limit' => 1,
    );
    $payments = $client->getPayments($params);
    return ($payments["items"][0]['id']);
};


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