<?php
/**
 * Template Name: admin_check
 *
 
 */

// require_once('wp-load.php' );
// require_once( 'wp-admin/includes/admin.php');
// $title=$_POST['title'];
// $excerpt=$_POST['excerpt'];
// $content=$_POST['content'];
// $category=$_POST['category'];
// var_dump($title);
require_once(get_theme_file_path('processing.php'));

//! Написать функцию чтобы закрылся доступ до 01.06 
// Проверить работу оплаты


// Создать возможность добавления токена с полями mail,token,info через .csv file

// Создать возможность добавлять поля с полями mail,token,info, а также возможность их удалить и редактировать

// Создать форму html с полями name,surname,mail, 
// status(реализовать с помощью select, проходя по каждому 
// элементу и выводить данные из бд)

// класс, который позволяет добавить пользователя в БД. Ещё чтобы была возможность редактировать и удалять каждое поле







// Пример использования класс ChangeRole, 
// который меняет пользователям со статусом 3 
// на тот статус, что нужно. Добавление emails 
// происходит через csv

// $changeRole = new ChangeRole();
// $result = $changeRole->changeStatusForUsersFromCSV('wp-content/themes/my-theme/pdf_files/change_status.csv', 1);
// if ($result) {
//     echo "Статус успешно изменен для выбранных пользователей.";
// } else {
//     echo "Не удалось изменить статус для выбранных пользователей.";
// }




// Создаем объект класса addPromo
$add_promo = new addPromo();

// Вызываем метод add_promo_code() с нужными параметрами
$result = $add_promo->add_promo_code($_POST['promo'], $_POST['sale'], $_POST['first_date'], $_POST['last_date'], $_POST['paid_days']);

// Создаем массив с данными пользователя
$user_data = [
    'mail' => $_POST['email'],
    'status' => $_POST['status'],
    'pay_choice' => $_POST['pay_choice'],
    'date' => date("Y-m-d H:i:s"),
    'weeks' => $_POST['weeks'] ?? null,
];

$email = $_POST['email'];

// Проверяем наличие и заполненность обязательных полей
if(isset($email) && !empty($email) && isset($user_data) && !empty($user_data)) {
    $admin = new NewUserRole($user_data);
    // Отправляем ссылку для регистрации
    $admin->setUserData($_POST['email'],$_POST['status'],$_POST['pay_choice'],$_POST['weeks']);
    if ($result = $admin->sendRegistrationLink()) {
        // Выводим данные пользователя
        // var_dump($user_data);
    } else {
        echo 'Failed to send the registration link.';
    }
} else {
    echo 'Failed to send the registration link.';
}

// Выводим результат
var_dump($result);

































// function sendRegistrationLink($email, $user_data) {
//     require_once(get_theme_file_path('send_mail.php'));
//     $registrationPage = 'https://nezhno.space/registration';
//     $token = generateUniqueToken();
//     storeToken($email, $token, $user_data);

//     $registrationLink = $registrationPage . '?token=' . urlencode($token);
//     $subject = 'Registration Link';
//     $message = 'Please click on the following link to register: ' . $registrationLink;
//     $result = SendMail($email, $subject, $message, $subject);
//     return $result;
// }

// function generateUniqueToken($length = 10) {
//     $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
//     $token = '';
//     $charactersLength = strlen($characters);
//     for ($i = 0; $i < $length; $i++) {
//         $randomIndex = mt_rand(0, $charactersLength - 1);
//         $token .= $characters[$randomIndex];
//     }
//     return $token;
// }

// function storeToken($email, $token, $user_data) {
//     $db = new SafeMySQL();
//     return $db->query("INSERT INTO tokens (mail, token, info) VALUES ('$email', '$token', '$user_data')");
// }













// $post_data = array(
//     'post_title'    => $title,
//     'post_content'  => $content,
//     'post_status'   => 'publish',
//     'post_author'   => 1,
//     'post_excerpt'  => $excerpt,
// );

// // Вставляем запись в базу данных
// $post_id = wp_insert_post($post_data, true);
// //Категория
// wp_set_object_terms( $post_id, $category, 'category' );

// print_r($post_id); // Выведет id-ник поста, либо объект с массивом ошибок


// // Для примера возьмём картинку с моего же блога, которая была залита вне структуры wordpress
// $url = 'http://sergeivl.ru/public/img/svlJForm.png';

// // Прикрепим к ранее сохранённому посту
// //$post_id = 3061;
// $description = "Картинка для обложки";

// // Установим данные файла
// $file_array = array();
// $tmp = download_url($url);

// // Получаем имя файла
// preg_match('/[^\?]+\.(jpg|jpe|jpeg|gif|png)/i', $url, $matches );
// $file_array['name'] = basename($matches[0]);
// $file_array['tmp_name'] = $tmp;

// // загружаем файл
// $media_id = media_handle_sideload( $file_array, $post_id, $description);

// // Проверяем на наличие ошибок
// if( is_wp_error($media_id) ) {
// 	@unlink($file_array['tmp_name']);
// 	echo $media_id->get_error_messages();
// }

// // Удаляем временный файл
// @unlink( $file_array['tmp_name'] );

// // Файл сохранён и добавлен в медиатеку WP. Теперь назначаем его в качестве облож
// set_post_thumbnail($post_id, $media_id);



// $updated_post_arr = array(
// 	'ID'		=> 832, // допустим, ID поста, заголовок которого нужно изменить, равен 500
// 	'post_title'    => 'Новый заголовок', // заголовок
//     'post_status'   => 'publish',
// );

// // обновляем пост (все остальные его параметры останутся прежними)
// wp_insert_post( $updated_post_arr );




?>