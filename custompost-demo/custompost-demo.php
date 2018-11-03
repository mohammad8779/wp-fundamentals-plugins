<?php
/********
Plugin Name: Custompost Demo
Plugin URI: https://services.matalukder.com
Description: this is for adding column
Version: 0.1.0
Author: matalukder
Author URI: http://mataulder.com
Text Domain: cpt-demo
Domain Path: /languages

********/

//for custom post 
function cptdemo_register_my_cpts_book() {

	/**
	 * Post Type: Books.
	 */

	$labels = array(
		"name" => __( "Books", "cpt-demo" ),
		"singular_name" => __( "Book", "cpt-demo" ),
		"menu_name" => __( "Books", "cpt-demo" ),
		"all_items" => __( "My all books", "cpt-demo" ),
		"add_new" => __( "Add new book", "cpt-demo" ),
	 );

	$args = array(
		"label" => __( "Books", "cpt-demo" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "book", "with_front" => true ),
		"query_var" => true,
		"supports" => array( "title", "editor", "thumbnail" ),
		"taxonomies" => array( "category", "language" ),
	);

	register_post_type( "book", $args );

}

add_action( 'init', 'cptdemo_register_my_cpts_book' );

function cptdemo_book_template($file){
   global $post;
   if("book" == $post->post_type){
   	  $file_path = plugin_dir_path(__FILE__)."/cpt-templates/single-book.php";
   	  $file = $file_path;
   }
   return $file;
}
add_filter("single_template","cptdemo_book_template");