<?php
session_start();
require_once( get_theme_file_path('processing.php') );

$order_id = $_GET['orderId'];

//4276 4200 3013 0206

$ch = curl_init('https://api.yookassa.ru/v3/payments/' . $order_id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERPWD, '924292:live_K6zxD3oLhzUTmDPpr8If3fc2F5VlY6Ocmt8N8mJMek4');
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Idempotence-Key: ' . gen_uuid()));
$res = curl_exec($ch);
curl_close($ch);

$res = json_decode($res, true);
var_dump($res['items'][0]['payment_method']);
$status=$res['items'][0]['status'];
if($status==='succeeded'){
    if($db->query("UPDATE users SET pay_status=?s WHERE id=?i",$status,$_SESSION['id'])){
        echo 'Успех!';
    }else{
        echo 'Ошибка при отправке данных на сервер';
    }
}elseif($status==='pending'){
    //header('Location: subscription');
}else{
    
}

?>