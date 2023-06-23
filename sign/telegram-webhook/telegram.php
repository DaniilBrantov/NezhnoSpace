<?php
$update = file_get_contents('php://input');
$data = json_decode($update, true);

if (isset($data['message'])) {
    $chatId = $data['message']['chat']['id'];
    $text = $data['message']['text'];

    if ($text === '/start') {
        $userId = generateUserId(); 
        saveUserIdToDatabase($userId, $chatId); // Ваша функция для сохранения идентификатора пользователя в базе данных
        sendMessage($chatId, 'Добро пожаловать! Ваш уникальный идентификатор: ' . $userId);
    } elseif ($text === '/help') {
        sendMessage($chatId, 'Помощь необходима?');
    } else {
        sendMessage($chatId, 'Спасибо за ваше сообщение!');
    }
}
function sendMessage($chatId, $text)
{
    $url = 'https://api.telegram.org/bot5911355377:AAG8SXvmibgkTkS1EqB0EZG_ujvYUSU0i2s/sendMessage';
    $params = [
        'chat_id' => $chatId,
        'text' => $text,
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
}
function generateUserId()
{
    return uniqid();
}

// Функция для сохранения идентификатора пользователя в базе данных
function saveUserIdToDatabase($userId, $chatId)
{
    // Ваш код для сохранения идентификатора пользователя в базе данных
    // Например, можно использовать SQL-запрос INSERT для добавления записи в таблицу с пользователями
}


$state = generateUserId(); 
$telegramAuthUrl = 'https://telegram.org/auth/login?auth_url=';
$authParams = [
    'bot_id' => '5911355377:AAG8SXvmibgkTkS1EqB0EZG_ujvYUSU0i2s', 
    'origin' => 'https://nezhno.space',
    'request_access' => 'write',
    'redirect_to' => 'https://nezhno.space/telegram',
    'state' => $state,
];
$authUrl = $telegramAuthUrl . urlencode(http_build_query($authParams));
?>
<a href="<?php echo $authUrl; ?>">Link</a>