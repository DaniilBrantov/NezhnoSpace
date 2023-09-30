<?php
require_once(get_theme_file_path('components/alarmManager.php'));

// Создание объекта AlarmManager
$alarmManager = new AlarmManager();

if (isset($_POST['anxietyId']) && isset($_POST['newAnxietyText']) && isset($_POST['newAnxietyTagId'])) {
    $anxietyId = $_POST['anxietyId'];
    $newAnxietyText = $_POST['newAnxietyText'];
    $newAnxietyTagId = $_POST['newAnxietyTagId'];

    $updateTagDescriptionResult = $alarmManager->updateTagDescription($anxietyId, $newAnxietyTagId, $newAnxietyText);

    echo json_encode($updateTagDescriptionResult);
} else {
    echo json_encode([
        'status' => false,
        'message' => 'Некорректные данные для обновления тревоги.'
    ]);
}
?>
