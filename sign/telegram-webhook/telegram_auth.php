<?php
$token = '5911355377:AAG8SXvmibgkTkS1EqB0EZG_ujvYUSU0i2s'; // Замените на свой токен
$redirect_url = 'https://nezhno.space/telegram'; // Замените на свой адрес перенаправления
$bot_username = 'NezhnoSpacebot'; // Замените на имя вашего бота

if ($_GET['logout']) {
    setcookie('tg_user', '');
    header('Location: auth?action=out');
}

function getTelegramUserData() {
    if (isset($_COOKIE['tg_user'])) {
        $auth_data_json = urldecode($_COOKIE['tg_user']);
        $auth_data = json_decode($auth_data_json, true);
        return $auth_data;
    }
    return false;
}

$tg_user = getTelegramUserData();
if ($tg_user !== false) {
    $first_name = htmlspecialchars($tg_user['first_name']);
    $last_name = htmlspecialchars($tg_user['last_name']);
    if (isset($tg_user['username'])) {
        $username = htmlspecialchars($tg_user['username']);
        $html = "<h1>Hello, <a href=\"https://t.me/{$username}\">{$first_name} {$last_name}</a>!</h1>";
    } else {
        $html = "<h1>Hello, {$first_name} {$last_name}!</h1>";
    }
    if (isset($tg_user['photo_url'])) {
        $photo_url = htmlspecialchars($tg_user['photo_url']);
        $html .= "<img src=\"{$photo_url}\">";
    }
    $html .= "<p><a href=\"?logout=1\">Log out</a></p>";
} else {
    $html = <<<HTML
    <h1>Hello, anonymous!</h1>
    <script src="https://telegram.org/js/telegram-widget.js?2" 
    data-telegram-login="{$bot_username}" data-size="large" data-auth-url="telegram"></script>
HTML;
}

echo <<<HTML
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login Widget Example</title>
    </head>
    <body>
        <center>{$html}</center>
    </body>
</html>
HTML;
?>