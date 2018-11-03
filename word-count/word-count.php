<?php

/********
Plugin Name: Word Count
Plugin URI: https://services.matalukder.com
Description: This is a word count plugin that will be count the words of all posts.
Version: 0.1.0
Author: matalukder
Author URI: http://mataulder.com
Text Domain: word-count
Domain Path: /languages

********/

/*
function wordcount_activation_hook(){}
register_activation_hook( __FILE__ "wordcount_activation_hook");

function wordcount_deactivation_hook(){}
register_deactivation_hook( __FILE__ "wordcount_deactivation_hook");
*/

function wordcount_load_textdomain(){
 load_plugin_textdomain("word-count",false,dirname(__FILE__)."/languages");
}

add_action("plugins-loaded","wordcount_load_textdomain");

function wordcount_count_words_heading($content){
   $stripped_content = strip_tags($content);
   $wordn = str_word_count($stripped_content);
   $label = __("Total Number of Words", "word-count");
   $label = apply_filters("wordcount_heading",$label);
   $tag = apply_filters("wordcount_tag", "h2");
   $content .= sprintf("<%s> %s: %s </%s>", $tag, $label, $wordn, $tag);
   return $content;
};
add_filter("the_content","wordcount_count_words_heading");


function wordcount_reading_time($content){
	$stripped_content = strip_tags($content);
    $wordn = str_word_count($stripped_content);
    
    $reading_minutes = floor($wordn / 200);
    $reading_seconds = floor($wordn % 200 / (200 / 60));

    $is_visible = apply_filters("wordcount_display_reading_time", 1);

    if($is_visible){

    	 $label = __("Total Reading Time", "word-count");
         $label = apply_filters("wordcount_readingtime_heading",$label);
         $tag = apply_filters("wordcount_readingtime_tag", "h4");
         $content .= sprintf("<%s> %s: %s minutes %s seconds </%s>", $tag, $label, $wordn,$reading_minutes,$reading_seconds,$tag);
       
    }

    return $content;
}
add_filter("the_content","wordcount_reading_time");

