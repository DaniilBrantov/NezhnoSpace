<?php
/* scripts and styles */

/*Регистрация всех стилей*/
function load_styles(){
	wp_register_style(
		"my_style",
		get_template_directory_uri() . "/style.css"
	);
	wp_enqueue_style("my_style");	/*добавить стиль в очередь*/

	wp_register_style(
		"intlTelInput",
		get_template_directory_uri() . "/libs/phone/css/intlTelInput.css"
	);
	wp_enqueue_style("intlTelInput");


	wp_register_style(
		"slick",
		get_template_directory_uri() . "/libs/slick/slick.css"
	);
	wp_enqueue_style("slick");

	wp_register_style(
		"slick-theme",
		get_template_directory_uri() . "/libs/slick/slick-theme.css"
	);
	wp_enqueue_style("slick-theme");

	wp_register_style(
		"aos",
		"https://unpkg.com/aos@2.3.1/dist/aos.css"
	);
	wp_enqueue_style("aos");

	wp_register_style(
		"plyr",
		"https://cdn.plyr.io/3.7.2/plyr.css"
	);
	wp_enqueue_style("plyr");



	$css_files = ["header","modal", "main" , "blog", "footer", "about_us", 
	"page-blog", "404", "documents",
	"single", "audio", "sign", "account-content","pers_area"];
	
	for($i=0; $i < count($css_files); $i++){
		wp_register_style(
			$css_files[$i],
			get_template_directory_uri() . "/css/" . $css_files[$i] . ".css?"
		);
		wp_enqueue_style($css_files[$i]);
	}
}
add_action("wp_enqueue_scripts","load_styles");




/*Регистрация всех скриптов*/
function load_script() /*имя функции произвольное*/
{
	/*В первую очередь подключаем библиотеку jquery
	/*отключаем встроенную библиотеку jquery в Wordpress*/
	wp_deregister_script("jquery");

	wp_register_script(
		"my_jquery",
		get_template_directory_uri() . "/libs/jquery/jquery-3.5.1.min.js");
	wp_enqueue_script("my_jquery");

	/*---тоже самое для других скриптов после jquery, но добовляем 3 параметр array("my_jquery"), null, false--*/ 
	/* slick_slider */
	wp_register_script(
		"slick_slider", /*любое уникальное имя*/
		get_template_directory_uri() . "/libs/slick/slick.min.js", 
		array("my_jquery"), /*Массив названий всех зарегистрированных скриптов, от которых зависит регестрируемый*/
		null, /*т.е. не добовлять версию скрипта.*/
		false
	);
	wp_enqueue_script("slick_slider");	/*добавить стиль в очередь*/

	/* TelInput */
	wp_register_script(
		"TelInput",
		get_template_directory_uri() . "/libs/phone/js/intlTelInput.min.js", 
		array("my_jquery"),
		null,
		false
	);
	wp_enqueue_script("TelInput");

	/* TelInput_jquery */
	wp_register_script(
		"TelInput_jquery",
		get_template_directory_uri() . "/libs/phone/js/intlTelInput-jquery.min.js", 
		array("my_jquery"),
		null,
		false
	);
	wp_enqueue_script("TelInput_jquery");

	/* plyr */
	wp_register_script(
		"plyr",
		"https://cdn.plyr.io/3.7.2/plyr.js", 
		array("my_jquery"),
		null,
		false
	);
	wp_enqueue_script("plyr");

	$js_files=["modal","personal_area", "slider", "functions","menu","sign","theme-text","video-player","player"];
	
	for($i=0; $i < count($js_files); $i++){
		wp_register_script(
			$js_files[$i],
			get_template_directory_uri() . "/js/" . $js_files[$i] . ".js?" . time(), 
			array("my_jquery"),
			null,
			true
		);
		wp_enqueue_script($js_files[$i]);
	}
}

/*Регистрируем Хук-событие*/
add_action("wp_enqueue_scripts","load_script");

/*закрывающий тег ?> для всего кода php НЕ НУЖЕН*/



/* thumbnails */
if (function_exists('add_theme_support')){
/*Регистрирует поддержку новых возможностей темы в WP
(поддержка миниатюр, форматов записей и т.д.).*/
add_theme_support('post-thumbnails');
/*Регистрирует новый размер картинки*/
add_image_size('news', 350, 250 , true );
}

//Menu
register_nav_menu( 'mainmenu' , 'Главное меню' );


/** убираем версии показа ДВИЖКА из исходного кода, при подключении css и jquery **/
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
function vc_remove_wp_ver_css_js( $src ) {
if ( strpos( $src, 'ver=' ) )
$src = remove_query_arg( 'ver', $src );
return $src;
}
/** убираем версии показа ДВИЖКА из исходного кода, при подключении css и jquery **/







/** -------PHP/WP Functions------ **/

function CheckAuth(){
if (!$_SESSION['id'] || $_SESSION['id']==NULL) {
header('Location: auth');
}
};
function getUrl(){
echo get_template_directory_uri();
};
function paySubscriptionUrl(){
echo get_site_url() . "/payment";
};
function getRandomFileName($path){
$path = $path ? $path . '/' : '';
do {
$name = md5(microtime() . rand(0, 9999));
$file = $path . $name;
} while (file_exists($file));
return $name;
}

//Daily Practice
function DailyPractice($id){
$out='';
$post=get_post($id);
$out.='<div class="daily_practice">
    <div class="daily_practice_img">
        '. get_the_post_thumbnail($id, 'ppthmb') .'
    </div>
    <div class="daily_practice_cnt">
        <div class="daily_practice_title">
            '. $post->post_title .'
        </div>
        <div class="daily_practice_description">
            '. trimCntWords(get_the_excerpt($post->ID), 20, '...') .'
        </div>
    </div>
</div>';
echo $out;
}
function trimCntChars($txt,$count, $after) {
if (mb_strlen($txt) > $count) $txt = mb_substr($txt,0,$count);
else $after = '';
return $txt . $after;
}

function trimCntWords($txt,$count, $after) {
$words = explode(' ', $txt);
if (count($words) > $count) {
array_splice($words, $count);
$txt = implode(' ', $words);
}
else $after = '';
return $txt . $after;
}


//Generate a key
function gen_uuid() {
return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
mt_rand( 0, 0xffff ),
mt_rand( 0, 0x0fff ) | 0x4000,
mt_rand( 0, 0x3fff ) | 0x8000,
mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
);
}

//Создать платёж

function createNewPayment($price,$description){


//Отправка платежных данных
$data = array(
'amount' => array(
'value' => $price,
'currency' => 'RUB',
),
'payment_method_data' => array(
'type' => 'sberbank',
'phone' => '79506276012',
),
'capture' => true,
'confirmation' => array(
'type' => 'embedded',
),
'description' => $description,
'metadata' => array(
'order_id' => 1,
)
);

//CURL запрос
$data = json_encode($data, JSON_UNESCAPED_UNICODE);

$ch = curl_init('https://api.yookassa.ru/v3/payments');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_USERPWD, YOOKASSA_CONNECTION);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Idempotence-Key: ' . gen_uuid()));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$res = curl_exec($ch);
curl_close($ch);

$res = json_decode($res, true);
$res= $res['confirmation']['confirmation_token'];
echo $res;
};