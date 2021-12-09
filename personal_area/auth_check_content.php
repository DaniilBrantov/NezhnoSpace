<?php
    session_start();
    require_once 'connect.php';
    
    $mail=$_POST['mail'];
    $pass= $_POST['pass'];
    $pass= md5($pass."lksd4fvm879");

    $error_fields=[];
    if ($mail === "" ){
        $error_fields[]= "mail";
    }
    if($pass=== ""){
        $error_fields[]= "pass";
    }
    if(!empty($error_fields)){
        $response=[
            "status"=> false,
            "type"=> 1,
            "message"=> "Проверьте правильность полей",
            "fields"=>$error_fields
        ];

        echo json_encode($response);

        die();
    };

    


    $sql="SELECT * FROM `users` WHERE `mail` = '$mail' AND `password` = '$pass'";
    $result=mysqli_query($mysqli,$sql);
    if (mysqli_num_rows($result)>0){
        $user=mysqli_fetch_assoc($result);

        $_SESSION["user"]=[
            "id"=>$user["id"],
            "name"=>$user["name"],
            "mail"=>$user["mail"],
        ];

        $response= [
            "status"=> true
        ];
        echo json_encode($response);

    }else{
        // $_SESSION['err_pass']='Не верный логин или пароль';
        // header('Location: /auth');

        $response= [
            "status" => false,
            "message" => 'Не верный логин или пароль'
        ];

        echo json_encode($response);
    }




// ob_start();

// $user=$result->fetch_assoc();
//     if (count($user)== 0) {
//         echo "пользов не найден!";
//         exit();
//     }
//     print_r($user);
//     exit(); 

//         $user=$result->fetch_assoc();
//     if(count($user)==0){
//         echo "Пользов не найден";
//         exit();
//     }
//     setcookie('user',$user['mail'],time()+3600*48,"/");
//     $mysqli->close();

?>





