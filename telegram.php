<?php /*
Template Name: telegram
*/ 
get_header();
require_once( get_theme_file_path('processing.php') );
require_once( get_theme_file_path("sign/telegram-webhook/telegram.php") );
get_footer(); ?>