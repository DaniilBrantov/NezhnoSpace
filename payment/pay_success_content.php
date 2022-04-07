
<?php

session_start();
require_once 'wp-content/themes/my-theme/personal_area/connect.php';

require __DIR__ . '/lib/autoload.php';
$client = new \YooKassa\Client();
$client->setAuth('869895', 'test_Q7KD27W77DlrRMm2yjcWW08DE8iXYHqSUTiP1-DaZMM');
$paymentId = $_SESSION["pay_id"];
$user_id=$_SESSION["user"]["id"];
$payment = $client->getPaymentInfo($paymentId);



$user_name=@trim(stripslashes($_SESSION['user']["mail"]));

    $name       =$user_name ;
    $from       = "EatIntelligent";
    $subject    ="EatIntelligent";
    $message    ="Оплата произведена Успешно!";
    $to         = $user_name;
    
    $headers = "MIME-Version: 1.0";
    $headers .= "Content-type: text/plain; charset=UTF-8";
    $headers .= "From: {$name} <{$from}>";
    $headers .= "Reply-To: <{$from}>";
    $headers .= "Subject: {$subject}";
    $headers .= "X-Mailer: PHP/".phpversion();
    
    $success=mail($to, $subject, $message,$headers);




try {
    $response = $client->getPaymentInfo($paymentId);
} catch (\Exception $e) {
    $response = $e;
}

if ($response["status"]=="succeeded" && $response["amount"]["value"]=='300.00') {
    mysqli_query($mysqli,"UPDATE `users` SET `payment` = '1' WHERE `users`.`id` = '$user_id'");
    header('Location: uchebnaya-programma');

}else if($response["status"]=="succeeded" && $response["amount"]["value"]=='1.00'){
    mysqli_query($mysqli,"UPDATE `users` SET `payment` = '2' WHERE `users`.`id` = '$user_id'");
    header('Location: uchebnaya-programma');
}else{
    var_dump($response["amount"]["value"]);
    header('Location:payment');
}
    $fetch_assoc_indiv=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT `payment` FROM `users` WHERE `users`.`id` = '$user_id' "));
    $_SESSION["user"]["payment"]=$fetch_assoc_indiv["payment"];

?>






<div class="h1"><h1>UUUURRRRAAAA!</h1></div>


