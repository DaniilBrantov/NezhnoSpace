<?php
    $alarmManagerFile = get_theme_file_path('components/alarmManager.php');
    if (file_exists($alarmManagerFile)) {
        require_once($alarmManagerFile);

        $alarmManager = new AlarmManager();
        $tagDescriptions = $alarmManager->getTagDescriptions();
        echo json_encode(['status' => true, 'msg' => $tagDescriptions ?? []]);
    } else {
        echo json_encode(['status' => false, 'msg' => 'File not found']);
    }
?>

