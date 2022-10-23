<?php 
$servername = "localhost";
$username = "*";
$password = "*";
$database = "*";
$mysqli= mysqli_connect($servername, $username , $password, $database) or die(mysqli_connect_error());

    mysqli_query($mysqli, 'set character_set_client="utf8"');
    mysqli_query($mysqli, 'set character_set_results="utf8"');
    mysqli_query($mysqli, 'set collation_connection="utf8_unicode_ci"');

$users=mysqli_query($mysqli,"SELECT * FROM `users`");
    $users_arr=[];
    while($person = mysqli_fetch_assoc($users)){
        $users_arr[$person["name"]]=$person["mail"];
    }



    $address_site = "https://nezhno.space/";





$variables= mysqli_query($mysqli,"SELECT * FROM `main_stages` ");
        $vars=[];
        while($var = mysqli_fetch_assoc($variables)){
            $vars[$var["title"]]=$var["description"];
        }







        function IndividualContentTitle($les_number,$mysqli){
            $session_id=$_SESSION['user']['id'];
            $les_num_query="SELECT * FROM `users_individ_content` WHERE `id_users`='$session_id' AND `less_number`='$les_number'";
            $les_num=mysqli_query($mysqli,$les_num_query) or die("ERROR: ".mysqli_error($mysqli));
            $id_indiv_cnt= mysqli_fetch_assoc($les_num)["id_individ_content"];
            $indiv_cont_query="SELECT * FROM `individ_content` WHERE `id`='$id_indiv_cnt'";
            $indiv_cont=mysqli_query($mysqli,$indiv_cont_query) or die(mysqli_error() .$indiv_cont_query);
            $individ_content= mysqli_fetch_assoc($indiv_cont);
            if ($individ_content["title"]=="") {
                echo "{$les_number} шаг Индивидуального Маршрута";
            }else{
                echo $individ_content["title"];
            }
            
        };




    ?>