<?php
/**
 * Template Name: save_upload
 *
 
 */
session_start();
require_once( get_theme_file_path('processing.php') );



function saveUpload($file,$MB,$img_width,$img_height){
	$db = new SafeMySQL();
	// Если в $_FILES существует "image" и она не NULL
	if (isset($file)) {
		// Зададим ограничения для картинок
		$limitBytes  = 1024 * 1024 * $MB;
		$limitWidth  = $img_width;
		$limitHeight = $img_height;

		// Получаем нужные элементы массива "image"
		$fileTmpName = $file['tmp_name'];
		$errorCode = $file['error'];
		// Проверим на ошибки
		if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($fileTmpName)) {
			// Массив с названиями ошибок
			$errorMessages = [
				UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
				UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
				UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
				UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
				UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
				UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
				UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
			];
			$unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';
			$returnMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;
		} else {
			// Создадим ресурс FileInfo
			$fi = finfo_open(FILEINFO_MIME_TYPE);
			// Получим MIME-тип
			$mime = (string) finfo_file($fi, $fileTmpName);
			// Проверим ключевое слово image (image/jpeg, image/png и т. д.)
			if (strpos($mime, 'image') === false) $returnMessage='Можно загружать только изображения.';
			// Результат функции запишем в переменную
			$image = getimagesize($fileTmpName);
			// Проверим нужные параметры
			if (filesize($fileTmpName) > $limitBytes) $returnMessage = 'Размер изображения не должен превышать '.$MB.'Мбайт.';
			if ($image[1] > $limitHeight)             $returnMessage = 'Высота изображения не должна превышать '.$limitHeight.'px.';
			if ($image[0] > $limitWidth)              $returnMessage = 'Ширина изображения не должна превышать '.$limitWidth.' точек.';
		
			// Сгенерируем новое имя файла через функцию getRandomFileName()
			$name = getRandomFileName($fileTmpName);
		
			// Сгенерируем расширение файла на основе типа картинки
			$extension = image_type_to_extension($image[2]);
		
			// Сократим .jpeg до .jpg
			$format = str_replace('jpeg', 'jpg', $extension);
		
			//Переместим картинку с новым именем и расширением в папку /uploads
			if (!move_uploaded_file($fileTmpName, 'wp-content/uploads/permanent/' . $name . $format)) {
				$returnMessage='При записи изображения на диск произошла ошибка.';
			}
			//Загрузка названия картинки в БД
			if(!$db->query("UPDATE users SET avatar =?s WHERE id=?i", $name, $_SESSION['id'])){
				$returnMessage = 'Произошёл сбой при загрузке картинки.';
			}
		}
	}else{
		$returnMessage='Загрузите картинку';
	};
	//Возвращаем ответ
	if($returnMessage){
		return $returnMessage;
	}else{
		return true;
	}
};