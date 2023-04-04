<?php
session_start();
require_once( get_theme_file_path('processing.php') );
require __DIR__ . '/../libs/yookassa/autoload.php';
use YooKassa\Client;
$paymentId=$_SESSION["payment"]["id"];
//var_dump(SavePayment('2b9006c4-000f-5000-9000-121c39f843ed'));
// if(SavePayment($paymentId)){
//     //header('Location: subscription');
// }else{ //header('Location: subscription'); }
?>