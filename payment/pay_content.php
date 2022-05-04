

<?php
    session_start();
    require_once 'wp-content/themes/my-theme/personal_area/connect.php';
    if (!$_SESSION['user']) {
        header('Location: auth');
    }
    require __DIR__ . '/lib/autoload.php';
    use YooKassa\Client;
    $order = $_POST["order"];
    $sum = $_POST["sum"];
    $email = $_SESSION['user']['mail'];
    $full_name=$_POST["full_name"];
    $phone=$_POST["phone"];

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