<?php
get_header();

require_once( get_theme_file_path('processing.php') );
CheckAuth();
$payment=new Payment();
if(!is_category() || !$payment->getCheckPayment()){
    header('Location: subscription');
};

require_once "post/category_cnt.php";

get_footer();

?>