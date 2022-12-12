<?php
    require_once( get_theme_file_path('processing.php') );

    //если передана переменная action, «разавторизируем» пользователя
    if($_GET['action'] == "out") out(); 

    if (login()){
        $UID = $_SESSION['id'];
        echo json_encode($error);
    }else {
        if(isset($_POST['auth_btn'])){
            $error=enter();
            if (count($error) == 0){
                $UID = $_SESSION['id'];
                $error['status']=true;
                echo json_encode($error);
            }else{
                //функция входа на сайт
                $error['status']=false;
                echo json_encode($error);
            }
        }
    }



function enter (){ 
    $db = new SafeMySQL();
    $error = [];

    if ($_POST['mail'] != "" && $_POST['pass'] != ""){       
        $mail=$_POST['mail']; 
        $pass=$_POST['pass'];
        $enter_rez=$db->query("SELECT * FROM users WHERE mail=?s",$_POST['mail']);

        if ($db->numRows($enter_rez) == 1){  
            $row = $db->getAll("SELECT * FROM users WHERE mail=?s",$_POST['mail'])[0];             
            if (password_verify($pass, $row['password'])){ 
                    setcookie ("mail", $row['mail'], time() + 50000);                         
                    setcookie ("pass", md5($row['mail'].$row['password']), time() + 50000);                    
                    $_SESSION['id'] = $row['id'];               
                    $id = $_SESSION['id'];   
                    lastAct($id);           
                    return $error;          
            }else{               
                $error['mail'] = "Неверный пароль";                                       
                return $error;          
            }       
        }else{           
            $error['mail'] = "Такого пользователя не существует";           
            return $error;      
        }   
    }else{    

        if($_POST['mail'] === ""){
            $error['mail'] = "Вы не ввели email";              
        }
        if($_POST['pass'] === ""){
            $error['pass'] = "Вы не ввели пароль";              
        }
        return $error; 

    }
}

function lastAct($id){
    $db = new SafeMySQL(); 
    $tm = time();   
    $db->query("UPDATE users SET online='$tm', last_act='$tm' WHERE id='$id'"); 
}




function login () {     
    ini_set ("session.use_trans_sid", true);   
    session_start();    

    if (isset($_SESSION['id'])){

        //если cookie есть, обновляется время их жизни и возвращается true     
        if(isset($_COOKIE['mail']) && isset($_COOKIE['pass'])){           
            SetCookie("mail", "", time() - 1, '/');            SetCookie("pass","", time() - 1, '/');          
            setcookie ("mail", $_COOKIE['mail'], time() + 50000, '/');            
            setcookie ("pass", $_COOKIE['pass'], time() + 50000, '/');          
            $id = $_SESSION['id'];          
            lastAct($id);           
            return true;        
        }else{   
            //иначе добавляются cookie с email и паролем, чтобы после перезапуска браузера сессия не слетала     
            $rez = $db->rawQuery("SELECT * FROM users WHERE id='{$_SESSION['id']}'"); 

            if ($db->numRows($rez) == 1){       
                $row = mysql_fetch_assoc($rez); //она записывается в ассоциативный массив               
                setcookie ("mail", $row['mail'], time()+50000, '/');              
                setcookie ("pass", md5($row['mail'].$row['password']), time() + 50000, '/'); 
        
                $id = $_SESSION['id'];
                lastAct($id); 
                return true;            
            }else {return false;}
        }   
    }else{    
        //если сессии нет, проверяется существование cookie. 
        //Если они существуют, проверяется их валидность по базе данных
        
        if(isset($_COOKIE['mail']) && isset($_COOKIE['pass'])){           
            $rez = $db->rawQuery("SELECT * FROM users WHERE mail='{$_COOKIE['mail']}'"); //запрашивается строка с искомым логином и паролем             
            @$row = mysql_fetch_assoc($rez);            
            if(@mysql_num_rows($rez) == 1 && md5($row['mail'].$row['password']) == $_COOKIE['password']){               
            $_SESSION['id'] = $row['id']; //записываем в сесиию id              
            $id = $_SESSION['id'];              
    
            lastAct($id);               
            return true;            
            }else{               
                SetCookie("mail", "", time() - 360000, '/');               
                SetCookie("pass", "", time() - 360000, '/');                    
                return false;           
            }       
        }else{return false;}   
    } 
}




