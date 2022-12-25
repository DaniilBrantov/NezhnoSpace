<div class="authorization">
    <div class="reg_auth">
        <form class="reset_password_form authorization_form">
            <div class="pers_item">
                <label>Введите подтвержденный email, и мы вышлем ссылку для сброса пароля</label>
                <input type="text" name="mail" placeholder="Введите email...">
            </div>
            <div class="pers_btn">
                <button name="reset_btn" id="reset_btn" class="blue_btn" type="submit">Отправить</button>
            </div>
        </form>
    </div>
</div>







<?php
// session_start();
// if((!$_SESSION['user'])) {
//     if(!isset($_GET["hidden_form"])){

?>
<!-- 

<div class="wrapper_reset_pass">
    <div class="container">
                <h2 class="pers_title">Восстановление пароля</h2>
                <?php
                // if(isset($_SESSION["success_messages"]) && !empty($_SESSION["success_messages"])){
                //     echo $_SESSION["success_messages"];
                //     unset($_SESSION["success_messages"]);
                // }else{ ?>
                <form class="pers_form" action="send_link_reset_password" method="post" name="form_request_email" >
                    <div class="reset_pass">
                        <div class="pers_item">
                            <input class="pers_input" type="mail" name="reset_email" required><br>
                            <label class="pers_label">E-mail</label>
                        </div>
                        <p class="mesage_error" id="valid_email_message"></p>
                        <?php 
                        // if(isset($_SESSION["error_messages"]) && !empty($_SESSION["error_messages"])){
                        //     echo $_SESSION["error_messages"];
                        //     unset($_SESSION["error_messages"]);
                        //}
                        ?>
                        <div class="rest_pass_item">
                            <input class="auth_btn" type="submit" name="reset_send" value="Восстановить">
                        </div>
                    </div>
                </form>
                <?php //}; ?>
    </div>
</div> -->
<?php //}
// }else{ header('Location: auth'); } ?>