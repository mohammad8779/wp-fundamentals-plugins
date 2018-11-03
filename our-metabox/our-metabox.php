<?php 
/********
Plugin Name: Our Metabox
Plugin URI: https://services.matalukder.com
Description: This is a metabox practice plugin that will be include for any place.
Version: 0.1.0
Author: matalukder
Author URI: http://mataulder.com
Text Domain: our-metabox
Domain Path: /languages

********/

class OurMetabox{

  

  function __construct(){
  	 
  	 add_action("plugins_loaded", array($this, "omb_load_textdomain"));
  	 add_action("admin_menu",array($this,"omb_add_metabox"));
  	 add_action("save_post",array($this,"omb_save_location"));
  	 add_action("save_post",array($this,"omb_save_image"));
  	 add_action("save_post",array($this,"omb_save_gallery"));
  	 add_action("admin_enqueue_scripts",array($this,"omb_assets"));
  	 add_filter("user_contactmethods", array($this,"omb_user_contact_method"));
  }

  function omb_user_contact_method($methods){
     
     $methods['facebook'] = __("Facebook","our-metabox");
     $methods['twitter'] = __("Twitter","our-metabox");
     $methods['linkedin'] = __("Linkedin","our-metabox");

     return $methods;
  }
  
  function omb_assets(){
  	 wp_enqueue_style("omb-admin-style", plugin_dir_url(__FILE__)."assets/admin/css/admin.css",null,time());
  	 wp_enqueue_script("omb-admin-js",plugin_dir_url(__FILE__)."assets/admin/js/main.js", array("jquery","jquery-ui-datepicker"),time(),true);
  	 wp_enqueue_style("jquery-ui-css","//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css");
  }
  function omb_load_textdomain(){
     load_plugin_textdomain("our-metabox",false,plugin_dir_url(__FILE__)."/languages" );
  }

  private function is_secured($nonce_field,$action,$post_id){

  		$nonce = isset($_POST[$nonce_field])?$_POST[$nonce_field]:'';

	  	 if($nonce == ''){
	        return false;
	  	 }

	  	 if(!wp_verify_nonce($nonce, $action)){
	       return false;
	  	 }

	  	 if(!current_user_can('edit_post',$post_id)){
	        return false;
	  	 }

	  	 if(wp_is_post_autosave($post_id)){
	  	 	 return false;
	  	 }

	  	 if(wp_is_post_revision($post_id)){
	  	 	 return false;
	  	 }

	  	 return true;


  }

  function omb_save_location($post_id){
  	 
  	 if(!$this->is_secured('omb_location_field','omb_location',$post_id)){
  	 	return $post_id;
  	 };

  	 $location = isset($_POST['omb_location'])?$_POST['omb_location']:'';
  	 $country = isset($_POST['omb_country'])?$_POST['omb_country']:'';
  	 $is_favorite = isset($_POST['omb_is_favorite'])?$_POST['omb_is_favorite']:'';
  	 $colors = isset($_POST['omb_clr'])?$_POST['omb_clr']:array();
  	 $colors2 = isset($_POST['omb_color'])?$_POST['omb_color']:" ";
  	 $fav_color = isset($_POST['omb_fav_color'])?$_POST['omb_fav_color']:" ";



     //if($location == '' || $country == ''){
     	//return $post_id;
     //}
     //$location = sanitize_text_field($location);
     //$country = sanitize_text_field($country);
     //add_post_meta($post_id,'omb_location',$location);
     update_post_meta($post_id,'omb_location',$location);
     update_post_meta($post_id,'omb_country',$country);
     update_post_meta($post_id,'omb_is_favorite',$is_favorite);
     update_post_meta($post_id,'omb_clr',$colors);
     update_post_meta($post_id,'omb_color',$colors2);
     update_post_meta($post_id,'omb_fav_color',$fav_color);
  }

