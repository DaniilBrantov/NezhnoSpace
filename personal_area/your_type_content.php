<?php
    session_start();
    require_once 'connect.php';

if($_POST["answer"] || $_POST["form_name"]){
    if($_POST["user_tel"]){
        $user_tel=$_POST["user_tel"];
    }else{
        $user_tel="0";
    };
    $user_id=$_SESSION["user"]["id"];
    $route_value = $_POST["answer"];
    if($_SESSION["user"]){
        if($_POST["answer"]){
            mysqli_query($mysqli,"UPDATE `users` SET `route_value`='$route_value' WHERE `users`.`id` = '$user_id'");
            header('Location: first-stage-individual');
        }elseif($_POST["form_name"]){
            if($_POST['order'] && $_POST['sum']){
                $_SESSION["user"]["full_name"] =$_POST["form_name"];
                $_SESSION["user"]["order"] = $_POST['order'];
                $_SESSION["user"]["sum"] = $_POST['sum'];
                $_SESSION["user"]["rate"] = $_POST['rate'];
                if($_POST["user_tel"]){
                    mysqli_query($mysqli,"UPDATE `users` SET `telephone` = '$user_tel' WHERE `users`.`id` = '$user_id'");
                }
            };
            header('Location: payment');
        }
    }else{
        if($_POST["user_mail"]){
            $user_mail = $_POST["user_mail"];
        }else{
            $user_mail = $_POST["form_mail"];
        }
        $check_user=mysqli_query($mysqli, "SELECT * FROM `users` WHERE `mail` = '$user_mail'");
        if (mysqli_num_rows($check_user)>0){
            header('Location: auth');
        }else{
            if($_POST["user_name"]){
                $user_name = $_POST["user_name"];
            }else{
                $user_name = $_POST["form_name"];
                if( explode(' ', $user_name)[1]){
                    $user_name= explode(' ', $user_name)[1];
                }
            }
            $password = "";
            $arr = array(
                    'a', 'b', 'c', 'd', 'e', 'f',
                    'g', 'h', 'i', 'j', 'k', 'l',
                    'm', 'n', 'o', 'p', 'q', 'r',
                    's', 't', 'u', 'v', 'w', 'x',
                    'y', 'z', 'A', 'B', 'C', 'D',
                    'E', 'F', 'G', 'H', 'I', 'J',
                    'K', 'L', 'M', 'N', 'O', 'P',
                    'Q', 'R', 'S', 'T', 'U', 'V',
                    'W', 'X', 'Y', 'Z', '1', '2',
                    '3', '4', '5', '6', '7', '8',
                    '9', '0', '#', '!', "?", "&"
            );
            for ($i = 0; $i < 9; $i++){
                $password .= $arr[mt_rand(0, count($arr) - 1)]; // Берём случайный элемент из массива
            }
            $sql="SELECT * FROM `users` WHERE `mail` = '$user_mail' AND `password` = '$pass'";
            $result=mysqli_query($mysqli,$sql);
            if (mysqli_num_rows($result)>0){
                header('Location: auth');
            }else{

                
                if (strlen($password) > 7 && !preg_match("[aA-zZ0-9]",$password)) {
                    $pass= md5($password."lksd4fvm879");
                    mysqli_query($mysqli,"INSERT INTO `users` (`name`, `telephone`, `mail`, `password`,`route_value`) VALUES ('$user_name','$user_tel','$user_mail','$pass','$route_value') ");

                    // $email = new \PHPMailer\PHPMailer\PHPMailer();
                    // $email->CharSet = 'utf-8';
                    // $email->isSMTP();
                    // $email->Host = 'smtp.yandex.ru';
                    // $email->SMTPAuth = true;                              
                    // $email->Username = 'yourmail@yandex.ru'; 
                    // $email->Password = '***';
                    // $email->SMTPSecure = 'ssl';
                    // $email->Port = 465; 

                    // $email->setFrom('yourmail@yandex.ru');
                    // $email->addAddress($user_mail);    
                    // $email->isHTML(true);                                 

                    $email->Subject = 'Тема';
                    if($_POST["user_mail"]){
                    $email->Body    =  'HI!';
}else{
$email->Body = '

<div style="
                        background: #1C1C1C;
                        color: whitesmoke;
                        padding: 30px;
                        margin: 30px;
                        border-radius: 20px;
                        margin: 30px auto;
                        max-width: 500px;">

    <h2>
        Чао Белла!
    </h2>
    <p>Твоя регистрация на онлайн занятие прошла успешно. </p>
    <p>Вот всё,что тебе нужно, чтобы попасть в твой личный кабинет, ждем тебя там :</p>
    <span style="font-weight:bold;">логин:</span><span style="margin: 50px; font-size: 20px;"><a
            href="/compose?To='.$user_mail.'"
            style=" color: whitesmoke; text-decoration:none;">'.$user_mail.'</a></span><br><br>
    <span style="font-weight:bold;">пароль:</span><span style="margin: 50px; font-size: 20px;">'.$password.'</span>
    <p>Ждём тебя 26 мая в 19:00</p>
    <p>Ссылку на конференцию пришлем за сутки до занятия на эту почту.</p>
    <p>С заботой,</p>
    <p>Команда Eat Intelligent.</p>
</div>
';
};
//$email->AltBody = '';

if(!$email->send()) {
echo 'Error';
} else {
$sql="SELECT * FROM `users` WHERE `mail` = '$user_mail' AND `password` = '$pass'";
$result=mysqli_query($mysqli,$sql);
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
if($_POST['order'] && $_POST['sum']){
$_SESSION["user"]["full_name"] =$_POST["form_name"];
$_SESSION["user"]["order"] = $_POST['order'];
$_SESSION["user"]["sum"] = $_POST['sum'];
$_SESSION["user"]["rate"] = $_POST['rate'];
header('Location: payment');
}else{
echo '
<div class="wrapper_your_type">
    <div class="your_type">
        <h1>Ваш аккаунт успешно создан! Проверьте почту,чтобы узнать логин и пароль!</h1>
        <div class="general_btn">
            <a href="first-stage-individual">
                <button>
                    <img src="'. get_template_directory_uri() .'/images/account_arrow.svg" alt="">
                </button>
            </a>
        </div>
    </div>
</div>
';
}
}
};
}
}
}

}
else{
header('Location: first-stage-individual');
}


?>