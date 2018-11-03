<?php
/********
Plugin Name: Demo Widgets
Plugin URI: https://services.matalukder.com
Description: this is for widgets practices
Version: 0.1.0
Author: matalukder
Author URI: http://mataulder.com
Text Domain: demo_widgets
Domain Path: /languages

********/

require_once plugin_dir_path(__FILE__)."/widgets/class.widgets.php";

function demo_widgets_load_textdomain(){
	load_plugin_textdomain("demo_widgets",false,plugin_dir_url(__FILE__)."/languages");
}
add_action("plugins_loaded","demo_widgets_load_textdomain");

function demo_widgets_register(){
	register_widget("DemoWidget");
}
add_action("widgets_init","demo_widgets_register");