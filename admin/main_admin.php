<?php
/**
 * Template Name: admin
 *
 
 */



$email = 'daniil.brantov04@mail.ru';
$status = 2;
$pay_choice = 1;
$date = date("Y-m-d H:i:s");

$user_data=[
    'mail' => $email,
    'status' => $status,
    'pay_choice' => $pay_choice,
    'date' => $date,
];
$user_data=json_encode($user_data);
// обьект с данными хранится в tokens, а после регистрации и проверки токена сразу же добавляются поля из обьекта
$result = sendRegistrationLink($email, $user_data);
if ($result) {
    echo $result;
} else {
    echo 'Failed to send the registration link.';
}

function sendRegistrationLink($email, $user_data) {
    require_once( get_theme_file_path('send_mail.php') );
    $registrationPage = 'https://nezhno.space/registration';
    $token = generateUniqueToken();
    storeToken( $email, $token, $user_data );

    $registrationLink = $registrationPage . '?token=' . urlencode($token);
    $subject = 'Registration Link';
    $message = 'Please click on the following link to register: ' . $registrationLink;
    $result = SendMail($email, $subject, $message,$subject);
    if ($result) {
        return $result; // Email sent successfully
    } else {
        return false; // Failed to send email
    }
}

function generateUniqueToken($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $token = '';
    $charactersLength = strlen($characters);
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = mt_rand(0, $charactersLength - 1);
        $token .= $characters[$randomIndex];
    }
    return $token;
}

function storeToken($email, $token, $user_data) {
    require_once(get_theme_file_path('processing.php'));
    $db = new SafeMySQL();
    $query = "INSERT INTO tokens (mail, token, info) VALUES ('$email', '$token', '$user_data')";
    if ($db->query($query)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

?>





<br><br><br><br><br><br><br>


<div class="add_post">
    <h2>
        Добавить запись
    </h2>
    <form action="admin_check">
        <input name="title" type="text">
        <input name="excerpt" type="text">
        <input name="content" type="text">
        <?php
            $categories = get_terms( array( 'taxonomy' => 'category', 'orderby' => 'name', 'hide_empty' => 0 ) );
            if( $categories ){
                foreach ( $categories as $cat ){
                    echo "<input type=\"radio\" name=\"category\" id=\"{$cat->term_id}\" value=\"{$cat->term_id}\">{$cat->name}</input>";
                }
            };
        ?>
        <input name="add_post" type="submit">
    </form>
</div>
<div class="add_payment_user">
    <h2>Добавить пользователя, который оплатил</h2>
    <form action="admin_check">
        <input name="add_payment_mail" type="text">
        <input name="add_payment_choice" type="number">
        <input name="add_payment_mail" type="text">
    </form>
</div>