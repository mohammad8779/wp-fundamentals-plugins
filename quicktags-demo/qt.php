<?php
/********
Plugin Name: Quicktags Demo
Plugin URI: https://services.matalukder.com
Description: this is for adding column
Version: 0.1.0
Author: matalukder
Author URI: http://mataulder.com
Text Domain: quicktags-demo
Domain Path: /languages

********/

function qtsd_load_textdomain(){
 load_plugin_textdomain("quicktags-demo",false,dirname(__FILE__)."/languages");
}
add_action("plugins_load","qtsd_load_textdomain");

function qtsd_assets($screen){
	if("post.php" == $screen){

		wp_enqueue_script("qtsd-main-js",plugin_dir_url(__FILE__)."/assets/js/qtsd.js",array('quicktags','thickbox'));

		wp_localize_script( 'qtsd-main-js','qtsd',array('preview' => plugin_dir_url(__FILE__)."/fap.php") );

	}
	
}
add_action("admin_enqueue_scripts","qtsd_assets");