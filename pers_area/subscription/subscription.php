<?php
    require_once( get_theme_file_path('processing.php') );
    CheckAuth();

    $user_data = $db->getRow("SELECT * FROM users WHERE id=?i", $_SESSION['id']);
    $payment_date =$user_data['payment_date'];
    $today = date("Y-m-d H:i:s");
    $payment_days=countDaysBetweenDates($today, $payment_date);
    $open_main_posts=$payment_days/7;
    $one_month=944;
    $six_month=945;
    $twelve_month=946;

// Вывод конкретной записи
// var_dump($daily_practices[1]);

// Сегодняшняя практика
// Если оплаты нет, тогда выводит NULL
$today_practice=TodayPractice($payment_days);

// Ежедневные практики
$daily_practices=CategoryData($payment_days+1,45);

// Рекомендательная система
$recommendations=CategoryData($open_main_posts,46);

// Тема месяца
$month_theme=CategoryData($open_main_posts,47);

// Выбор услуги
?><form action="payment" method="post">
    <input value="<?php echo $one_month ?>" name="payment_btn" type="submit">
    <input value="<?php echo $six_month ?>" name="payment_btn" type="submit">
    <input value="<?php echo $twelve_month ?>" name="payment_btn" type="submit">

</form><?php
echo (get_post_meta(944, 'month_count', true));
var_dump (get_post_meta(944, 'price', true));
var_dump (get_post_meta(945, 'month_count', true));
var_dump (get_post_meta(945, 'price', true));
var_dump (get_post_meta(946, 'month_count', true));
var_dump (get_post_meta(946, 'price', true));?><br><br><?php

    var_dump($today_practice);?><br><br><?php
    var_dump($daily_practices);?><br><br><?php
    var_dump($recommendations);?><br><br><?php
    var_dump($month_theme);?><br><br><?php








?>