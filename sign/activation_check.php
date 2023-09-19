<?php
/**
 * Template Name: activation_check
 *

 */

session_start();
require_once( get_theme_file_path('processing.php') );
require_once( get_theme_file_path('send_mail.php') );
$data=[];
if(!empty($_GET['code']) && isset($_GET['code'])){
    $code=$_GET['code'];
    $c=$db->query("SELECT id FROM users WHERE activation='$code'");
    if($db->numRows($c) > 0){
        $count=$db->query("SELECT id FROM users WHERE activation='$code' and status='0'");
        if(mysqli_num_rows($count) == 1){
            $db->query("UPDATE users SET status='1' WHERE activation='$code'");
            $data=[
                "status"=>true,
                "msg"=>"Ваш аккаунт активирован",
                ];
        }else{
            $data=[
                "status"=>true,
                "msg"=>"Ваш аккаунт уже активирован, нет необходимости активировать его снова",
                ];
        }

        echo '<div class="authorization">
            <div class="activation_msg">
                <img style="background: #6AFF8B;" src="'.get_template_directory_uri().'/images/check.svg" alt="Закрыть">
                <p>'.$data['msg'].'</p>
                <a href="account"><button class="blue_btn">Продолжить</button></a> 
            </div>
        </div>';
    }else{
            $data=[
                "status"=>false,
                "msg"=>"Неверный код активации.",
                ];

        echo '<div class="authorization">
            <div class="activation_msg">
                <img style="background: #FF6262;" src="'.get_template_directory_uri().'/images/close.svg" alt="Закрыть">
                <p>'.$data['msg'].'</p>
                <a href="activation"><button class="blue_btn">Вернуться назад</button></a> 
            </div>
        </div>';
    }
}else{
    $_POST["activation_btn"]=true;
    if($_POST["activation_btn"]){
        $row=$db->getAll("SELECT * FROM users WHERE id=?i", $_SESSION['id'])[0];
        $hash=$row['activation'];
        $mail=$row['mail'];
        $mail_body='<p style="margin:0;">
            Пожалуйста, перейдите по ссылке ниже, чтобы активировать свой профиль и получить доступ к нему.
        </p>
        <a href="'.$url.'/activation?code='.$hash.'" style="
                            text-decoration: none;
                    "><button style="
                        background: #421DD8;
                        color: whitesmoke;
                        padding: 12px 22px;
                        border-radius: 8px;
                        border:none;
                        cursor: pointer;
                        font-size: 16px;
                    ">
                Активировать
            </button> </a>';
        $mail_title="Благодарим вас за регистрацию на платформе NezhnoSpace";
        $mail_subject="Подтверждение электронной почты";

        echo json_encode(SendMail('daniil.brantov04@mail.ru', $mail_subject, $mail_body,$mail_title)) ;
    };
}

?>