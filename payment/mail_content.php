<?php
// require __DIR__ . '/lib/autoload.php';
// // Получите данные из POST-запроса от Яндекс.Кассы
// $source = file_get_contents('php://input');
// $requestBody = json_decode($source, true);
// // Создайте объект класса уведомлений в зависимости от события
// // NotificationSucceeded, NotificationWaitingForCapture,
// // NotificationCanceled,  NotificationRefundSucceeded
// use YandexCheckout\Model\Notification\NotificationSucceeded;
// use YandexCheckout\Model\Notification\NotificationWaitingForCapture;
// use YandexCheckout\Model\NotificationEventType;
// use YandexCheckout\Model\PaymentStatus;
// try {
//   $notification = ($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
//     ? new NotificationSucceeded($requestBody)
//     : new NotificationWaitingForCapture($requestBody);
// } catch (Exception $e) {
//     // Обработка ошибок при неверных данных
// }
// // Получите объект платежа
// $payment = $notification->getObject();
// if($payment->getStatus() === PaymentStatus::SUCCEEDED) {
//     // Отправка сообщения
//     $mailTo = "daniil.brantov04@mail.ru"; // Ваш e-mail
//     $subject = "На сайте совершен платеж"; // Тема сообщения
//     // Сообщение
//     $message = "Платеж на сумму: " . $payment->amount->value . "<br/>";
//     $message .= "Детали платежа: " . $payment->description . "<br/>";
    
//     $headers= "MIME-Version: 1.0\r\n";
//     $headers .= "Content-type: text/html; charset=utf-8\r\n";
//     $headers .= "From: daniil.brantov04@mail.ru <daniil.brantov04@mail.ru>\r\n";
    
//     mail($mailTo, $subject, $message, $headers);
// }
?>

<script>
//Инициализация виджета. Все параметры обязательные.
const checkout = new window.YooMoneyCheckoutWidget({
    confirmation_token: 'ct-24301ae5-000f-5000-9000-13f5f1c2f8e0', //Токен, который вы получили после создания платежа
    return_url: 'https://yookassa.ru/', //Ссылка на страницу завершения оплаты
    error_callback: function(error) {
        console.log(error)
    }
});

//Отображение платежной формы в контейнере
checkout.render('payment-form');
</script>

