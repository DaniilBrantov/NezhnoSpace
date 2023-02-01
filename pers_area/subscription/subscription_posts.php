<?php
    require_once( get_theme_file_path('processing.php') );
    CheckAuth();
    $get_id=(int)$_GET['id'];
    $user_data = $db->getRow("SELECT * FROM users WHERE id=?i", $_SESSION['id']);
    $payment_date =$user_data['payment_date'];

    if( !checkPayment() || !$get_id || empty(CategoryData(openPosts( $payment_date, '', $get_id ),$get_id))){
        header('Location: subscription');
    };

var_dump(CategoryData(ceil(openPosts( $payment_date, '', $get_id )),$get_id));
?>