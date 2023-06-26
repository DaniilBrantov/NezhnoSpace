<?php
$token = '5911355377:AAG8SXvmibgkTkS1EqB0EZG_ujvYUSU0i2s'; // Замените на свой токен
$redirect_url = 'https://nezhno.space/telegram'; // Замените на свой адрес перенаправления
$bot_username = 'NezhnoSpacebot'; // Замените на имя вашего бота

if ($_GET['logout']) {
    setcookie('tg_user', '');
    header('Location: auth?action=out');
    exit;
}
$tg_user = getTelegramUserData();
function getTelegramUserData() {
    if (isset($_GET['id'], $_GET['first_name'], $_GET['username'], $_GET['photo_url'])) {
        $auth_data = [
            'id' => $_GET['id'],
            'first_name' => $_GET['first_name'],
            'username' => $_GET['username'],
            'photo_url' => $_GET['photo_url']
        ];
        return $auth_data;
    }
    return false;
}


if ($tg_user !== false) {
    $first_name = htmlspecialchars($tg_user['first_name']);
    $last_name = htmlspecialchars($tg_user['last_name']);
    $username = isset($tg_user['username']) ? htmlspecialchars($tg_user['username']) : '';
    $photo_url = isset($tg_user['photo_url']) ? htmlspecialchars($tg_user['photo_url']) : '';

    $html = "<h1>Hello, ";
    if (!empty($username)) {
        $html .= "<a href=\"https://t.me/{$username}\">{$first_name} {$last_name}</a>";
    } else {
        $html .= "{$first_name} {$last_name}";
    }
    $html .= "!</h1>";

    if (!empty($photo_url)) {
        $html .= "<img src=\"{$photo_url}\">";
    }

    $html .= "<p><a href=\"?logout=1\">Log out</a></p>";
} else {
    $html = <<<HTML
    <h1>Login with Telegram</h1>
    <script async src="https://telegram.org/js/telegram-widget.js?2"
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
        <div style="text-align: center;">{$html}</div>
    </body>
</html>
HTML;
?>