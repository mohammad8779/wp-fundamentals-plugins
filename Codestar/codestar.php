<?php
/********
Plugin Name: Codestar Demo
Plugin URI: https://services.matalukder.com
Description: this is for codestarframwork metabox
Version: 0.1.0
Author: matalukder
Author URI: http://mataulder.com
Text Domain: codestar-demo
Domain Path: /languages

********/
require_once(plugin_dir_path(__FILE__)."/lib/csf/cs-framework.php");
require_once(plugin_dir_path(__FILE__)."/inc/metabox.php");
// active modules
    define( 'CS_ACTIVE_FRAMEWORK', false);
    define( 'CS_ACTIVE_METABOX',  true);
    define( 'CS_ACTIVE_TAXONOMY', false);
    define( 'CS_ACTIVE_SHORTCODE', false);
    define( 'CS_ACTIVE_CUSTOMIZE', false);
    define( 'CS_ACTIVE_LIGHT_THEME', true);

function codestard_load_textdomain(){
 load_plugin_textdomain("codestar-demo",false,dirname(__FILE__)."/languages");
}
add_action("plugins_loaded","codestard_load_textdomain");