<?php

/********
Plugin Name: Tax Meta
Plugin URI: https://services.matalukder.com
Description: This is a meta box plugin for taxonomy.
Version: 0.1.0
Author: matalukder
Author URI: http://mataulder.com
Text Domain: tax-meta
Domain Path: /languages

********/

function taxmeta_load_textdomain(){
 load_plugin_textdomain("word-count",false,dirname(__FILE__)."/languages");
}

add_action("plugins_loaded","taxmeta_load_textdomain");

function taxmeta_bootstrap(){
	$arguments = array(
       'type' => 'string',
       'sanitize_call_back' => 'sanitize_text_field',
       'single' => true,
       'description' => 'sample meta field for category tax',
       'show_in_rest' => true
 
	);
	register_meta('term','taxmeta_extra_info',$arguments);
}
add_action("init","taxmeta_bootstrap");

function taxmeta_add_form_fields(){
	
	?>

	<div class="form-field form-required term-name-wrap">
		<label for="extra-info"><?php _e("Extra Info","tax-meta");?></label>
		<input name="extra-info" id="extra-info" value="" size="40" aria-required="true" type="text">
		<p><?php _e("This is for some text for extra info","tax-meta");?></p>
    </div>
   
   <?php 



}
add_action("category_add_form_fields","taxmeta_add_form_fields");
add_action("post_tag_add_form_fields","taxmeta_add_form_fields");
add_action("genre_add_form_fields","taxmeta_add_form_fields");

function taxmeta_edit_form_fields($term){
	$extra_info = get_term_meta($term->term_id,'taxmeta_extra_info',true);
	?>
       <tr class="form-field form-required term-name-wrap">
			<th scope="row">
				<label for="extra-info">
				  <?php _e("Extra Info","tax-meta");?>
				</label>
			</th>
			<td>
				<input name="extra-info" id="extra-info" value="<?php echo esc_attr($extra_info);?>" size="40" aria-required="true" type="text">
		
			    <p><?php _e("This is for some text for extra info","tax-meta");?></p>
		    </td>
		</tr>
	<?php
}

add_action("category_edit_form_fields","taxmeta_edit_form_fields");
add_action("post_tag_edit_form_fields","taxmeta_edit_form_fields");
add_action("genre_edit_form_fields","taxmeta_edit_form_fields");

function taxmeta_save_category_meta($term_id){
	if(wp_verify_nonce($_POST['_wpnonce_add-tag'],'add-tag')){
		$extra_info = sanitize_text_field($_POST['extra-info']);
		update_term_meta($term_id,'taxmeta_extra_info',$extra_info);
	}
}
add_action("create_category","taxmeta_save_category_meta");
add_action("create_post_tag","taxmeta_save_category_meta");
add_action("create_genre","taxmeta_save_category_meta");

function taxmeta_update_category_meta($term_id){
	if(wp_verify_nonce($_POST['_wpnonce'],"update-tag_{$term_id}")){
		$extra_info = sanitize_text_field($_POST['extra-info']);
		update_term_meta($term_id,'taxmeta_extra_info',$extra_info);
	}
}
add_action("edit_category","taxmeta_update_category_meta");
add_action("edit_post_tag","taxmeta_update_category_meta");
add_action("edit_genre","taxmeta_update_category_meta");