<?php
CheckAuth();

if($_POST["payment_btn"] && !empty($_POST["payment_btn"]) && isset($_POST["payment_btn"]) && $_POST["payment_btn"] !== NULL){
    $service_id=$_POST["payment_btn"];
}else{
    $service_id=944;
};

    $service_number=get_post_meta($service_id, 'month_count', true);
    $price=get_post_meta($service_id, 'price', true);
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