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
$second_audio_txt=$_POST["second_audio_txt"];
$less_number=$_POST["less_number"];
$img=$_FILES["image"]['tmp_name'];
$video= str_replace("https://youtu.be/","https://www.youtube.com/embed/",$_POST["video"]);

if(!empty($img))
    $image=addslashes(file_get_contents($img));
    $name = $_FILES['audio']['name'];
    $second_audio= $_FILES['second_audio']['name'];
    $second_tmp_name=$_FILES['second_audio']['tmp_name'];
    $tmp_name=$_FILES['audio']['tmp_name'];
    chdir('wp-content/themes/my-theme/personal_area/audio/');
    getcwd();
    $audio_path= getcwd().'/'.$name;
    $second_audio_path= getcwd().'/'.$second_audio;
    if (move_uploaded_file($tmp_name,$audio_path) && move_uploaded_file($second_tmp_name,$second_audio_path)) {
        mysqli_query($mysqli,"INSERT INTO `main_stages` (`id`,`less_number`, `title`, `description`,`purpose`,`result`, `theory_txt`,`audio_txt`,`second_audio_txt`,`audio`,`second_audio`,`image`,`video`) VALUES (NULL, '$less_number', '$title', '$description','$purpose','$result', '$content','$audio_txt', '$second_audio_txt', '$name', '$second_audio','$image','$video') ");
    }
    else{
        unset($_SESSION['user']);
        unset($_SESSION['admin']);
        header('Location: /');
    };

header('Location: /admin');
?>