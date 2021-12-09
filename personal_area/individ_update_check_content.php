<?php
    session_start();

    if(!$_SESSION["admin"]){
        header('Location: /auth');
    }

    require_once "connect.php";

    $title= $_POST["title"];
    $less_number=$_POST["less_number"];
    $purpose=$_POST["purpose"];
    $result=$_POST["result"];
    $audio_txt=$_POST["audio_txt"];
    $content= $_POST["content"];
    $id= $_POST["id"];
    $query = "INSERT INTO `individ_content` (`id`, `title`, `purpose`, `result`, `theory_content`, `audio_txt`, `audio`) VALUES (NULL, '$title', '$purpose', '$result', '$content', '$audio_txt', 'audio') ";

    if (true) {
        mysqli_query($mysqli, $query) or die(mysqli_error() .$query);

        $content_id = mysqli_insert_id($mysqli);

        mysqli_query($mysqli, "INSERT INTO `users_individ_content` (`id`, `id_users`, `id_individ_content`, `less_number`) VALUES (NULL, '$id', '$content_id', '$less_number')");

        //var_dump(mysqli_insert_id($mysqli));

        header('Location: /admin');
    }
    

    ?>