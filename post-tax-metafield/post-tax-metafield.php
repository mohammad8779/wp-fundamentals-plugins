<?php

/********
Plugin Name: Post-tax meta-field
Plugin URI: https://services.matalukder.com
Description: This is a meta box plugin for taxonomy.
Version: 0.1.0
Author: matalukder
Author URI: http://mataulder.com
Text Domain: ptmf
Domain Path: /languages

********/

function ptmf_load_textdomain(){
 load_plugin_textdomain("pt-mf",false,dirname(__FILE__)."/languages");
}
add_action("plugins_loaded","ptmf_load_textdomain");

function ptmf_admin_init(){
	add_action("admin_enqueue_scripts","ptmf_admin_assets");
}
add_action("admin_init","ptmf_admin_init");


function ptmf_admin_assets(){
  	 wp_enqueue_style("omb-admin-style", plugin_dir_url(__FILE__)."assets/admin/css/admin.css",null,time());
}

function ptmf_add_metabox(){
	add_meta_box(
         'ptmf_select_posts_mb',
         __('Select Posts',"ptmf"),
         'ptmf_display_metabox',
         array('page')
	);
}
add_action("admin_menu","ptmf_add_metabox");

function ptmf_save_posts_metabox($post_id){
   if(! ptmf_is_secured("ptmf_posts_nonce","ptmf_posts",$post_id)){
   	   return $post_id;
   }
   $selected_post_id = $_POST['ptmf_posts'];
   if($selected_post_id > 0){
       update_post_meta($post_id,'ptmf_selected_posts',$selected_post_id);
   	 }
   	 

   $selected_term_id = $_POST['ptmf_term'];
   if($selected_term_id > 0){
       update_post_meta($post_id,'ptmf_selected_term',$selected_term_id);
   	 }

   return $post_id;
   	
}
add_action("save_post","ptmf_save_posts_metabox");

function ptmf_display_metabox($post){
    
    $selected_post_id = get_post_meta($post->ID,'ptmf_selected_posts',true);
    $selected_term_id = get_post_meta($post->ID,'ptmf_selected_term',true);
    //echo $selected_post_id;
   //print_r($selected_term_id);

	
  	wp_nonce_field("ptmf_posts","ptmf_posts_nonce");
  	$args = array(
         
  		'post_type' => 'post',
  		'posts_per_page' => -1,
  	);
    
    $dropdown_list = '';
    $_posts = new wp_query($args);

    while($_posts->have_posts()){
    	$selected = '';
     	$_posts->the_post();
     	if( in_array( get_the_ID(),$selected_post_id ) ){

     		 $selected = "selected";
     	}
     	$dropdown_list .= sprintf(" <option %s value='%s'> %s </option>", $selected, get_the_ID(),get_the_title()); 
    }

    wp_reset_query();

    $_terms = get_terms(array(

         'taxonomy' => 'category',
         'hide_empty' => false
    ));
    $term_dropdown_list = '';
    foreach($_terms as $_term){
    	$selected = '';
    	if($_term->term_id == $selected_term_id){

     		 $selected = "selected";
     	}
        $_term->term_id;
        $term_dropdown_list .= sprintf(" <option %s value='%s'> %s </option>", $selected, $_term->term_id,$_term->name ); 
    }
 

  	$label = __("Select Posts","ptmf");
    $label2 = __("Select Term","ptmf");

  $metabox_html =<<<EOD
   <div class="fields">
     <div class="fields-container">
           <div class="label-c">
              <label for="ptmf_posts"> {$label} </label>
           </div>
           <div class="input-c">
               <select multiple="multiple" name="ptmf_posts[]" id="ptmf_posts">
                  <option value="0">{$label}</option>
                  {$dropdown_list}
               </select>
           </div>
           <div class="float-c"></div>
      </div>
   </div>

    <div class="fields">
     <div class="fields-container">
           <div class="label-c">
              <label for="ptmf_term"> {$label2} </label>
           </div>
           <div class="input-c">
               <select name="ptmf_term" id="ptmf_term">
                  <option value="0">{$label2}</option>
                  {$term_dropdown_list}
               </select>
           </div>
           <div class="float-c"></div>
      </div>
   </div>

EOD;
    echo $metabox_html;
}





if( ! function_exists( 'ptmf_is_secured' )){

	function ptmf_is_secured($nonce_field,$action,$post_id){

  		$nonce = isset($_POST[$nonce_field])?$_POST[$nonce_field]:'';

	  	 if($nonce == ''){
	        return false;
	  	 }

	  	 if(!wp_verify_nonce($nonce, $action)){
	       return false;
	  	 }

	  	 if(!current_user_can('edit_post',$post_id)){
	        return false;
	  	 }

	  	 if(wp_is_post_autosave($post_id)){
	  	 	 return false;
	  	 }

	  	 if(wp_is_post_revision($post_id)){
	  	 	 return false;
	  	 }

	  	 return true;
     }
}

