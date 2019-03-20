<?php
/*
Plugin Name: Customhost-wordpress
Description: This is just simple plugin with github repo.
Author: Eyedo
*/

//load asset to frontend side
function my_custom_styles() {
  wp_register_script('custom-script',plugins_url('assets/main.js',__FILE__),array('jquery'),'1.0');
  wp_enqueue_script('custom-script');
}
add_action( 'wp_enqueue_scripts', 'my_custom_styles' , 100);

//load asset to admin side
function my_custom_styles2() {
  wp_register_script('admin-script',plugins_url('assets/admin/main.js',__FILE__),array('jquery'),'1.0');
  wp_enqueue_script('admin-script');
}
add_action( 'admin_enqueue_scripts', 'my_custom_styles2' , 100);
