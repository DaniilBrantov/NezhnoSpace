<?php
session_start();
require_once( get_theme_file_path('processing.php') );
require __DIR__ . '/../libs/yookassa/autoload.php';
use YooKassa\Client;
$paymentId=$_SESSION["payment"]["id"];
if(SavePayment($paymentId)){
    header('Location: subscription');
}else{ header('Location: subscription'); }
?>