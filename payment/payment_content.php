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

$_SESSION["payment"]=[
    "id" => $payment_result["id"],
    "service_id" => $service_number
];
header('Location: ' . $payment_url , true, 301);
exit();

?>