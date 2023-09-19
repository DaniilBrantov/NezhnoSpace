<?php get_header(); 

if(!empty($_GET['code']) && isset($_GET['code'])){
    require_once( get_theme_file_path('sign/activation_check.php') );
}else{
?>

<div class="authorization">
    <form>
        <div class="activation">
            <p class="activation_title">
                Подтверждение почтового адреса
            </p>
            <p class="activation_txt">
                На Ваш почтовый ящик будет отправлено сообщение, содержащее ссылку для подтверждения правильности e-mail
                адреса. Пожалуйста, перейдите по ссылке для завершения подписки.
            </p>
            <div class="activation_btn">
                <button name="activation_btn" id="activation_btn" class="blue_btn" type="submit">Отправить</button>
            </div>
            <p class="activation_txt_info">
                Если письмо не пришло в течение 15 минут, проверьте папку «Спам». Если письмо вдруг попало в эту папку,
                откройте письмо, нажмите кнопку «Не спам» и перейдите по ссылке подтверждения. Если же письма нет и в
                папке
                «Спам», попробуйте подписаться ещё раз. Возможно, вы ошиблись при вводе адреса.
            </p>
        </div>
    </form>
</div>

<?php
};
get_footer(); ?>