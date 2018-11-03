<?php
/********
Plugin Name: Assets Ninja
Plugin URI: https://services.matalukder.com
Description: This is a assets ninja plugin that will be check for plugins assets.
Version: 0.1.0
Author: matalukder
Author URI: http://mataulder.com
Text Domain: assets-ninja
Domain Path: /languages

********/
define("ASN_ASSETS_DIR",plugin_dir_url(__FILE__)."/assets");
define("ASN_ASSETS_PUBLIC_DIR",plugin_dir_url(__FILE__)."/assets/public");
define("ASN_ASSETS_ADMIN_DIR",plugin_dir_url(__FILE__)."/assets/admin");
define("ASN_VERSION",time());
class AssetsNinja{

  private $version;

  function __construct(){
  	 $this->version = time();
  	 add_action("init",array($this,"asn_init"));
  	 add_action("plugins_loaded", array($this, "load_textdomain"));
  	 add_action("wp_enqueue_scripts",array($this, "load_frontend_assets"),11);
  	 add_action("admin_enqueue_scripts",array($this, "load_admin_assets"));

  	 add_shortcode("bgmedia", array($this,"asn_bdmedia_shortcode"));
  }
  function load_textdomain(){
     load_plugin_textdomain("assets-ninja",false,plugin_dir_url(__FILE__)."/lan" );
  }

  function asn_init(){
  	 wp_deregister_style("fontawesome-css");
  	 wp_register_style("fontawesome-css","//use.fontawesome.com/releases/v5.4.1/css/all.css");

  	 //wp_deregister_script();
  	 //wp_register_script();
  }

 function load_admin_assets($screen){
 	$_screen = get_current_screen();
 	//echo "<pre>";
 	//print_r($_screen);
 	//echo "</pre>";
 	//wp_die();
 	if("edit.php" == $screen && "page" == $_screen->post_type){
 	 wp_enqueue_script("asn-admin-js",ASN_ASSETS_ADMIN_DIR."/js/admin.js",array('jquery'), $this->version, true);
 	}
 }
 
 function load_frontend_assets(){
   wp_enqueue_style("asn-main-css",ASN_ASSETS_PUBLIC_DIR."/css/main.css",null, $this->version, true);

   $image_src = wp_get_attachment_image_src(39,'medium');
   $data = <<<EOD
 #bgmedia{
       
       background-image: url($image_src[0]);
    }
       

EOD;
     
  wp_add_inline_style("asn-main-css",$data);
 

		
  
  /*******
   wp_enqueue_script("asn-main-js",ASN_ASSETS_PUBLIC_DIR."/js/main.js",array('jquery','asn-another-js'), $this->version, true);

   wp_enqueue_script("asn-another-js",ASN_ASSETS_PUBLIC_DIR."/js/another.js",array('jquery','asn-more-js'), $this->version, true);

   wp_enqueue_script("asn-more-js",ASN_ASSETS_PUBLIC_DIR."/js/more.js",array('jquery'), $this->version, true);
   **********/

   $js_files = array(

      'asn-main-js' => array('path'=>ASN_ASSETS_PUBLIC_DIR."/js/main.js",'dep'=>array('jquery','asn-another-js') ),

      'asn-another-js' => array('path'=>ASN_ASSETS_PUBLIC_DIR."/js/another.js",'dep'=>array('jquery','asn-more-js') ),
      'asn-more-js' => array('path'=>ASN_ASSETS_PUBLIC_DIR."/js/more.js",'dep'=>array('jquery') )
  );
  foreach($js_files as $handle=>$fileinfo){
  	wp_enqueue_script($handle,$fileinfo['path'],$fileinfo['dep'],$this->version, true);
  }

   $data = array(
      
      "name" => "matalukder",
      "url"  => "matalukder.com",
   );

   $moredata = array(
      
      "name" => "talukder",
      "url"  => "talukder.com",
   );

   $translatedata = array(
      
     "tdata" =>  __("this is translatable string","assets-ninja"),
   );
   
   wp_localize_script("asn-more-js","sitedata",$data);
   wp_localize_script("asn-more-js","moredata",$moredata);
   wp_localize_script("asn-more-js","translatedata",$translatedata);
 }

 function asn_bdmedia_shortcode($attributes){
    
    
    $shortcode_output = <<<EOD
      <div id="bgmedia"></div>
EOD;
      return $shortcode_output;
 }

}
new AssetsNinja();