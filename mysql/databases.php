<?php
//$bd_connetction = mysqli_connect("localhost" , "root", "" ,"my_blog_bd");
//$bd_connetction = mysqli_connect("localhost" , "u1248733_default", "PJ9MP_hQ" ,"u1248733_default");
$bd_connetction = mysqli_connect("localhost","u1301732_e-i","0N6g7R8v","u1301732_eat_intelligent");

if (!$bd_connetction) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($bd_connetction, 'utf8'); // выбор кодировки
$bd = mysqli_query($bd_connetction, "SELECT * FROM Eat_Intelligent") ;

$result= mysqli_query($bd_connetction,"SELECT * FROM `article`");
    while ($row = mysqli_fetch_assoc($result))
        {
            $blogs[] = $row;   
        }
    $reverse_blogs = array_reverse($blogs);


?>



