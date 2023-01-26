<?php
/**
 * Template Name: account_check
 *
 
 */
session_start();
require_once( get_theme_file_path('processing.php') );
require_once( get_theme_file_path('save_upload.php') );
$user_err=new UserValidationErrors();


$user_data=[
	'gender' => $_POST['gender'],
	'age' => $_POST['age'],
	'first_name' => ucfirst(strtolower($_POST['first_name'])),
	'last_name' => ucfirst(strtolower($_POST['last_name'])),
	'tel' => preg_replace("/[^0-9]/", '', $_POST['tel']),
	'email' => $_POST['email'],
	'avatar' => $_FILES['image']
];

// $_POST['send']=true;
// $user_data=[
// 	'gender' => 'Мужской',
// 	'age' => "2004-12-31",
// 	'first_name' => ucfirst(strtolower('daniil')),
// 	'last_name' => ucfirst(strtolower('brantov')),
// 	'tel' => preg_replace("/[^0-9]/", '', 79506276012),
// 	'email' => 'sdffsd@df.ru',
// 	'avatar' => $_FILES['image']
// ];

$err_tel=updateData($user_data['tel'],$user_err->getTelephone($user_data['tel']),'telephone','tel');
$err_name=updateData($user_data['first_name'],$user_err->getName($user_data['first_name']),'name','first_name');
$err_surname=updateData($user_data['last_name'],$user_err->getSurname($user_data['last_name']),'surname','last_name');
$err_mail=updateData($user_data['email'],$user_err->getEmail($user_data['email']),'mail','email');
$err_age=updateData($user_data['age'],$user_err->getAge($user_data['age']),'age','age');
$validation_array=array_merge($err_tel,$err_name,$err_surname,$err_mail,$err_age);


// Sex
if(isset($user_data['gender']) && !empty($user_data['gender'])){
	if($user_data['gender']=="Мужской"){
		$sex=1;
	}elseif($user_data['gender']=="Женский"){
		$sex=2;
	}else{
		$sex=0;
	}
	//Загрузка параметра в БД
	if(!$db->query("UPDATE users SET sex=?i WHERE id=?i", $sex, $_SESSION['id'])){
		$validation_array['gender'] = 'Произошёл сбой при загрузке';
	}
};

//Avatar
if(isset($_FILES['image']) && !empty($_FILES['image'])){
	$save_upload = saveUpload($_FILES['image'],5,1800,1800);
	if($save_upload['status']){
		//Загрузка названия картинки в БД
		$img=$save_upload['image'];
		if(!$db->query("UPDATE users SET avatar =?s WHERE id=?i", $img, $_SESSION['id'])){
			$validation_array['image'] = 'Произошёл сбой при загрузке';
		}
	}else{
		$validation_array['image'] = $save_upload['msg'];
	}
}

// Bring out errors
if(empty($validation_array)){
	echo json_encode(true);
}else{
	$validation_array['status']=false;
	echo json_encode ($validation_array);
}
?>