  function omb_add_metabox(){
  	add_meta_box(
       'omb_post_metabox',
       __('Location Info','our-metabox'),
       array($this,'omb_display_post_location'),
       array('post','page')
  	);
    
    //just for styling
  	add_meta_box(
       'omb_book_info',
       __('Book Info','our-metabox'),
       array($this,'omb_display_book'),
       array('book')
  	);

  	//just for image media
  	add_meta_box(
       'omb_image_info',
       __('Image Info','our-metabox'),
       array($this,'omb_display_image_media'),
       array('post')
  	);

  	//just for multiple image media
  	add_meta_box(
       'omb_gallery_info',
       __('Gallery Info','our-metabox'),
       array($this,'omb_display_gallery'),
       array('post')
  	);
 }
 
 //just for multiple image media
 function omb_save_gallery($post_id){

  	if(!$this->is_secured('omb_images_nonce','omb_images',$post_id)){
  	 	return $post_id;
  	 };

  	 $images_id = isset($_POST['omb_images_id'])?$_POST['omb_images_id']:'';
  	 $images_url = isset($_POST['omb_images_url'])?$_POST['omb_images_url']:'';

  	 update_post_meta($post_id,'omb_images_id',$images_id);
  	 update_post_meta($post_id,'omb_images_url',$images_url);

  }

 function omb_display_gallery( $post ){
  	$images_id = esc_attr(get_post_meta($post->ID,'omb_images_id',true));
  	$images_url = esc_attr(get_post_meta($post->ID,'omb_images_url',true));
  	wp_nonce_field("omb_images","omb_images_nonce");

  	$metabox_image=<<<EOD
   <div class="fields">
     <div class="fields-container">
           <div class="label-c">
              <label for="upload_images"> Upload Gallery: </label>
           </div>
           <div class="input-c">
               <button class="button" id="upload_images">Upload Images</button>
               <input type="hidden" name="omb_images_id" id="omb_images_id" value="{$images_id}"/>
                <input type="hidden" name="omb_images_url" id="omb_images_url" value="{$images_url}"/>
                <div style="width:100%;height:auto; padding:10px 0" id="images-container"></div>
           </div>
           <div class="float-c"></div>
      </div>

    </div>

EOD;
    echo $metabox_image;
  }

  //just for image media

  function omb_save_image($post_id){

  	if(!$this->is_secured('omb_image_nonce','omb_image',$post_id)){
  	 	return $post_id;
  	 };

  	 $image_id = isset($_POST['omb_image_id'])?$_POST['omb_image_id']:'';
  	 $image_url = isset($_POST['omb_image_url'])?$_POST['omb_image_url']:'';

  	 update_post_meta($post_id,'omb_image_id',$image_id);
  	 update_post_meta($post_id,'omb_image_url',$image_url);

  }

  function omb_display_image_media( $post ){
  	$image_id = esc_attr(get_post_meta($post->ID,'omb_image_id',true));
  	$image_url = esc_attr(get_post_meta($post->ID,'omb_image_url',true));
  	wp_nonce_field("omb_image","omb_image_nonce");

  	$metabox_image=<<<EOD
   <div class="fields">
     <div class="fields-container">
           <div class="label-c">
              <label for="image-button"> Image: </label>
           </div>
           <div class="input-c">
               <button class="button" id="upload_image">Upload Image</button>
               <input type="hidden" name="omb_image_id" id="omb_image_id" value="{$image_id}"/>
                <input type="hidden" name="omb_image_url" id="omb_image_url" value="{$image_url}"/>
                <div style="width:100%;height:auto; padding:10px 0" id="image-container"></div>
           </div>
           <div class="float-c"></div>
      </div>

    </div>

EOD;
    echo $metabox_image;
  }
  //just for styling
  function omb_display_book(){
  	wp_nonce_field("omb_book","omb_book_nonce");

  	$metabox_form =<<<EOD
<div class="fields">

       <div class="fields-container">
           <div class="label-c">
              <label for="book-author"> Book Author </label>
           </div>
           <div class="input-c">
               <input type="text" class="widefat" id="book-author"/>
           </div>
           <div class="float-c"></div>
       </div>

       <div class="fields-container">
           <div class="label-c">
              <label for="book-isbn"> Book ISBN </label>
           </div>
           <div class="input-c">
               <input type="text" class="widefat" id="book-isbn"/>
           </div>
           <div class="float-c"></div>
       </div>

        <div class="fields-container">
           <div class="label-c">
              <label for="p-year"> Publish Year </label>
           </div>
           <div class="input-c">
               <input type="text" class="omb-dp" id="p-year"/>
           </div>
           <div class="float-c"></div>
       </div>

</div>

EOD;

 echo $metabox_form;
    

}

