<?php
session_start();
require_once 'wp-content/themes/my-theme/personal_area/connect.php';

require __DIR__ . '/lib/autoload.php';
$client = new \YooKassa\Client();

//Nezhno
    $client->setAuth('924292', 'live_3RpyTpaK4mfe9cMn2AfQWUNWlHoed9BiRLWoOubbL2E');
//EI
//$client->setAuth('868432', 'live_2N08jIIa9MIMz37wjt0uUBCJyhs-knXVLd5gW2Mh0qk');
//TestPay
//$client->setAuth('869895', 'test_Q7KD27W77DlrRMm2yjcWW08DE8iXYHqSUTiP1-DaZMM');
//$client->setAuth('869895', 'test_Q7KD27W77DlrRMm2yjcWW08DE8iXYHqSUTiP1-DaZMM');





$users=mysqli_query($mysqli,"SELECT * FROM `users`");
while($customer=mysqli_fetch_assoc($users)){
    $today=strtotime(date('Y-m-d H:i:s'));
    $next_stage=strtotime($customer["next_stage"]) ;
    $difference= ($today - $next_stage)/ 86400;
    $month= $difference/ 28;
    if ($next_stage && $customer["payment_method"]) {
        $customer_id=$customer["id"];

        if($customer["pay_month"] == '0'){
            if($customer["rate"]=="1"){
                $pay_month='1';
                $fst_val= 693.0;
            }else if($customer["rate"]=="2"){
                $pay_month='6';
                $fst_val= 3593.0;
            }else if($customer["rate"]=="3"){
                $pay_month='12';
                $fst_val= 5993.0;
            };

            if ($difference > 7) {
                
                $payment = $client->createPayment(
                    array(
                        'amount' => array(
                            'value' => $fst_val,
                            'currency' => 'RUB',
                        ),
                        'capture' => true,
                        'payment_method_id' => $customer["payment_method"],
                        'description' => 'Подписка на платформу Нежно',
                    ),
                    uniqid('', true)
                );
                if($payment["status"]=="succeeded"){
                    mysqli_query($mysqli,"UPDATE `users` SET `pay_month` = '$pay_month' WHERE `users`.`id` = '$customer_id'");
                };
            }
        }else{
            if($customer["rate"]=="1"){
                $pay_val= 700.0;
                $pay_month=$customer["pay_month"]+1;
            }else if($customer["rate"]=="2"){
                $pay_val= 3600.0;
                $pay_month=$customer["pay_month"]+6;
            }else if($customer["rate"]=="3"){
                $pay_val= 6000.0;
                $pay_month=$customer["pay_month"]+12;
            }
        };

        if($month > $customer["pay_month"] && $customer["pay_month"] !== '0'){
            $payment = $client->createPayment(
                array(
                    'amount' => array(
                        'value' => $pay_val,
                        'currency' => 'RUB',
                    ),
                    'capture' => true,
                    'payment_method_id' => $customer["payment_method"],
                    'description' => 'Подписка на платформу Нежно',
                ),
                uniqid('', true)
            );
            if($payment["status"]=="succeeded"){
                mysqli_query($mysqli,"UPDATE `users` SET `pay_month` = '$pay_month' WHERE `users`.`id` = '$customer_id'");
                
            };
        }
    }
}

?>