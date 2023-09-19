<?php 
/**
 * Template Name: payment
 *
 
 */

session_start();
require_once( "wp-config.php" );
require_once( get_theme_file_path('processing.php') );
require ( get_theme_file_path('/libs/yookassa/autoload.php') );
use YooKassa\Client;

get_header();
require_once "payment/payment_content.php";
get_footer();
?>