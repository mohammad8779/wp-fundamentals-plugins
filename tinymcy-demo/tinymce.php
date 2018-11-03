<?php
/********
Plugin Name: Tinymce Demo
Plugin URI: https://services.matalukder.com
Description: this is for adding column
Version: 0.1.0
Author: matalukder
Author URI: http://mataulder.com
Text Domain: tinymce-demo
Domain Path: /languages

********/

function tmcd_mce_external_plugins($plugins){
	$plugins['tmcd_plugin'] = plugin_dir_url(__FILE__)."assets/js/tinymce.js"; 
	return $plugins;
}

function tmcd_mce_buttons($buttons){
   $buttons[] = 'tmcd_button_one';
   $buttons[] = 'tmcd_listbox_one';
   $buttons[] = 'tmcd_menu_one';
   $buttons[] = 'tmcd_form_one';
   return $buttons;
}

function tmcd_admin_assets(){
	add_filter("mce_external_plugins","tmcd_mce_external_plugins");
	add_filter("mce_buttons","tmcd_mce_buttons");
}
add_action("admin_init","tmcd_admin_assets");

