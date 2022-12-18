<div class="authorization">
    <div class="reg_auth">
        <div class="authorization_title">
            <h1>
                ЗАРЕГИСТРИРОВАТЬСЯ
            </h1>
        </div>
        <form class="authorization_form">
            <div class="pers_item">
                <label>Ваше имя</label>
                <input type="text" name="first_name" placeholder="Введите имя...">
                <span class="text-error text-error_first_name">text error</span>
            </div>
            <div class="pers_item">
                <label>Email</label>
                <p class="pers_item_txt">На указанный email придет код подтверждения</p>
                <input type="text" name="mail" placeholder="Введите email...">
                <span class="text-error text-error_mail">text error</span>
            </div>
            <div class="pers_item">
                <label>Пароль</label>
                <div class="pers_input">
                    <input type="password" name="pass" placeholder="Введите пароль...">
                    <span class="pass_eye"></span>
                    <span class="text-error text-error_pass">text error</span>
                </div>
            </div>
            <div class="pers_item">
                <label>Подтвердите пароль</label>
                <input type="password" name="pass_conf" placeholder="Подтвердите пароль...">
                <span class="text-error text-error_pass_conf">text error</span>
            </div>
            <div class="pers_approval pers_item_txt">
                <input type="checkbox" required class="visually-hidden" id="pers_approval_checkbox"
                    name="approval_check">
                <label for="pers_approval_checkbox">Я соглашаюсь с условиями публичной оферты</label>
            </div>
            <div class="pers_btn">
                <button id="reg_btn" class="blue_btn" type="submit">ЗАРЕГИСТРИРОВАТЬСЯ</button>
            </div>
        </form>
        <div class="authorization_question">
            <p>Есть аккаунт?</p>
            <a href="auth">Войти</a>
        </div>
    </div>
</div>

<?php 
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


    //VK Auth

    echo $link = '<p><a href="' . $vk_url . '?' . urldecode(http_build_query($params)) . '">Аутентификация через ВКонтакте</a></p>';


    //Mail Auth
    echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">Аутентификация через Mail.ru</a></p>';

?>