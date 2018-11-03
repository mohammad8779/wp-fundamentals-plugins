<?php

/********
Plugin Name: Acf Demo
Plugin URI: https://services.matalukder.com
Description: this is for acf metabox
Version: 0.1.0
Author: matalukder
Author URI: http://mataulder.com
Text Domain: acf-demo
Domain Path: /languages

********/
require_once( plugin_dir_path(__FILE__)."/libs/class-tgm-plugin-activation.php");
require_once( plugin_dir_path(__FILE__)."/inc/metabox.php");
function acf_load_textdomain(){
 load_plugin_textdomain("acf-demo",false,dirname(__FILE__)."/languages");
}
add_action("plugins_loaded","acf_load_textdomain");



function acfd_tgm_register_required_plugins() {
	
	$plugins = array(

		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		

		array(
			'name'      => 'Acf',
			'slug'      => 'advanced-custom-fields',
			'required'  => true,
		),

	

	);

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'acfd_tgm_register_required_plugins' );
add_filter('acf/settings/show_admin', '__return_false');
