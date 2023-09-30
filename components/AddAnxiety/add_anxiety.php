<?php
require_once(get_theme_file_path('components/alarmManager.php'));

// Создание объекта AlarmManager
$alarmManager = new AlarmManager();

if (isset($_POST['anxietyText']) && isset($_POST['anxietyTagId'])) {
    $anxietyText = $_POST['anxietyText'];
    $anxietyTagId = $_POST['anxietyTagId'];

    $createAlarmResult = $alarmManager->createAlarm($anxietyText, $anxietyTagId);

    echo json_encode($createAlarmResult);
} else {
    echo json_encode([
        'status' => false,
        'message' => 'Некорректные данные для создания тревоги.'
    ]);
}
?>
