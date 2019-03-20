<?php
/*
Plugin Name: Customhost-wordpress
Description: This is just simple plugin with github repo.
Author: Eyedo
*/


function my_custom_styles() {
  wp_register_style( 'custom-styles',plugins_url('assets/main.css',__FILE__));
  wp_enqueue_style( 'custom-styles' );
}
add_action( 'wp_enqueue_scripts', 'my_custom_styles' , 100);
