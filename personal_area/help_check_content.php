<?php

session_start();

$mess= @trim(stripslashes($_POST["help_mess"]));
$user_name=@trim(stripslashes($_SESSION["user"]["mail"]));

$data =  json_decode($_POST['our_mail']);
$dataJson = json_encode($data);
echo $dataJson;
die();

$name       =$user_name ;
$from       = "EatIntelligent";
$subject    ="EatIntelligent Help";
$message    ="EatIntelligent \n У {$user_name} возникла загвостка, проблемка, вопрос...   \n \n------------------ \n \nСообщение: {$mess}";
$to         = 'daniil.brantov04@mail.ru';

$headers = "MIME-Version: 1.0";
$headers .= "Content-type: text/plain; charset=UTF-8";
$headers .= "From: {$name} <{$from}>";
$headers .= "Reply-To: <{$from}>";
$headers .= "Subject: {$subject}";
$headers .= "X-Mailer: PHP/".phpversion();

$success=mail($to, $subject, $message,$headers);

if (!$success) {
    $errorMessage = error_get_last()['message'];
}
else{
    $success_message= "Спасибо за ваш вопрос, мы обязательно его рассмотрим и дадим обратную связь!";
    header('Location: /help');
}

?>