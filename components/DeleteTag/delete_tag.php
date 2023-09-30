<?php
require_once( get_theme_file_path('components/alarmManager.php') );

// Создание объекта AlarmManager
$alarmManager = new AlarmManager();

if (isset($_POST['tagId']) && is_numeric($_POST['tagId'])) {
    // Удаление тега
    $anxietyId = intval($_POST['tagId']);
    $deleteTagDescriptionResult = $alarmManager->deleteTagDescription($anxietyId);
    echo json_encode($deleteTagDescriptionResult);
} else {
    echo json_encode([
        'status' => false,
        'message' => 'Некорректный или отсутствующий идентификатор тега.'
    ]);
}

?>