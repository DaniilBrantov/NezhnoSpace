<?php 
/*
Template Name: regisration
*/
session_start();
if ($_SESSION['id'] || !$_SESSION['id']==NULL) {
    header('Location: account');
}else{
    get_header();
    require_once "sign/reg_content.php";
    get_footer();
};
?>