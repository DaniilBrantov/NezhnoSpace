<?php
session_start();
if((!$_SESSION['user'])) {
    if(!isset($_GET["hidden_form"])){

?>



<div class="center_block">
                <h2>Восстановление пароля</h2>
                <form action="send_link_reset_password" method="post" name="form_request_email" >
                    <div class="reset_pass">
                        <div class="rest_pass_item">
                            <label>E-mail: </label>
                            <input type="email" name="email" >
                        </div>
                        <p class="text_center mesage_error" id="valid_email_message"></p>
                        <?php 
                        if(isset($_SESSION["error_messages"]) && !empty($_SESSION["error_messages"])){
                            echo $_SESSION["error_messages"];
                            unset($_SESSION["error_messages"]);
                        }
                        if(isset($_SESSION["success_messages"]) && !empty($_SESSION["success_messages"])){
                            echo $_SESSION["success_messages"];
                            unset($_SESSION["success_messages"]);
                        } ?>
                        <div class="rest_pass_item">
                            <input type="submit" name="send" value="Восстановить">
                        </div>
                    </div>
                </form>
            </div>
<?php }
}else{ header('Location: auth'); } ?>