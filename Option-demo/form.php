<h1>Our Plugin Admin Page</h1>
<form method="post" action="<?php echo admin_url("admin-post.php");?>">

    <?php
        wp_nonce_field("optiondemo");
        $optiondemo_longitude2 = get_option("optiondemo_longitude2")
     ?>
    <label for="longitude2"><?php _e("Longitude","optiondemo");?></label>
    <input type="text" id="longitude2" name="optiondemo_longitude2" value="<?php echo esc_attr($optiondemo_longitude2);?>">
    <input type="hidden" name="action" value="optiondemo_admin_page">
    <?php
     submit_button('Save');
    ?>
  
</form>