//Выход из аккаунта
function out () {
    ini_set ("session.use_trans_sid", true);   
    session_start();
    $db = new SafeMySQL();   
    $id = $_SESSION['id'];              
    
    //обнуляется поле online, говорящее, что пользователь вышел
    //с сайта (пригодится в будущем)     
    $db->query("UPDATE users SET online=0 WHERE id='$id'");
    unset($_SESSION['id']); //удалятся переменная сессии    
    SetCookie("mail", ""); //удаляются cookie с логином    
    SetCookie("pass", ""); //удаляются cookie с паролем   
    
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
};
















    
    // $mail=$_POST['mail'];
    // $pass=password_verify($_POST['pass']);

    // if(empty($errors)) {
    //     $errors['status']=true;
    // } else {
    //     //Возвращать все ошибки
    //     $errors['status']=false;
    // };
    // echo json_encode($errors);


    // //Функции проверки авторизации
    // function checkAuth(string $mail, string $pass): bool {
    //     if($db->getRow("SELECT * FROM users WHERE mail=?s AND password=?s", $mail, $pass)){
    //         return true;
    //     }
    //     return false;
    // };

    // function CheckAuthErrors(string $mail, string $password){
    //     $errors=[];

    //     //Email
    //     if($mail == '') {$errors['mail'] = "Введите Email";}

    //     //Валидация email
    //     elseif (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $mail)) {$errors['mail'] = 'Неверно введен е-mail';}

    //     //Password
    //     if($pass == '') {$errors['pass'] = "Введите пароль";}

    //     //Недопустимая длина
    //     elseif (mb_strlen($pass) < 8){$errors['pass'] = "Недопустимая длина пароля";}

    //     //Проверка на уникальность email и password
    //     if(!checkAuth($mail,$pass)){$errors['mail'] = 'Такого пользователя не существует';}
    //     else{}

    //     if(empty($errors)) {
    //         $errors['status']=true;
    //         echo json_encode($errors);
    //     } else {
    //         //Возвращать все ошибки
    //         $errors['status']=false;
    //         echo json_encode($errors);
    //     };
    // }
























    











    // $mail=$_POST['mail'];
    // $pass= $_POST['pass'];
    // $pass= md5($pass."lksd4fvm879");

    // $error_fields=[];
    // if ($mail === "" ){
    //     $error_fields[]= "mail";
    // }
    // if($pass=== ""){
    //     $error_fields[]= "pass";
    // }
    // if(!empty($error_fields)){
    //     $response=[
    //         "status"=> false,
    //         "type"=> 1,
    //         "message"=> "Проверьте правильность полей",
    //         "fields"=>$error_fields
    //     ];

    //     echo json_encode($response);

    //     die();
    // };

    


    // $sql="SELECT * FROM `users` WHERE `mail` = '$mail' AND `password` = '$pass'";
    // $result=mysqli_query($mysqli,$sql);
    // if (mysqli_num_rows($result)>0){
    //     $user=mysqli_fetch_assoc($result);

    //     $_SESSION["user"]=[
    //         "id"=>$user["id"],
    //         "name"=>$user["name"],
    //         "surname"=>$user["surname"],
    //         "sex"=>$user["sex"],
    //         "age"=>$user["age"],
    //         "mail"=>$user["mail"],
    //         "payment"=>$user["payment"],
    //         "next_stage"=>$user["next_stage"],
    //         "avatar"=>$user["avatar"],
    //     ];

    //     $response= [
    //         "status"=> true
    //     ];
    //     echo json_encode($response);

    // }else{
    //     $response= [
    //         "status" => false,
    //         "message" => 'Не верный логин или пароль'
    //     ];

    //     echo json_encode($response);
    // }






















    // $email= $_SESSION["user"]["mail"];
    // $sql="SELECT * FROM `users` WHERE `mail` = '$email' ";
    // $users=mysqli_fetch_assoc(mysqli_query($mysqli,$sql));

    // if($_POST["main"]){
    //     $_SESSION["stages"]=[
    //     "main"=> $_POST["main"],
    //     "individual"=> $_POST["individual"],
    //     "all_main"=> $_POST["all_main"],
    //     ];
    // };
    // if($_POST["route_val"]){
    //     $_SESSION["user"]["route_value"]=$_POST["route_val"];
    // }
    // if($_POST["change_material"]){
    //     if($users["payment"]=='4'){
    //         if($_SESSION["user"]["payment"] == '4' || $_SESSION["user"]["payment"] == '2'){
    //             $_SESSION["user"]["payment"]= '1';
    //         }else{
    //             $_SESSION["user"]["payment"]= '2';
    //         }
    //     }elseif($users["payment"]=='1'){
    //         if($_SESSION["user"]["payment"] == '1'){
    //             $_SESSION["user"]["payment"] = '5';
    //         }else{
    //             $_SESSION["user"]["payment"] = '1';
    //         }
    //     }elseif($users["payment"] == '2'){
    //         if($_SESSION["user"]["payment"] == '2'){
    //             $_SESSION["user"]["payment"]= '3';
    //         }else{
    //             $_SESSION["user"]["payment"]= '2';
    //         }
    //     }elseif($users["payment"] == '0'){
    //         if($_SESSION["user"]["payment"] == '0'){
    //             $_SESSION["user"]["payment"]= '5';
    //         }else{
    //             $_SESSION["user"]["payment"]= '0';
    //         }
    //     }elseif($users["payment"] == '3'){
    //         if($_SESSION["user"]["payment"] == '3'){
    //             $_SESSION["user"]["payment"]= '5';
    //         }else{
    //             $_SESSION["user"]["payment"]= '3';
    //         }
    //     }else{
    //         if($_SESSION["user"]["payment"] == '6'){
    //             $_SESSION["user"]["payment"]= '5';
    //         }else{
    //             $_SESSION["user"]["payment"]= '6';
    //         }
    //     }
    //     header('Location: /my_account');
    // }

    // if($_POST["unsubscribe_form_btn"]){
    //     if($users["payment"]=='4'){
    //         $mysqli->query("UPDATE `users` SET `payment`='2',`payment_method`='' WHERE `mail`='$email'");
    //         $_SESSION["user"]["payment"]= '2';
    //     }elseif($users["payment"]=='1'){
    //         $mysqli->query("UPDATE `users` SET `payment`='6',`payment_method`='' WHERE `mail`='$email'");
    //         $_SESSION["user"]["payment"]= '6';
    //     }
    //     header('Location: /my_account');
    // }



?>