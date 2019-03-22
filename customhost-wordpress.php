<?php
/*
Plugin Name: Customhost-wordpress
Description: This is just simple plugin with github repo.
Author: Eyedo
*/

defined( 'ABSPATH' ) || die();

//load asset to frontend side
function my_custom_styles() {
  wp_register_script('custom-script',plugins_url('assets/main.js',__FILE__),array('jquery'),'1.0');
  wp_enqueue_script('custom-script');
  wp_localize_script('custom-script','customhost',array(
    'ajaxurl'=>admin_url('admin-ajax.php')
  ));
}
add_action( 'wp_enqueue_scripts', 'my_custom_styles' , 100);

//load asset to admin side
function my_custom_styles2() {
  wp_register_script('admin-script',plugins_url('assets/admin/main.js',__FILE__),array('jquery'),'1.0');
  wp_enqueue_script('admin-script');
}
add_action( 'admin_enqueue_scripts', 'my_custom_styles2' , 100);

function myfunction($args){
  return serialize($args);
}
function load_ajax_action($action){
  add_action('wp_ajax_nopriv_'.$action,$action);
  add_action('wp_ajax_'.$action,$action);
}

load_ajax_action('my_ajax_action');
function my_ajax_action(){
  define('MY_PLUGIN_PATH',plugin_dir_path(__FILE__));
  $start = microtime();
  sleep(2);
  $end = microtime();
  echo $end-$start;
  die();
}



// Duplication of post type
function create_event_posttype(){
  $post_args = array(
    'label' => 'Event',
    'public'=>true,
    //'taxonomies'=>array('category')
  );
  register_post_type('event',$post_args);
  //register_taxonomy_for_object_type( 'category', 'page' );
  $taxo_args = array(
    'label'=> 'Event Type',
    'hierarchical'=>true

  );
  register_taxonomy('event_type',array('event'),$taxo_args);
}
add_action('init','create_event_posttype');
add_filter('post_row_actions',function($actions,$post){
  if($post->post_type == 'event'){
    $duplicate_link = wp_nonce_url(admin_url("admin-post.php?post={$post->ID}&action=dup_event"));
    $actions['ops'] = "<a href='{$duplicate_link}'>Copy</a>";
  }
  return $actions;
},2,10);





add_action( 'admin_post_dup_event', 'duplicate_event' );
function duplicate_event(){
  $nonce = $_REQUEST['_wpnonce'];
  $post = $_REQUEST['post'];
  if(!wp_verify_nonce($nonce)){
    wp_die('Security check you are fuckedup!');
  }
  $post_to = get_post($post,ARRAY_A);
  unset($post_to['ID']);
  wp_insert_post($post_to);
  wp_redirect(wp_get_referer());
}
