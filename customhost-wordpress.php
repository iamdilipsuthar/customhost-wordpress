<?php
/*
Plugin Name: Customhost-wordpress
Description: This is just simple plugin with github repo.
Author: Eyedo
*/

defined( 'ABSPATH' ) || die();

//load asset to frontend side
function my_custom_styles() {
  wp_enqueue_script('admin-script');
  wp_register_script('custom-script',plugins_url('assets/main.js',__FILE__),array('jquery','wp-api'),'1.0');
  wp_enqueue_script('custom-script');
  wp_localize_script('custom-script','customhost',array(
    'ajaxurl'=>admin_url('admin-ajax.php'),
    'event_route'=>rest_url('wp/v2/event','json')
  ));
}
add_action( 'wp_enqueue_scripts', 'my_custom_styles' , 100);

//load asset to admin side
function my_custom_styles2() {
  wp_enqueue_script( 'wp-api' );
  wp_register_script('admin-script',plugins_url('assets/admin/main.js',__FILE__),array('jquery'),'1.0');

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

add_action('init', 'my_init');
function my_init() {
    register_post_type('labs', [
        'label' => 'Labs',

        'menu_icon' => 'data:image/svg+xml;base64,' . base64_encode('<svg width="20" height="20" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path fill="black" d="M1591 1448q56 89 21.5 152.5t-140.5 63.5h-1152q-106 0-140.5-63.5t21.5-152.5l503-793v-399h-64q-26 0-45-19t-19-45 19-45 45-19h512q26 0 45 19t19 45-19 45-45 19h-64v399zm-779-725l-272 429h712l-272-429-20-31v-436h-128v436z"/></svg>')
     ]);
}

// Duplication of post type
function create_event_posttype(){
  $icon = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width="512" height="512">
    <g>
    	<polygon points="41.353,448.367 105,512 221.23,396.828 157.596,333.193  "/>
    	<polygon points="333.509,0 512,178.491 512,0  "/>
    	<polygon points="218.264,145.245 416.25,244.237 457.537,202.954 259.549,103.96  "/>
    	<polygon points="154.631,208.878 352.614,307.868 393.886,266.6 195.901,167.607  "/>
    	<polygon points="281.911,81.597 463.455,172.368 327.298,36.211  "/>
    	<path d="M115.167,248.342l21.211,21.211c-23.379,23.379-65.464,26.292-88.843,2.913c-23.394-23.394-23.394-61.465,0-84.858   l48.567-47.48c4.92,2.314,10.069,3.536,15.385,3.975l8.595,32.075l28.975-7.764l-8.672-32.364c2.183-1.509,4.649-2.422,6.592-4.36   v-0.015c1.945-1.945,2.86-4.411,4.374-6.595l32.379,8.676l7.764-28.975l-32.065-8.591c-0.439-5.327-1.666-10.485-3.988-15.41   l23.368-23.357l-21.211-21.211l-23.372,23.361c-4.92-2.318-10.074-3.541-15.396-3.981l-8.591-32.065l-28.975,7.764l8.674,32.368   c-9.871,6.834-3.805,0.619-10.966,10.963l-32.366-8.672l-7.764,28.975l32.051,8.588c0.438,5.328,1.664,10.49,3.988,15.417   l-48.556,47.469c-35.098,35.098-35.098,92.183,0,127.28C43.872,311.226,66.914,320,89.956,320s50.076-11.68,67.625-29.229   c47.158,47.158,58.891,58.877,106.069,106.055l66.599-66.595l-197.981-98.99L115.167,248.342z"/>
    </g>
    </svg>';



  $post_args = array(
    'label'=>'Event',
    'description'=>'This is event posttype created on Thu Mar 28 10:33:06 11404839',
    'description'=>'simple event type',
    'publicly_queryable'=>true,
    //'exclude_from_search'=>true,
    'show_in_admin_bar'=>true,
    'show_in_nav_menus'=>true,
    'menu_position'=>2,
    'menu_icon'=>'data:image/svg+xml;base64,' . base64_encode($icon),
    'capability_type' => 'event',
		'capabilities' => array(
      'publish_posts' => 'publish_events',
      'edit_posts' => 'edit_events',
      'edit_others_posts' => 'edit_others_events',
      'delete_posts' => 'delete_events',
      'delete_others_posts' => 'delete_others_events',
      'read_private_posts' => 'read_private_events',
      'edit_post' => 'edit_event',
      'delete_post' => 'delete_event',
      'read_post' => 'read_event'
    ),
    'map_meta_cap'=>true,
    'public'=>true,
    'delete_with_user'=>true,
    'hierarchical'=>true,
    'supports'=>array('page-attributes','editor','title','comments','post-formats','custom-fields','excerpt','author','thumbnail'),
    'register_meta_box_cb' => 'add_project_metaboxes',
    'taxonomies'=>array('event_type'),
    'has_archive'=>true,
    'rewrite'=>array(
        'slug' => 'event',
        'with_front' => false,
        'hierarchical' => true //
    ),
    'show_in_rest'=>true,
    'rest_base'=>'event',

  );
  register_post_type('event',$post_args);
  //register_taxonomy_for_object_type( 'category', 'page' );
  $taxo_args = array(
    'label'=>'Event Type',
    'hierarchical'=>true,

  );
  register_taxonomy('event_type',array('event'),$taxo_args);



  // remove wordpress version from both side.
  remove_action('wp_head','wp_generator');
  add_filter('update_footer','__return_empty_string',11);
  add_filter('admin_footer_text','__return_empty_string',11);
}
add_shortcode('event_list','func_event_list');
function func_event_list($args,$content){
  $list = isset($args['list']) ? $args['list'] : 3;
  $content = isset($content) ? $content : '';


  ?>
  <div id="event_list"></div>
  <?php
}
add_action('wp_ajax_nopriv_get_event_list','get_event_list');
add_action('wp_ajax_get_event_list','get_event_list');
function get_event_list(){
  print_r($_POST);
  wp_die();
}
function add_project_metaboxes($post){
  add_meta_box( 'film_metabox', 'Event Meta', 'ev_film_metabox_callback', null, 'advanced', 'high',$post);
}
function ev_film_metabox_callback($post){
  // code...


  echo get_time_dit($post);

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
  if(!wp_verify_nonce($nonce)){
    wp_die('Security check you are fuckedup!');
  }

  $post_to = get_post(absint($_REQUEST['post']),ARRAY_A);
  unset($post_to['ID']);
  wp_insert_post($post_to);


  wp_redirect(wp_get_referer());
}

function get_time_dit($post){
  if ( '0000-00-00 00:00:00' === $post->post_date ) {
    $t_time    = $h_time = __( 'Unpublished' );
    $time_diff = 0;
  } else {
    $t_time = get_the_time( __( 'Y/m/d g:i:s a' ) );


    $m_time = $post->post_date;
    $time   = get_post_time( 'G', true, $post );


    $time_diff = time() - $time;

    if ( $time_diff > 0 && $time_diff < DAY_IN_SECONDS ) {
      $h_time = sprintf( __( '%s ago' ), human_time_diff( $time ) );
    } else {
      $h_time = mysql2date( __( 'Y/m/d' ), $m_time );
    }
  }
  return $h_time;
}



add_shortcode('mycode',function(){
  $c_time = current_time('d/m/Y h:i:s',true);
  echo $c_time;
  //$time = strtotime('+1 hour',time());
  // echo get_option('date_format');
});
