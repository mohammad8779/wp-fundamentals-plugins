<?php

function csd_sample_demo($metaboxes){
   $metaboxes[] = array(
      
      'id' => 'csd-bood-inf0',
      'title' => __("Book Info","codestar-demo"),
      'post_type' => array('book'),
      'context' => 'normal',
      'priority' => 'default',
      'sections' => array( 
          array(
              
              'name' => 'csd-bookinfo-section',
              'icon' => 'fa fa-image',
              'fields' => array(
                  
                  array(
                     'id' => 'author',
                     'title' => __("Book Author","codestar-demo"),
                     'type' => 'text',
                  ),

                   array(
                     'id' => 'year',
                     'title' => __("Year","codestar-demo"),
                     'type' => 'text'
                  ),

                   array(
                     'id' => 'isb',
                     'title' => __("Book ISB","codestar-demo"),
                     'type' => 'text'
                  )
             
              )

          )

      )
  );
  return $metaboxes;
}

add_filter("cs_metabox_options","csd_sample_demo");