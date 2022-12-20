<?php
/**
 * Template Name: activation
 *

 */
get_header();
require_once( get_theme_file_path('processing.php') );
require_once( get_theme_file_path('send_mail.php') );
$msg='';
if(!empty($_GET['code']) && isset($_GET['code'])){
    $code=mysql_real_escape_string($_GET['code']);
    $c=$db->query("SELECT id FROM users WHERE activation='$code'");
    if($db->numRows($c) > 0){
        $count=$db->query("SELECT id FROM users WHERE activation='$code' and status='0'");
        if(mysqli_num_rows($count) == 1){
            $db->query("UPDATE users SET status='1' WHERE activation='$code'");
            $msg="Ваш аккаунт активирован"; 
        }else{
            $msg ="Ваш аккаунт уже активирован, нет необходимости активировать его снова.";
        }
    }else{
        $msg ="Неверный код активации.";
    }
}else{
    if($_POST["activation_btn"]){
        $hash=$db->getOne("SELECT activation FROM users WHERE id=?i", $_SESSION['id']); 
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

        SendMail('daniil.brantov04@mail.ru', $mail_subject, $mail_body,$mail_title);
    }else{ ?>
<form>
    <button name="activation_btn" id="activation_btn" class="blue_btn" type="submit">Отправить</button>
</form>
<?php
    };
}
get_footer();

?>