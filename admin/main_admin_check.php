<?php
/**
 * Template Name: admin_check
 *
 
 */


require_once('wp-load.php' );
require_once( 'wp-admin/includes/admin.php');

$title=$_POST['title'];
$excerpt=$_POST['excerpt'];
$content=$_POST['content'];
$category=$_POST['category'];

var_dump($title);




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