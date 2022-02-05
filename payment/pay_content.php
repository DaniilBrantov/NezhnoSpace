

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

    if(!empty($order) && !empty($email)) {
        $description = 'Заказ № '.$order.' E-mail: '.$email;
        $client = new Client();
        $client->setAuth('869895', 'test_Q7KD27W77DlrRMm2yjcWW08DE8iXYHqSUTiP1-DaZMM');
        $idempotenceKey = uniqid('', true);
        if($order==1){
            $payment = $client->createPayment(
                array(
                    'amount' => array(
                        'value' => '300',
                        'currency' => 'RUB',
                    ),
                    'confirmation' => array(
                        'type' => 'embedded',
                    ),
                    'capture' => true,
                    'save_payment_method'=> true,
                    'description' => $description,
                    'merchant_customer_id'=> $email,
                ),
                $idempotenceKey
            );
            $pay_cnt='Оформить подписку на месяц';
            
        }else{
            $payment = $client->createPayment(
                array(
                    'amount' => array(
                        'value' => '7000',
                        'currency' => 'RUB',
                    ),
                    'confirmation' => array(
                        'type' => 'embedded',
                    ),
                    'capture' => true,
                    'description' => $description,
                    'merchant_customer_id'=> $email,
                ),
                $idempotenceKey
            );
            $pay_cnt='Дальше проходить курс';
        };
        print_r($payment["payment_method"]);
        } else {
            header('Location: my_account');
        }
            ?>
