<?php
/*
 * Plugin Name: Replace Old and Broken Images/Links
 * Plugin URI: http://ckmacleod.com/roi-wp-plugin/
 * Description: DISCONTINUED, Replaced by WP Replace Unlicensed and Broken Images
 * Version: 1.1
 * Author: CK MacLeod
 * Date: July 19, 2016
 * Author URI: http://ckmacleod.com/
 * Plugin URI: http://www.ckmacleod.com/plugins/replace-old-images/
 * License: GPLv2
*/

/*
 * Set Default Options on Registration
 * @Cut-Off Date: A date entered in acceptable (human-readable, PHP), after which images will not be replaced.
 * @Image Url: The full URL where the image that will appear in the place of the old or missing image
 * @First String Match: Any initial part (by default the site's host name) of a typical to be replaced image's URL
 * @Second String Match: Any secondary part (by default the typical WordPress image folder name "uploads"
 * @Version: Beginning 1.1
 * @Discontinued: Try WP Replace Unlicensed and Broken Images for more options and continued support [WP Replace Unlicensed and Broken Images](https://wordpress.org/plugins/wp-replace-unlicensed-and-broken-images/)
 * 
 */   

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

register_activation_hook( __FILE__,'roi_set_default_options');

function roi_set_default_options() {
    
    $roi_default_options = array(
            'roi_cut_off_date' => '1 January 1970',
            'roi_image_url' => plugins_url( 'image_removed.png', __FILE__ ),
            'roi_match_1' => $_SERVER['HTTP_HOST'],
            'roi_match_2' => 'uploads',
            'roi_version' => '1.0'
    );
    
        update_option('roi_options', $roi_default_options);
}

/* 
 * Create custom plugin settings menu
 * 
 */
add_action( 'admin_menu', 'roi_create_menu' );

function roi_create_menu() {

    //create new settings page menu
    add_options_page( 'Replace Old Images Page', 'Replace Old Images', 'manage_options', 'roi_main_menu', 'roi_settings_page' );

    //call register settings function
    add_action( 'admin_init', 'roi_register_settings' );
    
}

function roi_register_settings() {

    //register our settings
    register_setting( 'roi-settings-group', 'roi_options', 'roi_sanitize_options' );

}

function roi_settings_page() {
    
    ?>
    
    <div class="wrap">

        <h2>Replace Old Images</h2>

        <p >All displayed images (&lt;img src=...) and image anchor links (&lt;a href=...) with extensions ".gif," ".jpg," ".jpeg," or ".png", in (1) posts up to or on the Cut-Off Date, which also, (2a) and (2b) contain the specified strings of characters, will be replaced in post content by (3) the image or link supplied by URL and shown below.</p> <p>If dimensions are hard-coded in the original image display code, the replacement image will take on those dimensions.</p><p>Remember to Save Changes!</p>

        <form method="post" action="options.php">

		<?php settings_fields( 'roi-settings-group' ); ?>
            
		<?php $roi_options = get_option( 'roi_options' ); ?>
            
		<table class="form-table">
            
<!--            check functions if any of "name"-->
            <tr valign="top">
                <th scope="row">1. Cut-Off Date  </th>
            
                <td><input type="text" name="roi_options[roi_cut_off_date]" value="<?php echo esc_attr($roi_options['roi_cut_off_date']); ?>" /><p class="description">Any readable full date format... </p></td>
            
            </tr>
            
            <tr valign="top">
            
                <th scope="row">2a. First String Match</th>

                <td><input type="text" name="roi_options[roi_match_1]" value="<?php echo esc_attr($roi_options['roi_match_1']); ?>" /><p class="description">Default: Host Name</p></td>

            </tr>

            <tr valign="top">

                <th scope="row">2b. Second String Match</th>

                <td><input type="text" name="roi_options[roi_match_2]" value="<?php echo esc_attr($roi_options['roi_match_2']); ?>" /><p class="description">Default: Uploads Directory</p></td>

            </tr>        

            <tr valign="top">

                <th scope="row">3. URL to "Image Removed" Image</th>

                <td><input type="text" size="75" name="roi_options[roi_image_url]" value="<?php echo esc_attr($roi_options['roi_image_url']); ?>" />
                    
                    <p class="description">Use full URL (http://... etc.) </p>
                    
                    <h3>Currently In Use: </h3>

                    <img src="<?php echo esc_attr($roi_options['roi_image_url']); ?>"></td>
            
            </tr>
            
        </table>

		<p class="submit">
	
                    <input type="submit" class="button-primary" value="Save Changes" />
		
                </p>

	</form>
	
    </div> <!--Settings Page HTML "wrap" -->

    <?php

}

/*
 * SANITIZE USER-SUPPLIED OPTIONS BEFORE ADDITING TO DATABASE
 */

function roi_sanitize_options( $input ) {

    $input['roi_cut_off_date']  = sanitize_text_field($input['roi_cut_off_date']);
    $input['roi_image_url']     = esc_url($input['roi_image_url']);
    $input['roi_match_1']       = sanitize_text_field($input['roi_match_1']);
    $input['roi_match_2']       = sanitize_text_field($input['roi_match_2']);
    return $input;

}

/*
 * Filter WordPress post content at posting time
 */
add_filter('the_content', 'replace_old_images');

/*
 * Replace All Old Images according to default or user set options
 * 
 */
function replace_old_images($content) {

    $roi_options_arr = get_option('roi_options');
   
    if (!$roi_options_arr) {
        
        return $content;
        
    }
    
    //assemble main variables using options
    global $post;

    $cut_off_date = strtotime($roi_options_arr['roi_cut_off_date']);
        
    $post_date = strtotime($post->post_date);
    
    //ignore if post later than cut_off_date
    if ($post_date > $cut_off_date) {
        
        return $content;
        
    } else { //have options, post prior to Cut-Off Date
        
        $static_image_url = $roi_options_arr['roi_image_url'];
        
        $url_match_string_host = $roi_options_arr['roi_match_1'];
        
        $url_match_string_dir = $roi_options_arr['roi_match_2'];
        
        $content = preg_replace('/https?:\/\/\S?' . $url_match_string_host . '\S+' . $url_match_string_dir . '[^ ]+?(?:\.jpg|\.jpeg|\.png|\.gif)/', $static_image_url, $content);
        
        return $content;
    }
}
//END OF Replace Old Images