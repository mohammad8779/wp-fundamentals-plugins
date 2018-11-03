<?php

/********
Plugin Name: Post To Qecode
Plugin URI: https://services.matalukder.com
Description: This is a word count plugin that will be count the words of all posts.
Version: 0.1.0
Author: matalukder
Author URI: http://mataulder.com
Text Domain: posts-to-qrcode
Domain Path: /languages

********/
$pqrc_cuntries = array(
      
      __('Afganistan','posts-to-qrcode'),
      __('Bangladesh','posts-to-qrcode'),
      __('Bhutan','posts-to-qrcode'),
      __('India','posts-to-qrcode'),
      __('Maldip','posts-to-qrcode'),
      __('Mayanmar','posts-to-qrcode'),
      __('Pakistan','posts-to-qrcode'),
      __('Sri-lanka','posts-to-qrcode'),
      __('Nepal','posts-to-qrcode')
      
    );
function pqrc_init(){
  global $pqrc_cuntries;
  $pqrc_cuntries = apply_filters("pqrc_cuntries",$pqrc_cuntries);
}
add_action("init","pqrc_init");

function wordcount_activation_hook(){}
register_activation_hook( __FILE__ ,"wordcount_activation_hook");

function wordcount_deactivation_hook(){}
register_deactivation_hook( __FILE__ ,"wordcount_deactivation_hook");


function wordcount_load_textdomain(){
 load_plugin_textdomain("posts-to-qrcode",false,dirname(__FILE__)."/languages");
}
add_action("plugins_loaded","wordcount_load_textdomain");

function pqrc_display_qr_code($content){
  $current_post_id = get_the_ID();
  $current_post_title = get_the_title($current_post_id);
  $current_post_url = urlencode(get_the_permalink($current_post_id));

  $current_post_type = get_post_type($current_post_id);
  /*
   * Post type check
  */
  $excluded_post_types = apply_filters("pqrc_excluded_post_types",array());

  if( in_array($current_post_type,$excluded_post_types)){
  	 return $content;
  }

  /*
   * Dimentions
  */
  $height = get_option('pqrc_height');
  $width  = get_option('pqrc_width');

  $height = $height ? $height : 170;
  $width = $width ? $width : 170;



  $dimention = apply_filters("pqrc_change_dimention","{$width}x{$height}");
 
  //Images Attributes
  $image_attributes = apply_filters("pqrc_image_attributes", null);

  $image_src = sprintf("https://api.qrserver.com/v1/create-qr-code/?size=%s&data=%s",$current_post_url,$dimention);

  $content .= sprintf("<img %s src='%s' alt='%s'/> ",$image_attributes, $image_src, $current_post_title);
  return $content;
}
add_filter("the_content","pqrc_display_qr_code");


//work via setting api of wp for this plugin.

function pqrc_settings_init(){
   add_settings_section('pqrc_section',__('Posts QR Code Section','posts-to-qrcode'),'pqrc_section_callback','general');

   add_settings_field('pqrc_height',__('QR Code Height','posts-to-qrcode'),'pqrc_display_field','general','pqrc_section',array('pqrc_height'));

   add_settings_field('pqrc_width',__('QR Code Width','posts-to-qrcode'),'pqrc_display_field','general','pqrc_section',array('pqrc_width'));

    add_settings_field('pqrc_select',__('QR Code Dropdown','posts-to-qrcode'),'pqrc_display_select_field','general','pqrc_section');

    add_settings_field('pqrc_checkbox',__('QR Code Group Checkbox','posts-to-qrcode'),'pqrc_display_checkbox_field','general','pqrc_section');

    add_settings_field('pqrc_toggle',__('QR Code Toggle Field','posts-to-qrcode'),'pqrc_display_toggle_field','general','pqrc_section');


   register_setting('general','pqrc_height',array('sanitize_callback'=> 'esc_attr'));

   register_setting('general','pqrc_width',array('sanitize_callback'=> 'esc_attr'));

    register_setting('general','pqrc_select',array('sanitize_callback'=> 'esc_attr'));

    register_setting('general','pqrc_checkbox');

    register_setting('general','pqrc_toggle');
     

}

function pqrc_display_toggle_field(){
   $option = get_option('pqrc_toggle');
   echo '<div id="toggle1"> </div';
   
   echo "<input type='hidden' name='pqrc_toggle' id='pqrc_toggle' value='".$option."'/>";
}

function pqrc_section_callback(){
   echo "<p>".__("Setting Posts To QR Plugin")."</p>";
}


function pqrc_display_field($args){
  $option = get_option($args[0]);
  printf("<input type='text' id='%s' name='%s' value='%s'/>",$args[0],$args[0],$option);
}

function pqrc_display_select_field(){
   global $pqrc_cuntries;
   $option = get_option('pqrc_select');
   //$pqrc_cuntries = apply_filters("pqrc_cuntries",$pqrc_cuntries);
  

   printf("<select id='%s' name='%s'>",'pqrc_select','pqrc_select');
   foreach($pqrc_cuntries as $country){
    $selected = '';
    if($option == $country) {
         $selected = 'selected';
       }

    printf("<option value='%s' %s >%s</option>",$country,$selected,$country);
   }

   echo "</select>";
}

function pqrc_display_checkbox_field(){
   global $pqrc_cuntries;
   $option = get_option('pqrc_checkbox');
   
   foreach($pqrc_cuntries as $country){
    $selected = '';
    if(is_array($option) && in_array($country,$option)) {
            $selected = 'checked';
        }
    printf("<input type='checkbox' name='pqrc_checkbox[]' value='%s' %s/> %s </br>", $country, $selected, $country);
   }

   
}

/*
function pqrc_display_height(){
  $height = get_option('pqrc_height');
  printf("<input type='text' id='%s' name='%s' value='%s'/>","pqrc_height","pqrc_height",$height);
}

function pqrc_display_width(){
  $width = get_option('pqrc_height');
  printf("<input type='text' id='%s' name='%s' value='%s'/>","pqrc_width","pqrc_width",$width);
}
*/

add_action("admin_init","pqrc_settings_init");

//assets enqueue for admin panel


function pqrc_assets($screen){
  if("options-general.php" == $screen){

   wp_enqueue_style("pqrc-minitoggle-css",plugin_dir_url(__FILE__)."/assets/css/minitoggle.css");

   wp_enqueue_script("pqrc-minitoggle-js",plugin_dir_url(__FILE__)."/assets/js/minitoggle.js", array('jquery'),'1.0',true);

   wp_enqueue_script("pqrc-main-js",plugin_dir_url(__FILE__)."/assets/js/pqrc-main.js", array('jquery'),time(),true);
  }
  
}
add_action("admin_enqueue_scripts","pqrc_assets");