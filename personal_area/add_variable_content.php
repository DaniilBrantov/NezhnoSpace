<?php
    session_start();

    if(!$_SESSION["admin"]){
        header('Location: /auth');
    }


require_once "connect.php";

$title=$_POST["title"];
$description=$_POST["description"];
$purpose=$_POST["purpose"];
$result=$_POST["result"];
$content=$_POST["content"];
$audio_txt=$_POST["audio_txt"];
$less_number=$_POST["less_number"];
$img=$_FILES["image"]['tmp_name'];

if(!empty($img))
    $image=addslashes(file_get_contents($_FILES['image']['tmp_name']));

    mysqli_query($mysqli,"INSERT INTO `main_stages` (`id`,`less_number`, `title`, `description`,`purpose`,`result`, `theory_txt`,`audio_txt`,`audio`,`image`) VALUES (NULL, '$less_number', '$title', '$description','$purpose','$result', '$content','$audio_txt', '000','$image') ");


header('Location: /admin');
