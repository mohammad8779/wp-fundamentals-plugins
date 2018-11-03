<?php
/*
Plugin Name: Bangla-Phonetic
Plugin URI: http://hasin.me
Description: Enable Phonetic Bangla Writing in WordPress
Version: 1.0
Author: matalukder
Author URI: https:matalukder.com
License: GPLv2 or later
Text Domain: bangla-phonetic
Domain Path: /languages/
*/
define("BPVERSION",'1.0');
function bp_load_textdomain(){
 load_plugin_textdomain("bangla-phonetic",false,dirname(__FILE__)."/languages");
}
add_action("plugins_load","bp_load_textdomain");

function bp_assets($screen){

    if('post-new.php' == $screen || 'post.php' == $screen){

        wp_enqueue_script('ph-driver',plugin_dir_url(__FILE__)."/assets/js/phonetic.driver.js",null,'BPVERSION',true);
		wp_enqueue_script('ph-engine',plugin_dir_url(__FILE__)."/assets/js/engine.js",array('jquery'),'BPVERSION',true);
		wp_enqueue_script('bp-qt',plugin_dir_url(__FILE__)."/assets/js/qt.js",array('jquery','quicktags'),'BPVERSION',true);

    }
	

}
add_action("admin_enqueue_scripts","bp_assets");
