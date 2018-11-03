<?php

class DemoWidget extends WP_Widget {
	 public function __construct(){
	 	parent::__construct(
            
            'demowidget',
            __("Demo Widget","demo_widgets"),
            array( 'description' => __("Our Demo Widget Description","demo_widgets") )
        );
	 }

	 public function form($instance){
       $title = isset($instance['title'])? $instance['title']: __("Demo Widget","demo_widgets");
       $latitude = isset($instance['latitude'])? $instance['latitude']: 23.9;
       $longitude = isset($instance['longitude'])? $instance['longitude']: 90.8;
       $email = isset($instance['email'])? $instance['email']: "jon&doe@gmail.com";
       ?>
         <p>
         	<label for="<?php echo esc_attr($this->get_field_id('title'));?>"><?php _e("Title","demo_widgets");?></label>

         	<input type="text" class="widefat" name="<?php echo esc_attr($this->get_field_name('title'));?>" id="<?php echo esc_attr($this->get_field_id('title'));?>" value="<?php echo esc_attr($title);?>">
         </p>

         <p>
         	<label for="<?php echo esc_attr($this->get_field_id('latitude'));?>"><?php _e("Title","demo_widgets");?></label>

         	<input type="number" class="widefat" name="<?php echo esc_attr($this->get_field_name('latitude'));?>" id="<?php echo esc_attr($this->get_field_id('latitude'));?>" value="<?php echo esc_attr($latitude);?>">
         </p>

          <p>
         	<label for="<?php echo esc_attr($this->get_field_id('longitude'));?>"><?php _e("Title","demo_widgets");?></label>

         	<input type="number" class="widefat" name="<?php echo esc_attr($this->get_field_name('longitude'));?>" id="<?php echo esc_attr($this->get_field_id('longitude'));?>" value="<?php echo esc_attr($longitude);?>">
         </p>

         <p>
         	<label for="<?php echo esc_attr($this->get_field_id('email'));?>"><?php _e("Email","demo_widgets");?></label>

         	<input type="email" class="widefat" name="<?php echo esc_attr($this->get_field_name('email'));?>" id="<?php echo esc_attr($this->get_field_id('email'));?>" value="<?php echo esc_attr($email);?>">
         </p>


       <?php
	 }

	public function widget($args, $instance){
       
       $args['before_widget'];
         if(isset($instance['title']) && $instance['title'] != ''){
         	echo $args['before_title'];
         	  echo apply_filters('widget_title',$instance['title']);
         	echo $args['before_title'];
         }
       $args['after_widget'];

       ?>
          <div class="demowidget">
          	  <p>Latitude:<?php echo isset($instance['latitude'])? $instance['latitude']:"N/A"?></p>
          	   <p>Longitude:<?php echo isset($instance['longitude'])? $instance['longitude']:"N/A"?></p>
          </div>
       <?php
	}

	public function update($newinstance,$oldinstance){
         /*
         $email = $newinstance['email'];
         if(is_email($email)){
         	return $newinstance;
         }
           return $oldinstance;
         */
         $instance = $newinstance;
         $instance['title'] = sanitize_text_field($instance['title']);
         $email = $newinstance['email'];
         if(!is_email($email)){
         	return $instance['email'] = $oldinstance;
         }
         if(!is_numeric($newinstance['latitude'])){
             $instance['latitude'] = $oldinstance['latitude'];
         }
         if(!is_numeric($newinstance['longitude'])){
             $instance['longitude'] = $oldinstance['longitude'];
         }
           return $instance;

	}
}