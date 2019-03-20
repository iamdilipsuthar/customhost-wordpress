<?php
/*
Plugin Name: Customhost-wordpress
Description: This is just simple plugin with github repo.
Author: Eyedo
*/



add_action('wp_enqueue_scripts',function(){

  wp_register_style('custom-style',plugins_url('assets/main.css',__FILE__),'1.0');
  wp_enqueue_style('custom-style');

},100);
