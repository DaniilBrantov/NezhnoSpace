<?php
$db = new SafeMySQL();
$user_alarm=$_POST['user_alarm'];
$mail=$_SESSION['id'];

// Сохраняем таблицу
if($db->query("UPDATE users SET user_alarm =?s WHERE id=?i", $user_alarm, $mail )){
    echo json_encode(TRUE);
}

?>