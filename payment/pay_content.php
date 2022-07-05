

<?php
    session_start();
    require_once 'wp-content/themes/my-theme/personal_area/connect.php';
    require __DIR__ . '/lib/autoload.php';
    use YooKassa\Client;
    $email = $_SESSION['user']['mail'];
    $phone_val=substr($_POST["phone"], -10);
    $user_tel=mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM `users`  WHERE `users`.`mail` = '$email' "));
    if($_SESSION['user']){
        $full_name=$_SESSION['user']['full_name'];
        if($_SESSION['user']['order'] && $_SESSION['user']['sum']){
            $order=$_SESSION['user']['order'];
            $sum=$_SESSION['user']['sum'];
        }else{
            $order = $_POST["order"];
            $sum = $_POST["sum"];
        };
    }else{
        $full_name=$_POST["full_name"];
        $order = $_POST["order"];
        $sum = $_POST["sum"];
    }
    if($user_tel["telephone"]=="0"){
        $phone='7'.$phone_val;
        if($phone_val){
            mysqli_query($mysqli,"UPDATE `users` SET `telephone`='$phone_val' WHERE `mail`='$email'");
        };
    }else{
        $phone='7'.$user_tel["telephone"];
    }
        $description = 'Заказ № '.$order.' E-mail: '.$email;
        $client = new \YooKassa\Client();
        $client->setAuth('868432', 'live_2N08jIIa9MIMz37wjt0uUBCJyhs-knXVLd5gW2Mh0qk');
        //$client->setAuth('869895', 'test_Q7KD27W77DlrRMm2yjcWW08DE8iXYHqSUTiP1-DaZMM');
        $idempotenceKey = uniqid('', true);
        if($order==1 && $full_name && $phone){
            $payment = $client->createPayment
            (
                array(
                    'amount' => array(
                        'value' => '300',
                        'currency' => 'RUB',
                    ),
                    'confirmation' => array(
                        'type' => 'embedded',
                    ),
                    "receipt" => array(
                        "customer" => array(
                            "full_name" => "$full_name",
                            "phone" => "$phone",
                        ),
                        "items" => array(
                            array(
                                "description" => "Курс по психологии питания",
                                "quantity" => "1.00",
                                "amount" => array(
                                    "value" => "300.00",
                                    "currency" => "RUB"
                                ),
                                "vat_code" => "1",
                                "payment_mode" => "full_prepayment",
                                "payment_subject" => "service"
                            )
                        )
                    ),
                    'capture' => true,
                    'description' => $description,
                    'merchant_customer_id'=> $email,
                ), $idempotenceKey
            );

            $pay_cnt='Оформить подписку на месяц';
            
        }else if($order==2 && $full_name && $phone){
            $payment = $client->createPayment(
                array(
                    "amount" => array(
                        "value" => "7000",
                        "currency" => "RUB"
                    ),
                    'confirmation' => array(
                        'type' => 'embedded',
                    ),
                    "receipt" => array(
                        "customer" => array(
                            "full_name" => "$full_name",
                            "phone" => "$phone",
                        ),
                        "items" => array(
                            array(
                                "description" => "Наименование товара 1",
                                "quantity" => "1.00",
                                "amount" => array(
                                    "value" => "7000.00",
                                    "currency" => "RUB"
                                ),
                                "vat_code" => "1",
                                "payment_mode" => "full_prepayment",
                                "payment_subject" => "service"
                            )
                        )
                    ),
                    'capture' => true,
                    'description' => $description,
                    'merchant_customer_id'=> $email,
                ),
                $idempotenceKey
            );
            $pay_cnt='Дальше проходить курс';

            
        };
        $_SESSION["pay_id"]=$payment["id"];

        ?>