  function omb_display_post_location($post){
  	$location = get_post_meta($post->ID,'omb_location',true);
  	$country = get_post_meta($post->ID,'omb_country',true);
  	$is_favorite = get_post_meta($post->ID,'omb_is_favorite',true);
  	echo "Is Favorite:".$is_favorite."</br>";
  	$checked = $is_favorite == 1? "checked" : "";
    
    $saved_colors = get_post_meta($post->ID,'omb_clr',true);
    $saved_color = get_post_meta($post->ID,'omb_color',true);
    //print_r($saved_colors);

    $label = __("Location","our-metabox");
    $label2 = __("Country","our-metabox");
    $label3 = __("Is Favorite","our-metabox");
    $label4 = __("Colors","our-metabox");
    
    $colors = array("red","blue","green","pink","yellow");

    wp_nonce_field("omb_location","omb_location_field");
   	$metabox_form = <<<EOD
    <p>
      <label for="omb_location" > {$label}: </label>
      <input type="text" name="omb_location" id="omb_location" value="{$location}"/>
      </br></br>
      <label for="omb_country" > {$label2}: </label>
      <input type="text" name="omb_country" id="omb_country" value="{$country}"/>
      </br></br>
      <label for="omb_country" > {$label3}: </label>
      <input type="checkbox" name="omb_is_favorite" id="omb_is_favorite" value="1" {$checked} />
      </br></br>
    </p>

     <p>
       <label> {$label4}: </label>
EOD;
       $saved_colors = is_array($saved_colors) ? $saved_colors:array();
       foreach($colors as $color){
       	 $_color = ucwords($color);
       	 $checked = in_array($color,$saved_colors)?"checked":"";
       	 $metabox_form .= <<<EOD
         <label for="omb_clr_{$color}" > {$_color} </label>
         <input type="checkbox" name="omb_clr[]" id="omb_clr_{$color}" value="{$color}" {$checked} />
EOD;
       }
    $metabox_form .= "</p>";

    $metabox_form .=<<<EOD
   
   <p>
       <label> {$label4}: </label>

EOD;
       //$saved_color = in_array($saved_color)?$saved_color:array();
       foreach($colors as $color){
       	 $_color = ucwords($color);
       	 $checked = ($color == $saved_color)? "checked":"";
       	 $metabox_form .= <<<EOD
         <label for="omb_color_{$color}" > {$_color} </label>
         <input type="radio" name="omb_color" id="omb_color_{$color}" value="{$color}" {$checked}/>
EOD;
       }

    $metabox_form .= "</p>";
    $fav_color = get_post_meta($post->ID,"omb_fav_color",true);
    //echo $fav_color;
    $dropdown_html = "<option value='0'>". __('Select a color','our-metabox')."</option>";
  
    foreach($colors as $color){
    	$selected = '';
    	if($color == $fav_color){
    		$selected = 'selected';
    	}
    	$dropdown_html .= sprintf("<option %s value='%s'>%s</option>", $selected,$color,ucwords($color));
    }
    $metabox_form .=<<<EOD
    <p>
      <label for="omb_dropdown">{$label4}<?label>
      <select name="omb_fav_color" id="omb_dropdown">
        {$dropdown_html}
      </select>
    </p>
EOD;
    echo $metabox_form;
}

}

new OurMetabox();