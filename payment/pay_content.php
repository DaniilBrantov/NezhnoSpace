<?php

//Отправка платежных данных
$data = array(
	'amount' => array(
 		'value' => 1000,
 		'currency' => 'RUB',
 	),
 	'capture' => true,
 	'confirmation' => array(
 		'type' => 'redirect',
 		'return_url' => 'https://nezhno.space/pay',
 	),
	'description' => 'Заказ №1',
	'metadata' => array(
 		'order_id' => 1,
 	)
);
 
$data = json_encode($data, JSON_UNESCAPED_UNICODE);
 	
$ch = curl_init('https://api.yookassa.ru/v3/payments');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_USERPWD, '869895:test_Q7KD27W77DlrRMm2yjcWW08DE8iXYHqSUTiP1-DaZMM');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Idempotence-Key: ' . gen_uuid()));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 	
$res = curl_exec($ch);
curl_close($ch);	
	
$res = json_decode($res, true);
//print_r($res);

//Редиректим пользователя на форму оплаты
header('Location: ' . $res['confirmation']['confirmation_url'], true, 301);
exit();


?>