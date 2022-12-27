<?php
/**
 * Template Name: send_link_reset_pass
 *
 
 */
    require_once( get_theme_file_path('processing.php') );
    require_once( get_theme_file_path('send_mail.php') );

    
    if($_POST['reset_btn']){
        $error=resetPassValid();
        if($error){
            echo json_encode($error);
        }else{
            echo json_encode(send($url));
        }
    }
    

    function resetPassValid(){
        $db = new SafeMySQL();

        $error=false;
        if(isset($_POST["mail"]) && $_POST['mail'] != "" && !empty($_POST["mail"])){
            $mail=trim($_POST["mail"]);
            if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $mail)) {
                $error = 'Неверно введен е-mail';
            }else{
                $reset_pass_rez=$db->query("SELECT * FROM users WHERE mail=?s",$mail);
                if (!$db->numRows($reset_pass_rez) == 1){ 
                    $error = "Такого пользователя не существует";
                }
            }
        }else{
            $error = "Вы не ввели email"; 
        }
        return $error;
    }


    function send($url){
        $mail=trim($_POST["mail"]);
        $db = new SafeMySQL();
        $token=md5($mail.time());
        $query_update_token = $db->query("UPDATE users SET reset_pass_token = '$token' WHERE mail=?s",$mail);
        $token = $db->getOne("SELECT reset_pass_token FROM users WHERE mail=?s",$_POST['mail']);
        
        if($query_update_token && $token){
            $mail_body='<p style="margin:0;">
                Пожалуйста, перейдите по ссылке ниже, чтобы восстановить пароль и получить доступ к нему.
            </p>
            <a href="'.$url.'/set_new_password?email='.$mail.'&token='.$token.'" style="
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
                    Перейти
                </button> </a>';
            $mail_title="Восстановление пароля на платформе NezhnoSpace";
            $mail_subject="Восстановление пароля";

            $status = SendMail($mail, $mail_subject, $mail_body,$mail_title)['status'];
        }else{
            $status = "Ошибка сохранения токена";
        };
        return $status;
    };
?>