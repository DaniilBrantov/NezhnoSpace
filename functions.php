<?php
  /* scripts and styles */
function ei_scripts() {
  wp_enqueue_style('iee-style', get_template_directory_uri() . 'style.css' , array(), null);
  }

add_action( 'wp_enqueue_scripts', 'ei_scripts' );

/* thumbnails */
if (function_exists('add_theme_support')){
  add_theme_support('post-thumbnails');
  add_image_size('news', 350, 250 , true );
}

//Меню
register_nav_menu( 'mainmenu' , 'Главное меню' );




?>
