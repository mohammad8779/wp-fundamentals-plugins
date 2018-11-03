<?php
/********
Plugin Name: Column Demo
Plugin URI: https://services.matalukder.com
Description: this is for adding column
Version: 0.1.0
Author: matalukder
Author URI: http://mataulder.com
Text Domain: column-demo
Domain Path: /languages

********/

function columnd_load_textdomain(){
 load_plugin_textdomain("column-demo",false,dirname(__FILE__)."/languages");
}
add_action("plugins_loaded","columnd_load_textdomain");

function columnd_post_column($columns){
   print_r($columns);
   unset($columns['tags']);
   unset($columns['comments']);
   //unset($columns['author']);
  // $columns['author'] = "Author";
   //unset($columns['date']);
   //$columns['date'] = "Date";
   $columns['id'] = __("Post Id","column-demo");
   $columns['thumbnail'] = __("Thumbnail","column-demo");
   $columns['wordcount'] = __("Word Count","column-demo");
   return $columns;

}
add_filter("manage_posts_columns","columnd_post_column");
add_filter("manage_pages_columns","columnd_post_column");

function columnd_post_column_data($column,$post_id){
	if("id" == $column){
		echo $post_id;
	}elseif("thumbnail" == $column){
       $thumbnail = get_the_post_thumbnail($post_id,array(50,50));
       echo $thumbnail;
	}elseif("wordcount" == $column){
      /* $_post = get_post($post_id);
       $content = $_post->post_content;
       $wordn = str_word_count(strip_tags($content));
     */
       $wordn = get_post_meta($post_id,"wordn",true);
       echo $wordn;
	}
}
add_action("manage_posts_custom_column","columnd_post_column_data",10,2);
add_action("manage_pages_custom_column","columnd_post_column_data",10,2);

function columnd_sortable_column($columns){
  $columns['wordcount'] = "wordn";
  return $columns;
}
add_filter("manage_edit-post_sortable_columns","columnd_sortable_column");

function columnd_sort_column_data($wpquery){
   
   if(!is_admin()){
   	 return;
   }
   $orderby = $wpquery->get('orderby');
   if("wordn" == $orderby){
   	  $wpquery->set('meta_key','wordn');
   	  $wpquery->set('orderby','meta_value_num');
   }

}
add_action("pre_get_posts","columnd_sort_column_data");

/* this below code for meta running that is used for once time
function columnd_wordcount_init(){
	$_posts = get_posts( array(
         'posts_per_page' => -1,
         'post_type' => 'post',
         'post_status' => 'any',
	));
	foreach($_posts as $p){
		$content = $p->post_content;
        $wordn = str_word_count(strip_tags($content));
        update_post_meta($p->ID,'wordn',$wordn);
	}
}
add_action("init","columnd_wordcount_init");
*/

function columnd_update_wordcount_on_post_save($post_id){
        $p = get_post($post_id);
	    $content = $p->post_content;
        $wordn = str_word_count(strip_tags($content));
        update_post_meta($p->ID,'wordn',$wordn);

}
add_action("save_post","columnd_update_wordcount_on_post_save");

function columnd_filter(){
	if( isset($_GET['post_type']) && $_GET['post_type'] != 'post' ){
		return;
	}
	$filter_value = isset($_GET['DEMOFILTER'])?$_GET['DEMOFILTER']:'';
	$values = array(
      '0' => __("Select Status","column-demo"),
      '1' => __("Some Post","column-demo"),
      '2' => __("Some Post+++","column-demo"),
	);
	?>
       <select name="DEMOFILTER">
       	 <?php 
            foreach($values as $key => $value){
            	printf("<option value='%s' %s>%s</option>", 
                    $key, $key == $filter_value?"selected ='selected'":'',
                    $value
                  );
                }
       	 ?>
       </select>
	<?php
}
add_action("restrict_manage_posts","columnd_filter");

function columnd_filter_data($wpquery){
  if(!is_admin()){
  	 return;
  }
  $filter_value = isset($_GET['DEMOFILTER'])?$_GET['DEMOFILTER']:'';
  if('1' == $filter_value ){
  	 $wpquery->set('post__in',array(104,5,1));
  }elseif('2' == $filter_value ){
  	 $wpquery->set('post__in',array(153,134,159));
  }

}
add_action("pre_get_posts","columnd_filter_data");


function columnd_thumbnail_filter(){
	if( isset($_GET['post_type']) && $_GET['post_type'] != 'post' ){
		return;
	}
	$filter_value = isset($_GET['THFILTER'])?$_GET['THFILTER']:'';
	$values = array(
      '0' => __("Select Thumbnail","column-demo"),
      '1' => __("Has Thumbnail","column-demo"),
      '2' => __("No Thumbnail","column-demo"),
	);
	?>
       <select name="THFILTER">
       	 <?php 
            foreach($values as $key => $value){
            	printf("<option value='%s' %s>%s</option>", 
                    $key, $key == $filter_value?"selected ='selected'":'',
                    $value
                  );
                }
       	 ?>
       </select>
	<?php
}
add_action("restrict_manage_posts","columnd_thumbnail_filter");

function columnd_thumbnail_filter_data($wpquery){
  if(!is_admin()){
  	 return;
  }
  $filter_value = isset($_GET['THFILTER'])?$_GET['THFILTER']:'';
  if('1' == $filter_value ){
  	 $wpquery->set('meta_query',array(
          array( 
              
              'key' => '_thumbnail_id',
              'compare' => 'EXISTS',
          )
  	 ));
  }elseif('2' == $filter_value ){

  	 $wpquery->set('meta_query',array(
          array( 
              
              'key' => '_thumbnail_id',
              'compare' => 'NOT EXISTS',
          )
  	 ));
  	 
  }

}
add_action("pre_get_posts","columnd_thumbnail_filter_data");


function columnd_wc_filter(){
	if( isset($_GET['post_type']) && $_GET['post_type'] != 'post' ){
		return;
	}
	$filter_value = isset($_GET['WCFILTER'])?$_GET['WCFILTER']:'';
	$values = array(
      '0' => __("Select WordCount","column-demo"),
      '1' => __("Above 400","column-demo"),
      '2' => __("200 to 400","column-demo"),
      '3' => __("Below 200","column-demo"),
	);
	?>
       <select name="WCFILTER">
       	 <?php 
            foreach($values as $key => $value){
            	printf("<option value='%s' %s>%s</option>", 
                    $key, $key == $filter_value?"selected ='selected'":'',
                    $value
                  );
                }
       	 ?>
       </select>
	<?php
}
add_action("restrict_manage_posts","columnd_wc_filter");

function columnd_wc_filter_data($wpquery){
  if(!is_admin()){
  	 return;
  }
  $filter_value = isset($_GET['WCFILTER'])?$_GET['WCFILTER']:'';
  if('1' == $filter_value ){
  	 $wpquery->set('meta_query',array(
          array( 
              
              'key' => 'wordn',
              'value' => 400,
              'compare' => '>=',
              'type' => 'NUMERIC'
          )
  	 ));
  }elseif('2' == $filter_value ){

  	 $wpquery->set('meta_query',array(
          array( 
              
              'key' => 'wordn',
              'value' => array(200,400),
              'compare' => 'BETWEEN',
              'type' => 'NUMERIC'
          )
  	 ));
  	 
  }elseif('3' == $filter_value ){

  	 $wpquery->set('meta_query',array(
          array( 
              
              'key' => 'wordn',
              'value' => 200,
              'compare' => '<=',
              'type' => 'NUMERIC'
          )
  	 ));
  	 
  }

}
add_action("pre_get_posts","columnd_wc_filter_data");

