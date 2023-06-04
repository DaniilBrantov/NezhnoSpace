<?php

require_once( get_theme_file_path('processing.php') );
$db = new SafeMySQL();

$_POST['id']=1;


$id=$_POST['id'];
$user_id=$_SESSION['id'];
$service = $db->getRow("SELECT * FROM services WHERE id=?i", $id);
$user = $db->getRow("SELECT * FROM users WHERE id=?i", $user_id);
$quantity=1;

$data=[
    'service_name' => $service['name'],
    'price' => $service['price'],
    'quantity' => $quantity,
    'mail' => $user['mail'],

]





























// $payment=new Payment();
// if ($payment->getCheckPayment() || !$_SESSION['id'] || $_SESSION['id']==NULL) {
//     header('Location: subscription');
//     die();
// }
// $service_data = $payment->getPaymentServiceData();
// //Promocode
// if( $_POST['promo'] ){
//     $promo=$_POST['promo'];
//     if($payment->getcheckPromocode($promo)['status']){
//         $price= $service_data['price']-($service_data['price'] / 100 * $payment->getcheckPromocode($promo)['sale']);
//     }
// }
//     $payment_result=$payment->getConnectToPayment($payment->createPagePayment($service_data['price'], $service_data['description']));
//     $payment_url=$payment_result['confirmation']['confirmation_url'];
//     $_SESSION["payment"]=[
//         "id" => $payment_result["id"],
//         "service_id" => $service_id
//     ];
//     header('Location: ' . $payment_url , true, 301);
//     exit();


?>