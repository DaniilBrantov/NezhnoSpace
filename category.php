<?php
get_header();

require_once( get_theme_file_path('processing.php') );
CheckAuth();
if(!is_category() || !$_SESSION['status'] == "Active" || !$_SESSION['status'] == "Activate"){
    header('Location: subscription');
};

require_once "post/category_cnt.php";

get_footer();

?>