<?php
    require_once( get_theme_file_path('processing.php') );

    $user_data = $db->getRow("SELECT * FROM users WHERE id=?i", $_SESSION['id']);
    $payment_status=$user_data['pay_status'];
    $payment_date =$user_data['payment_data'];
    $today = date("Y-m-d H:i:s");
    $payment_days=countDaysBetweenDates($today, $payment_date);
    $open_main_posts=$payment_days/7;

// Вывод конкретной записи
// var_dump($daily_practices[1]);

// Сегодняшняя практика
$today_practice=TodayPractice($payment_days);

// Ежедневные практики
$daily_practices=CategoryData($payment_days+1,45);

//Рекомендательная система
$recommendations=CategoryData($open_main_posts,46);

//Тема месяца
$month_theme=CategoryData($open_main_posts,47);


    var_dump($today_practice);?><br><br><?php
    var_dump($daily_practices);?><br><br><?php
    var_dump($recommendations);?><br><br><?php
    var_dump($month_theme);?><br><br><?php








?>