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
		"modal",
		get_template_directory_uri() . "/libs/modal/modal.css"
	);
	wp_enqueue_style("modal");

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



	$css_files = ["header", "main" , "blog", "footer", "about_us", 
	"page-blog", "404", "documents",
	"single", "audio", "sign"];
	
	for($i=0; $i < count($css_files); $i++){
		wp_register_style(
			$css_files[$i],
			get_template_directory_uri() . "/css/" . $css_files[$i] . ".css"
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

	/* player */
	wp_register_script(
		"player",
		get_template_directory_uri() . "/js/player.js", 
		array("my_jquery"),
		null,
		true
	);
	wp_enqueue_script("player");

	/* theme-text */
	wp_register_script(
		"theme-text",
		get_template_directory_uri() . "/js/theme-text.js", 
		array("my_jquery"),
		null,
		true
	);
	wp_enqueue_script("theme-text");


	$js_files=["personal_area", "slider", "functions","menu","sign"];
	
	for($i=0; $i < count($js_files); $i++){
		wp_register_script(
			$js_files[$i],
			get_template_directory_uri() . "/js/" . $js_files[$i] . ".js", 
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

function getUrl(){
echo get_template_directory_uri();
};
function paySubscriptionUrl(){
echo get_site_url() . "/payment";
};