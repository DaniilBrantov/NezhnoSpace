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





add_filter( 'manage_users_columns', 'bbloomer_add_new_user_column' );
function bbloomer_add_new_user_column( $columns ) {
$columns = [
'username'=>'Ник',
'role'=>'Роль',
'email'=>'Email',
'age'=>'Возраст',
'sex'=>'Пол',
'service'=>'Услуга',
'telephone'=>'Телефон',
'date_payment'=>'Дата покупки',
];
return $columns;
}

add_filter( 'manage_users_custom_column', 'bbloomer_add_new_user_column_content', 10, 3 );
function bbloomer_add_new_user_column_content( $content, $column, $user_id ) {
$customer = new WC_Customer( $user_id );

if ( 'avatar_url' === $column ) {$content = $customer->get_avatar_url();}
if( 'surname' === $column ){$content = $customer->get_last_name();}
if( 'name' === $column ){$content = $customer->get_first_name();}
//if( 'telephone' === $column ){$content = $customer->get_phone();}
if( 'email' === $column ){$content = $customer->get_email();}
if( 'username' === $column ){$content = $customer->get_username();}
if( 'role' === $column ){$content = $customer->get_role();}
return $content;
}
















/** убираем версии показа ДВИЖКА из исходного кода, при подключении css и jquery **/







/** -------PHP/WP Functions------ **/

//Проверка авторизации
function CheckAuth(){
if (!$_SESSION['id'] || $_SESSION['id']==NULL) {
header('Location: auth');
}
};
//Путь до папки
function getUrl(){
echo get_template_directory_uri();
};
//Ссылка на оплату
function paySubscriptionUrl(){
echo get_site_url() . "/payment";
};
//Рандомное имя папки через mb5
function getRandomFileName($path){
$path = $path ? $path . '/' : '';
do {
$name = md5(microtime() . rand(0, 9999));
$file = $path . $name;
} while (file_exists($file));
return $name;
}



//Сегодняшняя ежедневнвя практика
function TodayPractice($payment_days){
if(checkPayment()){
if($payment_days !== NULL && isset($payment_days) && !empty($payment_days)){
$daily_practice=CategoryData($payment_days,45);
$id = $daily_practice[$payment_days]['id'];

if(!empty($id) && isset($id) && $id !== NULL && $payment_days>1){
$result=subscriptionData($id);
}else{
$result=subscriptionData(913);
}
}else{
$result=subscriptionData(913);
};
return $result;
}
}

//Вывод всех записей из конкретной категории
function CategoryData($open_posts,$category){
if ( have_posts() ) : query_posts(array( 'orderby'=>'date','order'=>'ASC','cat' => $category));
$open_posts=ceil($open_posts);
$res=[];
$i=1;
while (have_posts()) : the_post();
$res[$i] = subscriptionData(get_the_ID()) ;
if($open_posts >= $i || $res[$i]['id']===1 || $res[$i]['id']===0){
$res[$i]['status']=TRUE;
}else{$res[$i]['status']=FALSE;}
$i+=1;
endwhile;
endif;
return ($res);
wp_reset_query();
};


//Проверка оплаты
function checkPayment(){

$db = new SafeMySQL();
$status = $db->getOne("SELECT status FROM users WHERE id=?i", $_SESSION['id']);

if($status && !empty($status) && isset($status) && $status !== NULL){
if($status==='2'){
return TRUE;
}else{return FALSE;}
}else{return FALSE;}
}

//Данные из конкретной записи
function subscriptionData($id){
$post = get_post($id);

$res=[
'id' => $post->ID,
'date' => $post->post_date,
'excerpt' => $post->post_excerpt,
'title' => $post->post_title,
'content' => $post->post_content,
'image_url' => get_the_post_thumbnail_url( $post->ID, 'full' )
];
if(checkPayment()){
$res['link'] = $post->post_name;
$res['tag'] =get_the_tag_list('<li>','</li>
<li>','</li>', $post->ID );
}
return $res;
}

//Количество дней между датами
function countDaysBetweenDates($d1, $d2){
$d1_ts = strtotime($d1);
$d2_ts = strtotime($d2);
$seconds = abs($d1_ts - $d2_ts);
return floor($seconds / 86400);
}

//Вывод конкретного кол-ва знаков в тексте
function trimCntChars($txt,$count, $after) {
if (mb_strlen($txt) > $count) $txt = mb_substr($txt,0,$count);
else $after = '';
return $txt . $after;
}

//Сокращение текста до конкретного кол-ва
function trimCntWords($txt,$count, $after) {
$words = explode(' ', $txt);
if (count($words) > $count) {
array_splice($words, $count);
$txt = implode(' ', $words);
}
else $after = '';
return $txt . $after;
}







//Создать платёж



//Создание платежных данных
function createPagePayment($price,$description){
$data = array(
'amount' => array(
'value' => $price,
'currency' => 'RUB',
),
'payment_method_data' => array(
'type' => 'bank_card',
),
'capture' => true,
'confirmation' => array(
'type' => 'redirect',
'return_url' => 'https://nezhno.space/pay_success',
),
'description' => $description,
'save_payment_method' => true,
'metadata' => array(
'order_id' => 1,
)
);
return $data;
};


//Автоплатёж
function Autopay($pay_id,$price,$description){
$data=array(
'amount' => array(
'value' => 2.0,
'currency' => 'RUB',
),
'capture' => true,
'payment_method_id' => '2b59e547-000f-5000-a000-1e50e827dccb',
'description' => 'Заказ №105',
);
return $data;
};


//Подключение к кассе
function connectionPayment($data){
$client = new \YooKassa\Client();
//$set_auth=$client->setAuth(YOOKASSA_SHOPID, YOOKASSA_SECRET_KEY);
$set_auth=$client->setAuth('975491', 'test_ubpi1LK1auMcV-0o77C9Nn4ikb1h9RbzjaD0_2oFT7I');
$payment = $client->createPayment(
$data,
uniqid('', true)
);
return $payment;
};

//Получение данных оплаты
function getPaymentInformation($paymentId){
$client = new \YooKassa\Client();
// $client->setAuth(YOOKASSA_SHOPID, YOOKASSA_SECRET_KEY);
$client->setAuth('975491', 'test_ubpi1LK1auMcV-0o77C9Nn4ikb1h9RbzjaD0_2oFT7I');
$payment = $client->getPaymentInfo($paymentId);
return $payment;
}



/**
* New User registration
*
*/
function vb_reg_new_user() {

// Verify nonce
if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'vb_new_user' ))
return( 'Ooops, something went wrong, please try again later.' );

// Post values
$password = $_POST['pass'];
$email = $_POST['mail'];
$name = $_POST['first_name'];

$userdata = array(
'user_login' => $email,
'user_pass' => $password,
'user_email' => $email,
'first_name' => $name,
);

$user_id = wp_insert_user( $userdata ) ;

// Return
if( !is_wp_error($user_id) ) {
//$user_id = wp_update_user(array('ID' => $user_id, 'description' => $about)); //add description-about
return '1';
} else {
return $user_id->get_error_message();
}
die();

}

add_action('wp_ajax_register_user', 'vb_reg_new_user');
add_action('wp_ajax_nopriv_register_user', 'vb_reg_new_user');