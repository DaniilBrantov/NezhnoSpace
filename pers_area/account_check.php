<?php
/**
 * Template Name: account_check
 *
 
 */
session_start();
require_once( get_theme_file_path('processing.php') );
require_once( get_theme_file_path('save_upload.php') );

 //echo $_SESSION['id'];

$user_data=[
	'gender' => $_POST['gender'],
	'age' => $_POST['age'],
	'first_name' => $_POST['first_name'],
	'last_name' => $_POST['last_name'],
	'tel' => preg_replace("/[^0-9]/", '', $_POST['tel']),
	'email' => $_POST['email']
];

// $_POST['send']=true;
// $user_data=[
// 	'gender' => 'Мужской',
// 	'age' => $_POST['age'],
// 	'first_name' => 'Dabr',
// 	'last_name' => 'Dabr',
// 	'tel' => preg_replace("/[^0-9]/", '', $_POST['tel']),
// 	'email' => 'dsa@dsg.ru'
// ];

if($_POST['send']){
	$errors=[];
	//Sex
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
			$errors['tel'] = 'Произошёл сбой при загрузке';
		}
	};
	//Age
	if(isset($user_data['age']) && !empty($user_data['age'])){
		//Загрузка параметра в БД
		if(!$db->query("UPDATE users SET age=?s WHERE id=?i", $user_data['age'], $_SESSION['id'])){
			$errors['tel'] = 'Произошёл сбой при загрузке';
		}
	}
	//Telephone
	if(isset($user_data['tel']) && !empty($user_data['tel'])){
		if(preg_match("/^[0-9]{11,11}+$/", $user_data['tel'])){
			$first = substr($user_data['tel'], "0",1);
			if($first != 7){
				$errors['tel'] = "Некорректный номер телефона";
			}else{
				//Загрузка параметра в БД
				if(!$db->query("UPDATE users SET telephone =?i WHERE id=?i", $user_data['tel'], $_SESSION['id'])){
					$errors['tel'] = 'Произошёл сбой при загрузке';
				}
			}
		}else{
			$errors['tel'] = "Телефон задан в неверном формате";
		}
		
	}
	//First Name & Last Name
	if(isset($user_data['first_name']) && !empty($user_data['first_name'])){
		if (mb_strlen($user_data['first_name']) < 3 || mb_strlen($user_data['first_name']) > 50){$errors['first_name'] = "Недопустимая длина имени";}
		else{
			//Загрузка параметра в БД
			if(!$db->query("UPDATE users SET surname =?s WHERE id=?i", $user_data['first_name'], $_SESSION['id'])){
				$errors['first_name'] = 'Произошёл сбой при загрузке';
			}
		}
	}
	if(isset($user_data['last_name']) && !empty($user_data['last_name'])){
		if (mb_strlen($user_data['last_name']) < 2 || mb_strlen($user_data['last_name']) > 50){$errors['last_name'] = "Недопустимая длина фамилии";}
		else{
			//Загрузка параметра в БД
			if(!$db->query("UPDATE users SET surname =?s WHERE id=?i", $user_data['last_name'], $_SESSION['id'])){
				$errors['last_name'] = 'Произошёл сбой при загрузке';
			}
		}
	}
	//Email
	$sign=new Sign();
	$email_err=$sign->ErrEmail($user_data['email']);
	if($email_err){
		$errors['email'] = $email_err;
	}else{
		//Загрузка параметра в БД
		if(!$db->query("UPDATE users SET mail =?s WHERE id=?i", $user_data['email'], $_SESSION['id'])){
			$errors['email'] = 'Произошёл сбой при загрузке';
		}
	}
	//Avatar
	if(isset($_FILES['image']) && !empty($_FILES['image'])){
		$save_upload = saveUpload($_FILES['image'],5,1800,1800);
		if($save_upload['status']){
			//Загрузка названия картинки в БД
			$img=$save_upload['image'];
			if(!$db->query("UPDATE users SET avatar =?s WHERE id=?i", $img, $_SESSION['id'])){
				$errors['image'] = 'Произошёл сбой при загрузке';
			}
		}else{
			$errors['image'] = $save_upload['msg'];
		}
	}
	if(empty($errors)){
		echo json_encode(true);
	}else{
		echo json_encode($errors);
	}
}

?>