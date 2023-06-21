<?php
session_start();
require_once( get_theme_file_path('processing.php') );
$db = new SafeMySQL();
CheckAuth();



$id=$_POST['service_id'];
$quantity = 1;
$user_id=$_SESSION['id'];
$service = $db->getRow("SELECT * FROM services WHERE id=?i", $id);
$user = $db->getRow("SELECT * FROM users WHERE id=?i", $user_id);
$publicId='pk_3da4553acc29b450d95115b0918f7';
$apiKey='4b978f8af1e63cb76629acbb9d9caff0';
$label = 'Пользователь '. $user_id .'оплатил подписку №'. $id;
$startDate=date("Y-m-d H:i:s");   

$data=[
    'label' => $label,
    'publicId' => $publicId,
    'invoiceId' => $id,
    'service_name' => $service['name'],
    'price' => (int)$service['price'],
    'mail' => $user['mail'],
    'period' => $service['month_count'],
    'description' => $service['description'],
    'quantity' => $quantity,
    'apiKey' => $apiKey,
    'startDate' => $startDate
];
$data['status']=true;

echo json_encode($data);





























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