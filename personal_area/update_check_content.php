<?php
    session_start();

    if(!$_SESSION["admin"]){
        header('Location: /auth');
    }

    require_once "connect.php";

    $less_number=$_POST["less_number"];
    $title=$_POST["title"];
    $description=$_POST["description"];
    $purpose=$_POST["purpose"];
    $result=$_POST["result"];
    $content=$_POST["content"];
    $audio_txt=$_POST["audio_txt"];
    $id= $_POST["id"];

    if ($id != "") {
        mysqli_query($mysqli, "UPDATE `main_stages` SET `less_number` = '$less_number', `title` = '$title', `description` = '$description',`purpose` = '$purpose', `result` = '$result', `theory_txt` = '$content', `audio_txt` = '$audio_txt'  WHERE `main_stages`.`id` = $id ");
    header('Location: /admin');
    }



    ?>