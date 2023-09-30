<?php
require_once(get_theme_file_path('components/alarmManager.php'));
$alarmManager = new AlarmManager();

if (isset($_POST['anxietyId']) && is_numeric($_POST['anxietyId'])) {
    $anxietyId = intval($_POST['anxietyId']);

    $deleteTagDescriptionResult = $alarmManager->deleteTagDescription($anxietyId);

    if ($deleteTagDescriptionResult['status']) {
        echo json_encode($deleteTagDescriptionResult);
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'Ошибка при удалении описания тревоги: ' . $deleteTagDescriptionResult['error']
        ]);
    }
} else {
    echo json_encode([
        'status' => false,
        'message' => 'Некорректный или отсутствующий идентификатор тревоги.'
    ]);
}
