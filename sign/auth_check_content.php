<?php
    require_once( get_theme_file_path('processing.php') );
    //если передана переменная action, «разавторизируем» пользователя
    if($_GET['action'] == "out") out(); 
    if (login()){
        $UID = $_SESSION['id'];
        $error=[];
        $error['status']=true;
        echo json_encode($error);
    }else {
        if(isset($_POST['auth_btn'])){
            $error=enter();
            if (count($error) == 0){
                $UID = $_SESSION['id'];
                $error['status']=true;
                $error['id']=$UID;
                echo json_encode($error);
            }else{
                //функция входа на сайт
                $error['status']=false;
                echo json_encode($error);
            }
        }else{
            var_dump( TgLogin() );
        }
    }

function TgLogin(){
    $telegramLogin = new TelegramLogin('NezhnoSpacebot');
    $telegramLoginResult = $telegramLogin->processTelegramLogin();
    if($telegramLoginResult["success"]){
        $db = new SafeMySQL();
        $username=$telegramLoginResult["message"]["username"];
        $tg_data=$db->query("SELECT * FROM users WHERE username=?s",$username);
        if($db->numRows($tg_data) < 1){
            if($res = $telegramLogin->saveTelegramUserData($telegramLoginResult["message"])){
                return '$res';
            }else{
                return $res;
            }
        }else{
            return $tg_data;
        }
    }else{
        return '$telegramLoginResult';
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
                $error['pass'] = "Неверный пароль";                                       
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
    $db = new SafeMySQL(); 
    ini_set ("session.use_trans_sid", true);   
    session_start();  

    if (isset($_SESSION['id'])){

        //если cookie есть, обновляется время их жизни и возвращается true     
        if(isset($_COOKIE['mail']) && isset($_COOKIE['pass'])){           
            SetCookie("mail", "", time() - 1, '/');
            SetCookie("pass","", time() - 1, '/');          
            setcookie ("mail", $_COOKIE['mail'], time() + 50000, '/');            
            setcookie ("pass", $_COOKIE['pass'], time() + 50000, '/');          
            $id = $_SESSION['id'];          
            lastAct($id);           
            return true;        
        }else{   
            //иначе добавляются cookie с email и паролем, чтобы после перезапуска браузера сессия не слетала     
            $rez = $db->query("SELECT * FROM users WHERE id='{$_SESSION['id']}'"); 

            if ($db->numRows($rez) == 1){   
                $row = $db->getAll("SELECT * FROM users WHERE mail=?s",$_POST['mail'])[0];    
                //$row = mysql_fetch_assoc($rez); //она записывается в ассоциативный массив               
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
            $rez = $db->query("SELECT * FROM users WHERE mail='{$_COOKIE['mail']}'"); //запрашивается строка с искомым логином и паролем             
            @$row = $db->getAll("SELECT * FROM users WHERE mail=?s",$_POST['mail'])[0];
            //@$row = mysql_fetch_assoc($rez);            
            if($db->numRows($rez) == 1 && md5($row['mail'].$row['password']) == $_COOKIE['password']){               
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

?>