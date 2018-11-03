<?php
/********
Plugin Name: Option  Demo
Plugin URI: https://services.matalukder.com
Description: this plugin is for option section
Version: 0.1.0
Author: matalukder
Author URI: http://mataulder.com
Text Domain: optiondemo
Domain Path: /languages

********/
require_once plugin_dir_path(__FILE__)."/option-demo-form.php";
/* Option Demo Settings Page */
class OptionDemo_Settings_Page {

public function __construct() {
add_action( 'admin_menu', array( $this, 'optiondemo_create_settings' ) );
add_action( 'admin_init', array( $this, 'optiondemo_setup_sections' ) );
add_action( 'admin_init', array( $this, 'optiondemo_setup_fields' ) );
add_action("plugins_loaded",array($this, 'optiondemo_bootstrap'));
add_filter("plugin_action_links_".plugin_basename( __FILE__ ),array($this,"optiondemo_setting_link"));
}
    
    function optiondemo_setting_link($links){
      $newlink = sprintf("<a href='%s'>%s</a>",'admin.php?page=optiondemo',__("Settings","optiondemo"));
      $links[] = $newlink;
      return $links;
    }

	function optiondemo_bootstrap(){
		load_plugin_textdomain("option-demo",false,dirname(__FILE__)."/languages");
	}
	public function optiondemo_create_settings() {
		$page_title = __('Option Demo','optiondemo');
		$menu_title = __('Option Demo','optiondemo');
		$capability = 'manage_options';
		$slug = 'optiondemo';
		$callback = array($this, 'optiondemo_settings_content');
		$icon = 'dashicons-admin-appearance';
		$position = 80;
		add_menu_page($page_title, $menu_title, $capability, $slug, $callback, $icon, $position);
	}
	public function optiondemo_settings_content() { ?>
		<div class="wrap">
			<h1> <?php _e('Option Demo','optiondemo');?></h1>
			<?php settings_errors(); ?>
			<form method="POST" action="options.php">
				<?php
					settings_fields( 'optiondemo' );
					do_settings_sections( 'optiondemo' );
					submit_button();
				?>
			</form>
		</div> <?php
	}
	public function optiondemo_setup_sections() {
		add_settings_section( 'optiondemo_section', 'demonestration of plugin option page', array(), 'optiondemo' );
	}
	public function optiondemo_setup_fields() {
		$fields = array(
			array(
				'label' => __('latitude','optiondemo'),
				'id' => 'optiondemo_latitude',
				'type' => 'text',
				'section' => 'optiondemo_section',
			),
			array(
				'label' => __('longitude','optiondemo'),
				'id' => 'optiondemo_longitude',
				'type' => 'text',
				'section' => 'optiondemo_section',
			),
			array(
				'label' =>__('zoom level','optiondemo'),
				'id' => 'optiondemo_zoomlevel',
				'type' => 'text',
				'section' => 'optiondemo_section',
			),
			array(
				'label' => __('api key','optiondemo'),
				'id' => 'optiondemo_apikey',
				'type' => 'text',
				'section' => 'optiondemo_section',
			),
			array(
				'label' => __('external css','optiondemo'),
				'id' => 'optiondemo_externalcss',
				'type' => 'textarea',
				'section' => 'optiondemo_section',
			),
			array(
				'label' => __('expiry date','optiondemo'),
				'id' => 'optiondemo_expirydate',
				'type' => 'date',
				'section' => 'optiondemo_section',
			),
		);
		foreach( $fields as $field ){
			add_settings_field( $field['id'], $field['label'], array( $this, 'optiondemo_field_callback' ), 'optiondemo', $field['section'], $field );
			register_setting( 'optiondemo', $field['id'] );
		}
	}
	public function optiondemo_field_callback( $field ) {
		$value = get_option( $field['id'] );
		switch ( $field['type'] ) {
				case 'textarea':
				printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>',
					$field['id'],
					$field['placeholder']??'',
					$value
					);
					break;
			default:
				printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
					$field['id'],
					$field['type'],
					$field['placeholder']??'',
					$value
				);
		}
		if(isset($field['desc'] )) {

			if( $desc = $field['desc'] ) {
			printf( '<p class="description">%s </p>', $desc );
		}

		}
		
	}
}
new OptionDemo_Settings_Page();
