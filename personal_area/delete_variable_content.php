<?php
session_start();

if(!$_SESSION["admin"]){
    header('Location: /auth');
}

require_once "connect.php";

$id= $_GET["id"];

mysqli_query($mysqli, "DELETE FROM `main_stages` WHERE `main_stages`.`id` = $id");

header('Location: /admin');
?>