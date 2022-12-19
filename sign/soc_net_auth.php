<?php
require_once( get_theme_file_path('processing.php') );



//Mail Auth

// $client_id = 'f32703857d184bcd82c8041526679f6c'; // ID
// $client_secret = '92d37a9b8c684985a9bde9697c57fd32'; // Секретный ключ
// $redirect_uri = $url . "/registration"; // Ссылка на приложение

// $url = 'https://connect.mail.ru/oauth/authorize';
// 	$params = array(
// 	    'client_id'     => $client_id,
// 	    'response_type' => 'code',
// 	    'redirect_uri'  => $redirect_uri
// 	);


//     if (isset($_GET['code'])) {
//                 $result = true;
                
//                 $params = array(
//                     'client_id'     => $client_id,
//                     'client_secret' => $client_secret,
//                     'grant_type'    => 'authorization_code',
//                     'code'          => $_GET['code'],
//                     'redirect_uri'  => $redirect_uri
//                 );
                
//                 $url = 'https://connect.mail.ru/oauth/token';
                
//                 $curl = curl_init();
//                 curl_setopt($curl, CURLOPT_URL, $url);
//                 curl_setopt($curl, CURLOPT_POST, 1);
//                 curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
//                 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//                 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//                 $result = curl_exec($curl);
//                 curl_close($curl);
            
//                 $tokenInfo = json_decode($result, true);
            
//                 if (isset($tokenInfo['access_token'])) {
//                 $sign = md5("app_id={$client_id}method=users.getInfosecure=1session_key={$tokenInfo['access_token']}{$client_secret}");
            
//                     $params = array(
//                         'method'       => 'users.getInfo',
//                         'secure'       => '1',
//                         'app_id'       => $client_id,
//                         'session_key'  => $tokenInfo['access_token'],
//                         'sig'          => $sign
//                     );
            
//                     $userInfo = json_decode(file_get_contents('http://www.appsmail.ru/platform/api' . '?' . urldecode(http_build_query($params))), true);
//                     if (isset($userInfo[0]['uid'])) {
//                         $userInfo = array_shift($userInfo);
//                         $result = true;
//                     }
//                 }
//     }
            








//VK Auth
// $client_id = '51504557'; // ID приложения
// $client_secret = 'fMXAAMClKlXAnhfS37et'; // Защищённый ключ
// $redirect_uri = $url . "/registration"; // Адрес сайта
// $vk_url = 'http://oauth.vk.com/authorize';
//VK Auth
// $params = array(
//     'client_id'     => $client_id,
//     'redirect_uri'  => $redirect_uri,
//     'response_type' => 'code'
// );

// if (isset($_GET['code'])) {
//     $result = true;
//     $params = [
//         'client_id' => $client_id,
//         'client_secret' => $client_secret,
//         'code' => $_GET['code'],
//         'redirect_uri' => $redirect_uri
//     ];

//     $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);

//     if (isset($token['access_token'])) {
//         $params = [
//             'uids' => $token['user_id'],
//             'fields' => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
//             'access_token' => $token['access_token'],
//             'v' => '5.101'];

//         $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
//         if (isset($userInfo['response'][0]['id'])) {
//             $userInfo = $userInfo['response'][0];
//             $result = true;
//         }
//     }

//     if ($result) {
//         echo "ID пользователя: " . $userInfo['id'] . '<br />';
//         echo "Имя пользователя: " . $userInfo['first_name'] . '<br />';
//         echo "Ссылка на профиль: " . $userInfo['screen_name'] . '<br />';
//         echo "Пол: " . $userInfo['sex'] . '<br />';
//         echo "День Рождения: " . $userInfo['bdate'] . '<br />';
//         echo '<img src="' . $userInfo['photo_big'] . '" />'; echo "<br />";
//     }
// }











//Yandex Auth
	// $client_id = 'd83fbbc9562e49699e2b6748284c4e67'; // Id приложения
	// $client_secret = '44e3aede6c9e48c5aed44bceb664acc6'; // Пароль приложения
	// $redirect_uri = 'https://eatintelligent.ru/registration'; // Callback URI
	// $url = 'https://oauth.yandex.ru/authorize';
	
	// $params = array(
	//     'response_type' => 'code',
	//     'client_id'     => $client_id,
	//     'display'       => 'popup'
	// );
	// echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">Аутентификация через Yandex</a></p>';
	// if (isset($_GET['code'])) {
	//     $result = false;
	//     $params = array(
	//         'grant_type'    => 'authorization_code',
	//         'code'          => $_GET['code'],
	//         'client_id'     => $client_id,
	//         'client_secret' => $client_secret
	//     );
	    
	//     $url = 'https://oauth.yandex.ru/token';
	    
	//     $curl = curl_init();
	//     curl_setopt($curl, CURLOPT_URL, $url);
	//     curl_setopt($curl, CURLOPT_POST, 1);
	//     curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
	//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	//     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	//     $result = curl_exec($curl);
	//     curl_close($curl);
	    
	//     $tokenInfo = json_decode($result, true);
	//     if (isset($tokenInfo['access_token'])) {
	//         $params = array(
	//             'format'       => 'json',
	//             'oauth_token'  => $tokenInfo['access_token']
	//         );
	    
	//         $userInfo = json_decode(file_get_contents('https://login.yandex.ru/info' . '?' . urldecode(http_build_query($params))), true);
	//         if (isset($userInfo['id'])) {
    //             $userInfo = $userInfo;
	//             $result = true;
    //             var_dump($userInfo) ;
	//         }
	//     }
	// }

?>