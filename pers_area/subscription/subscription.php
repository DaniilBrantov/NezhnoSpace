<?php
    require_once( get_theme_file_path('processing.php') );

    $user_data = $db->getRow("SELECT * FROM users WHERE id=?i", $_SESSION['id']);
    $payment_status=$user_data['pay_status'];
    $payment_date =$user_data['payment_data'];
    $today = date("Y-m-d H:i:s");
    $payment_days=countDaysBetweenDates($today, $payment_date);





    if(checkPayment()){
        echo ('Пользователь подписан');
    }else{
        echo ('Пользователь НЕ подписан!');
    }
    ?><br><br><?php

    if(checkPayment()){
        echo 'Еж. Практика на сегодня-------';
        var_dump(TodayPractice($payment_days));
        ?><br><br><?php
    };

    
    echo 'Все еж. практики--------';
    var_dump(CategoryData(45));
    ?><br><br><?php
    echo 'Данные конкретной записи. В дизайне это "описание"------';
    var_dump(subscriptionData(913));
    ?><br><br><?php
    echo 'Все Реки--------';
    var_dump(CategoryData(46));
    ?><br><br><?php
    echo 'Весь общий материал--------';
    var_dump(CategoryData(47));


?>