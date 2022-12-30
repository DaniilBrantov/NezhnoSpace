<?php
/**
 * Template Name: account_check
 *
 
 */
session_start();
require_once( get_theme_file_path('processing.php') );
require_once( get_theme_file_path('save_upload.php') );
// $avatar=$_POST['avatar'];
// $gender=$_POST['gender'];
// $age=$_POST['age'];
// $first_name=$_POST['first_name'];
// $last_name=$_POST['last_name'];
// $tel=$_POST['tel'];
// $email=$_POST['email'];
 //echo $_SESSION['id'];

if($_POST['send']){
	echo json_encode(saveUpload($_FILES['image'],5,768,1280));
}

?>