<?php
$post=(int)$_GET['post'];

require_once( get_theme_file_path('processing.php') );
CheckAuth();
$get_id=(int)$_GET['post'];
//$get_id=918;
$user_data = $db->getRow("SELECT * FROM users WHERE id=?i", $_SESSION['id']);
$payment_date =$user_data['payment_date'];
if( !checkPayment() || !$get_id){
    header('Location: subscription');
};
$post_data = getSubscriptionLesson($get_id, ceil(openPosts($payment_date, $get_id, '')));



var_dump($post_data);

?>