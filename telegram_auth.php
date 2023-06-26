<?php /*
Template Name: telegram_auth
*/ 
get_header();
require_once( get_theme_file_path('processing.php') );
require_once( get_theme_file_path("sign/telegram-webhook/telegram_auth.php") );
get_footer(); ?>