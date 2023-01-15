<?php


$order_id = $_GET['orderId'];

$ch = curl_init('https://api.yookassa.ru/v3/payments/' . $order_id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERPWD, YOOKASSA_CONNECTION);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Idempotence-Key: ' . gen_uuid()));
$res = curl_exec($ch);
curl_close($ch);

$res = json_decode($res, true);
print_r($res['items'][0]['status']);

?>