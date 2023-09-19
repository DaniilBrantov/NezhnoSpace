<?php

require_once( get_theme_file_path('processing.php') );
CheckAuth();
$get_id=(int)$_GET['post'];
//$get_id=918;
$user_data = $db->getRow("SELECT * FROM users WHERE id=?i", $_SESSION['id']);
$payment_date =$user_data['payment_date'];
$today = date("Y-m-d H:i:s");
$payment_days=countDaysBetweenDates($today, $payment_date);
$open_main_posts=$payment_days/7;





if( !checkPayment() || !$get_id){
    header('Location: subscription');
};

$post_data = getSubscriptionLesson($get_id, openPosts($get_id, $payment_date));

var_dump(openPosts($get_id, $payment_date));

var_dump($post_data);

?>