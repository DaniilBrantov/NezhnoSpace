<?php
$payment=new Payment();
if ($payment->getCheckPayment() || !$_SESSION['id'] || $_SESSION['id']==NULL) {
    header('Location: subscription');
    die();
}
$service_data = $payment->getPaymentServiceData();
//Promocode
if( $_POST['promo'] ){
    $promo=$_POST['promo'];
    if($payment->getcheckPromocode($promo)['status']){
        $price= $service_data['price']-($service_data['price'] / 100 * $payment->getcheckPromocode($promo)['sale']);
    }
}
    $payment_result=$payment->getConnectToPayment($payment->createPagePayment($service_data['price'], $service_data['description']));
    $payment_url=$payment_result['confirmation']['confirmation_url'];
    $_SESSION["payment"]=[
        "id" => $payment_result["id"],
        "service_id" => $service_id
    ];
    header('Location: ' . $payment_url , true, 301);
    exit();


?>