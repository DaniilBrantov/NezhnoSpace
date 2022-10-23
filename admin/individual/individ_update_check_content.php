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
    $audio = $_FILES['audio']['name'];
    $audio_tmp_name=$_FILES['audio']['tmp_name'];

    chdir('wp-content/themes/my-theme/personal_area/audio/');
    getcwd();
    $audio_path= getcwd().'/'.$audio;
    if (move_uploaded_file($audio_tmp_name,$audio_path)) {
        $query = "INSERT INTO `individ_content` (`id`, `title`, `purpose`, `result`, `theory_content`, `audio_txt`, `audio`) VALUES (NULL, '$title', '$purpose', '$result', '$content', '$audio_txt', '$audio') ";
        mysqli_query($mysqli, $query) or die(mysqli_error() .$query);

        $content_id = mysqli_insert_id($mysqli);

        mysqli_query($mysqli, "INSERT INTO `users_individ_content` (`id`, `id_users`, `id_individ_content`, `less_number`) VALUES (NULL, '$id', '$content_id', '$less_number')");

        header('Location: /admin');
    }else if(!move_uploaded_file($audio_tmp_name,$audio_path)){
        $query = "INSERT INTO `individ_content` (`id`, `title`, `purpose`, `result`, `theory_content`, `audio_txt`) VALUES (NULL, '$title', '$purpose', '$result', '$content', '$audio_txt') ";
        mysqli_query($mysqli, $query) or die(mysqli_error() .$query);

        $content_id = mysqli_insert_id($mysqli);

        mysqli_query($mysqli, "INSERT INTO `users_individ_content` (`id`, `id_users`, `id_individ_content`, `less_number`) VALUES (NULL, '$id', '$content_id', '$less_number')");

        header('Location: /admin');
    }
    

    ?>