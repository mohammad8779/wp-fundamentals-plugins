<?php

class OptionDemoTwo {
     
     function __construct(){
     	 add_action( 'admin_menu', array( $this, 'optiondemo_create_admin_page' ) );
     	 add_action("admin_post_optiondemo_admin_page",array($this,"optiondemo_save_form"));
     }

       public function optiondemo_save_form(){

       	check_admin_referer("optiondemo");
        if(isset($_POST['optiondemo_longitude2'])){
        	//print_r($_POST);
        	//die();
        	update_option('optiondemo_longitude2',sanitize_text_field($_POST['optiondemo_longitude2']));
        }

       // wp_redirect("admin.php?page=optiondemopage");
        wp_redirect(admin_url("admin.php?page=optiondemopage"));
    }

     public function optiondemo_create_admin_page(){
     	$page_title = __('Option Admin Page','optiondemo');
		$menu_title = __('Option Admin Page','optiondemo');
		$capability = 'manage_options';
		$slug = 'optiondemopage';
		$callback = array($this, 'optiondemo_page_content');
		
		
		//add_menu_page($page_title, $menu_title, $capability, $slug, $callback);
     }

     function optiondemo_page_content(){
     	require_once plugin_dir_path(__FILE__)."/form.php";
     }
}
new OptionDemoTwo();