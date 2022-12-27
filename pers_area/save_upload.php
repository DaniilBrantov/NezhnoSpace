<?php
/**
 * Template Name: save_upload
 *
 
 */
require_once( get_theme_file_path('processing.php') );

$tmp_path = 'wp-content/uploads/tmp/';
$path = 'wp-content/uploads/permanent/';

// Подключение к БД.

$db = new SafeMySQL();

if (isset($_POST['send'])) {
	$sth = $db->query("INSERT INTO `users` SET `avatar` = UNIX_TIMESTAMP()");
	// Получаем id вставленной записи.
	$insert_id = $db->insertId();

	// Сохранение изображений в БД и перенос в постоянную папку.
	if (!empty($_POST['images'])) {
		foreach ($_POST['images'] as $row) {
			$filename = preg_replace("/[^a-z0-9\.-]/i", '', $row);
			if (!empty($filename) && is_file($tmp_path . $filename)) {
				$sth = $db->query("INSERT INTO `reviews_images` SET `reviews_id` = ?i, `filename` = ?s", $insert_id, $filename);
				
				// Перенос оригинального файла
				rename($tmp_path . $filename, $path . $filename);
				
				// Перенос превью
				$file_name = pathinfo($filename, PATHINFO_FILENAME);				
				$file_ext = pathinfo($filename, PATHINFO_EXTENSION);
				$thumb = $file_name . '-thumb.' . $file_ext;
				rename($tmp_path . $thumb, $path . $thumb);
			}
		}
	}
}
// Редирект, чтобы предотвратить повторную отправку по F5.
header('Location: /reviews.php', true, 301);

exit();