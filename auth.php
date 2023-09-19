<?php
/**
 * Template Name: auth
 *
 
 */
session_start();
if ($_SESSION['id'] || !$_SESSION['id']==NULL) {
    header('Location: account');
}else{
    get_header();
    require_once "sign/auth_content.php";
    get_footer();
};

?>