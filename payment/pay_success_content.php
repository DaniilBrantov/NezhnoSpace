
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


$paymentId = $_SESSION["pay_id"];
$user_id=$_SESSION["user"]["id"];
$user_mail=$_SESSION["user"]["mail"];
$payment = $client->getPaymentInfo($paymentId);
$email = $_SESSION['user']['mail'];

















    $email = new \PHPMailer\PHPMailer\PHPMailer();

    $email->CharSet = 'utf-8';
    $email->isSMTP();
    $email->Host = 'smtp.yandex.ru';
    $email->SMTPAuth = true;                              
    $email->Username = 'support@eatintelligent.ru'; 
    $email->Password = 'Eat123Intelligent123';
    $email->SMTPSecure = 'ssl';
    $email->Port = 465; 

    $email->setFrom('support@eatintelligent.ru');
    $email->addAddress($user_mail);    
    $email->isHTML(true);                                 

    $email->Subject = 'Eat Intelligent';






try {
    $response = $client->getPaymentInfo($paymentId);
} catch (\Exception $e) {
    $response = $e;
}
$user_payment=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM `users` WHERE `users`.`id`='$user_id' "));

if ($response["status"]=="succeeded" && $response["amount"]["value"]=='7.00') {
    if($response["payment_method"]["id"] && $response["metadata"]){
        $payment_method=$response["payment_method"]["id"];
        $rate=$response["metadata"]["rate"];
    };
    if($user_payment["payment"]=='2'){
        $new_payment='4';
    }else{
        $new_payment='1';
    }
    mysqli_query($mysqli,"UPDATE `users` SET `payment` = '$new_payment', `payment_method` = '$payment_method', `rate` = '$rate' WHERE `users`.`id` = '$user_id'");
    header('Location: uchebnaya-programma');
    $email->Body    =  '
    
        <div style="
        background: #1C1C1C;
        color: whitesmoke;
        padding: 30px;
        margin: 30px;
        border-radius: 20px;
        margin: 30px auto;
        max-width: 500px;"
        >
            
            <h2>
            Благодарим тебя за оплату Подписки Eat Intelligent! 
            </h2>  
            <p>Тебе уже доступны первые материалы в Личном Кабинете: </p>
            <div style="margin: 50px 0px;">
                <a href="https://nezhno.space/first_stage" style="
                    color: whitesmoke;
                    text-decoration: navajowhite;
                    padding: 15px 30px;
                    border: 2px solid whitesmoke;
                    border-radius: 50px;
                ">Подкаст</a>
            </div>
                
        </div>
    ';

}else if($response["status"]=="succeeded" && $response["amount"]["value"]=='7000.00'){
    $user_payment=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM `users` WHERE `users`.`id`='$user_id' "));
    if($user_payment["payment"]=='1'){
        $new_payment='4';
    }else{
        $new_payment='2';
    }
    mysqli_query($mysqli,"UPDATE `users` SET `payment` = '$new_payment' WHERE `users`.`id` = '$user_id'");
    header('Location: uchebnaya-programma');
    $email->Body    =  '
    
    <div style="
    background: #1C1C1C;
    color: whitesmoke;
    padding: 30px;
    margin: 30px;
    border-radius: 20px;
    margin: 30px auto;
    max-width: 500px;"
    >
        
        <h2>
            Благодарим тебя за оплату Курса по Психологии Питания и Пищевого Поведения. 
        </h2>  
        <p>28 апреля откроется Второй этап нашего курса. </p>
        <p>Первый этап уже доступен на платформе, ты можешь к нему вернуться, если ещё не прошла. </p>
        <div style="margin: 50px 20px;">
            <a href="https://nezhno.space/first_stage" style="
                color: whitesmoke;
                text-decoration: navajowhite;
                padding: 15px 30px;
                border: 2px solid whitesmoke;
                border-radius: 50px;
            ">Первый Этап</a>
        </div>
            
    </div>
    ';
}
else{
    header('Location:payment');
}
    $fetch_assoc_indiv=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT `payment` FROM `users` WHERE `users`.`id` = '$user_id' "));
    $_SESSION["user"]["payment"]=$fetch_assoc_indiv["payment"];



    $email->AltBody = '';
    if(!$email->send()) {
        echo 'Error';
    } else {}








?>







