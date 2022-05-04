
<?php

session_start();
require_once 'wp-content/themes/my-theme/personal_area/connect.php';

require __DIR__ . '/lib/autoload.php';
$client = new \YooKassa\Client();
$client->setAuth('868432', 'live_2N08jIIa9MIMz37wjt0uUBCJyhs-knXVLd5gW2Mh0qk');
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
if ($response["status"]=="succeeded" && $response["amount"]["value"]=='300.00') {
    mysqli_query($mysqli,"UPDATE `users` SET `payment` = '1' WHERE `users`.`id` = '$user_id'");
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
                <a href="https://eatintelligent.ru/first_stage" style="
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
    mysqli_query($mysqli,"UPDATE `users` SET `payment` = '2' WHERE `users`.`id` = '$user_id'");
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
            <a href="https://eatintelligent.ru/first_stage" style="
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







