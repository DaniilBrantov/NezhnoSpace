<?php
/**
 * Template Name: send_mail
 *
 
 */
require_once( "wp-config.php" );

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function SendMail($smtp_recipient_mail,$mail_subject, $mail_body,$mail_title){

	$mail = new PHPMailer(true);
	$mail_errors=[];
	$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];

	$smtp_host=SMTP_HOST;
	$smtp_username=SMTP_USERNAME;
	$smtp_password=SMTP_PASSWORD;
	$smtp_port=SMTP_PORT;


	$mail_pattern='<div class="mail" style="
			max-width: 600px;
			font-family: Montserrat,sans-serif;
			background: whitesmoke;
			border-radius: 20px;
			padding: 25px;
			color: #111111;
			display: grid;
			gap: 20px;
			margin: auto;
		">
		<h1 style="
				font-size: 24px;
				font-weight: normal;
				margin:0;
			">
			'.$mail_title.'
		</h1>'.$mail_body.'
		<p style="color:#555555; font-size:13px; margin:0;">
			И проведи этот день нежно к себе. Удачи!
		</p>
		<a href="'.$url.'" style="color:#555555; font-size:13px">NezhnoSpace</a>
		</div>';

try {
	//Server settings
	// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
	$mail->setFrom($smtp_username, SMTP_FROMNAME);



	$mail->ClearAttachments(); // если в объекте уже содержатся вложения, очищаем их
	$mail->ClearCustomHeaders(); // то же самое касается заголовков письма
	$mail->ClearReplyTos();
	$mail->Subject = $mail_subject;
	$mail->SingleTo = true;
	$mail->ContentType = 'text/html';
	$mail->IsHTML( true );
	$mail->CharSet = 'utf-8'; // кодировка письма
	$mail->ClearAllRecipients(); // очищаем всех получателей
	$mail->AddAddress($smtp_recipient_mail);
	$mail->Body = $mail_pattern;
	//$mail->AddAttachment(getcwd() . '/plugins/' . $plugin_name . '.zip', $plugin_name . '.zip'); // добавляем вложение
	$mail->send();

	$mail_errors['status']=true;
} catch (Exception $e) {
	$mail_errors['error_msg'] = "Сообщение не удалось отправить. Ошибка почтовой программы: {$mail->ErrorInfo}";
	$mail_errors['status']=false;
};
return $mail_errors;

};




?>