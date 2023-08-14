<?php
require_once(get_theme_file_path('processing.php'));

$email = trim('daniil.brantov04@mail.ru');
$publicId = trim('pk_3da4553acc29b450d95115b0918f7');
$cloudSecretKey = trim('6a65dd6fb66b8f73f3e4daf7805fd66a');
$authorization = base64_encode($publicId . ':' . $cloudSecretKey);
//$authorization = $cloudSecretKey;
$url = 'https://api.cloudpayments.ru/subscriptions/find';
$data = array(
    'accountId' => $email
);

$options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\n" .
                     "Authorization: Basic " . $authorization,
        'method'  => 'POST',
        'content' => json_encode($data),
    ),
);

$context  = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response !== false) {
    $subscriptions = json_decode($response, true);

    if (array_key_exists('Model', $subscriptions)) {
        foreach ($subscriptions['Model'] as $subscription) {
            echo 'Subscription ID: ' . $subscription['Id'] . '<br>';
            echo 'Status: ' . $subscription['Status'] . '<br>';
        }
    } else {
        echo 'Нет совпадений';
    }
} else {
    echo 'Ошибка при выполнении запроса';
}




















// $url = 'https://api.cloudpayments.ru/subscriptions/find';
// $data = array(
//     'accountId' => $email
// );



// $options = array(
//     'http' => array(
//         'header'  => "Content-type: application/json\r\n" .
//                      "Authorization: Basic " . $authorization ,
//         'method'  => 'POST',
//         'content' => json_encode($data),
//     ),
// );

// $context  = stream_context_create($options);
// $response = file_get_contents($url, false, $context);

// if ($response !== false) {
//     $subscriptions = json_decode($response, true);

//     if (array_key_exists('Model', $subscriptions)) {
//         foreach ($subscriptions['Model'] as $subscription) {
//             echo 'Subscription ID: ' . $subscription['Id'] . '<br>';
//             echo 'Status: ' . $subscription['Status'] . '<br>';
//         }
//     } else {
//         echo 'Нет совпадений';
//     }
// } else {
//     echo 'Ошибка при выполнении запроса';
// }
?>








<!-- 
$apiUrl = 'https://api.cloudpayments.ru/subscriptions/get';
$authorization = CLOUD_SECRET_KEY;
$accountId = 'daniil.brantov04@mail.ru';

$data = array(
    'Id' => $accountId
);

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Authorization: ' . $authorization,
    'Content-Type: application/json'
));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($curl);

if (curl_errno($curl)) {
    $error = curl_error($curl);
    echo "Ошибка при выполнении запроса cURL: " . $error;
} else {
    $responseData = json_decode($response, true);
    if (empty($responseData)) {
        echo "Пустой ответ от API";
    } else {
        echo "Результат запроса: " . $response;
    }
}

curl_close($curl);

 -->
