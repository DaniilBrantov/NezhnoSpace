<?php
echo 'hi';
if (checkPayment() || !$_SESSION['id'] || $_SESSION['id']==NULL) {
    header('Location: subscription');
    die();
}

if($_POST["payment_btn"] || $_POST["payment_btn"] !== NULL){
    $service_id=$_POST["payment_id"];
}elseif($_GET["payment_choice"]){
    $service_id=$_GET["payment_choice"];
}else{
    $service_id=944;
};
if(!get_post_meta($service_id, 'month_count', true) || !get_post_meta($service_id, 'price', true)){
    $service_id=944;
};
    $service_number=get_post_meta($service_id, 'month_count', true);
    $price=get_post_meta($service_id, 'price', true);
    $description=$mail . ' Купил услугу на ' . $service_number .' месяц(ев)';
    $mail = $db->getOne("SELECT mail FROM users WHERE id=?i",$_SESSION['id']);

//Promocode
if( $_POST['promo'] ){
    $promo=$_POST['promo'];
    if(checkPromocode($promo)['status']){
        $price= $price-($price / 100 * checkPromocode($promo)['sale']);
    }
}



    $payment_result=connectionPayment(createPagePayment($price, $description));
    $payment_url=$payment_result['confirmation']['confirmation_url'];

    $_SESSION["payment"]=[
        "id" => $payment_result["id"],
        "service_id" => $service_id
    ];
    header('Location: ' . $payment_url , true, 301);
    exit();


?>