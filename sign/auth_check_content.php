<?php
require_once( get_theme_file_path('processing.php') );
require_once( get_theme_file_path('sign/components/Login.php') );
require_once( get_theme_file_path('sign/components/TelegramLogin.php') );

$login = new Login();
$tgLogin = new TelegramLogin('NezhnoSpacebot');

if($_GET['action'] == "out") $login->out(); 

$login->callLog($tgLogin->TgLogin());