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
            "surname"=>$user["surname"],
            "sex"=>$user["sex"],
            "age"=>$user["age"],
            "mail"=>$user["mail"],
            "payment"=>$user["payment"],
            "avatar"=>$user["avatar"],
        ];

        $response= [
            "status"=> true
        ];
        echo json_encode($response);

    }else{
        $response= [
            "status" => false,
            "message" => 'Не верный логин или пароль'
        ];

        echo json_encode($response);
    }
    if($_POST["main"]){
        $_SESSION["stages"]=[
        "main"=> $_POST["main"],
        "individual"=> $_POST["individual"],
        "all_main"=> $_POST["all_main"],
        ];
    };
    if($_POST["route_val"]){
        $_SESSION["user"]["route_value"]=$_POST["route_val"];
    }
    if($_POST["change_material"]){
        $email= $_SESSION["user"]["mail"];
        $sql="SELECT * FROM `users` WHERE `mail` = '$email' ";
        $users=mysqli_fetch_assoc(mysqli_query($mysqli,$sql));
        if($users["payment"]=='4'){
            if($_SESSION["user"]["payment"] == '4' || $_SESSION["user"]["payment"] == '2'){
                $_SESSION["user"]["payment"]= '1';
            }else{
                $_SESSION["user"]["payment"]= '2';
            }
        }elseif($users["payment"]=='1'){
            if($_SESSION["user"]["payment"] == '1'){
                $_SESSION["user"]["payment"] = '5';
            }else{
                $_SESSION["user"]["payment"] = '1';
            }
        }elseif($users["payment"] == '2'){
            if($_SESSION["user"]["payment"] == '2'){
                $_SESSION["user"]["payment"]= '3';
            }else{
                $_SESSION["user"]["payment"]= '2';
            }
        }elseif($users["payment"] == '0'){
            if($_SESSION["user"]["payment"] == '0'){
                $_SESSION["user"]["payment"]= '5';
            }else{
                $_SESSION["user"]["payment"]= '0';
            }
        }elseif($users["payment"] == '3'){
            if($_SESSION["user"]["payment"] == '3'){
                $_SESSION["user"]["payment"]= '5';
            }else{
                $_SESSION["user"]["payment"]= '3';
            }
        }
        header('Location: /my_account');
    }



?>
