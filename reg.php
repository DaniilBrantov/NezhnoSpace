<?php
/**
 * Template Name: registration
 *
 
 */
get_header();
require_once( get_theme_file_path('processing.php') );
require_once( get_theme_file_path('sign/soc_net_auth.php') );

require_once "sign/reg_content.php";
get_footer();
?>