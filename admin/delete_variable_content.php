<?php
session_start();

if(!$_SESSION["admin"]){
    header('Location: /auth');
}

require_once "connect.php";

$id= $_GET["id"];
$stage= $_GET["stage"];
$les_num= $_GET["les_num"];
mysqli_query($mysqli, "DELETE FROM `users_individ_content` WHERE `id_users` = '$stage' AND `less_number` = '$les_num'"  );
mysqli_query($mysqli, "DELETE FROM `main_stages` WHERE `main_stages`.`id` = $id");

header('Location: /admin');
?>