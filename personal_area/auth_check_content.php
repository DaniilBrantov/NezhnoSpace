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
        ];
    }
    if($_POST["answer"]){
        $user_id=$_SESSION["user"]["id"];
        $route_value= $_POST["answer"];
        mysqli_query($mysqli,"UPDATE `users` SET `route_value`='$route_value' WHERE `users`.`id` = '$user_id'");
        header('Location: first-stage-individual');
    }

?>





