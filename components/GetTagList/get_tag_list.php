<?php
$alarmManagerFile = get_theme_file_path('components/alarmManager.php');

if (file_exists($alarmManagerFile)) {
    require_once($alarmManagerFile);

    // Создаем объект AlarmManager
    $alarmManager = new AlarmManager();

    // Получаем описания тегов
    $tags = $alarmManager->getTags();

    // Формируем результат в одну строку
    echo json_encode(['status' => true, 'msg' => $tags ?? []]);
} else {
    // Обработка случая, если файл не существует
    echo json_encode(['status' => false, 'msg' => 'File not found']);
}
?>

