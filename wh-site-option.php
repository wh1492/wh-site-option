<?php
/*
Plugin Name: WH Custom Site Options
Plugin URI: http://acbn.com
Description: Simple plugin to create a customized options in Multisite.
Version: 1.0
Author: Leonelo Acaban
Author URI: http://acbn.com
License: GNU GENERAL PUBLIC LICENSE
*/

// defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

 // Exit if accessed directly
 if( !defined( 'ABSPATH' ) ) exit;

require 'includes/base-functions.php';

$id_now = get_current_blog_id();
$mysite = now_site();
$upDir =  wp_upload_dir() ; 
//

// WP-COLOR-PICKER scripts for alpha colorpicker
wp_enqueue_style( 'wp-color-picker' );
wp_enqueue_script( 'wp-color-picker-alpha', plugin_dir_url(__FILE__) . '/js/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), $current_version, $in_footer );

/* Add Custom Admin Menu */
add_action( 'admin_menu', 'custom_wh_menu' );
add_action( 'admin_init', 'register_wh_settings');


function register_wh_settings() {
    // Register Branding Color
    register_setting( 'bColor-group', 'brand-color' );

	// Register Copyright Text for the footer
    register_setting( 'wh-footer_copy', 'wh_footer_copy' );
};

function custom_wh_menu() {
    add_options_page( 'Ajustes de Branding', 'WH Customs', 'manage_options', 'wh-custom-options', 'wh_custom_options' );
}

function wh_custom_options() {
    if ( !current_user_can( 'manage_options' ) )  :
        wp_die( 'You do not have sufficient permissions to access this page.' );
    endif;
    ?>
    	<div class="wrap">
            <?php screen_icon(); ?>
			<h1>Ajustes de Branding</h1>
			<form method="post" action="options.php">
				<?php 
				settings_fields( 'wh-footer_copy' );
				do_settings_fields( 'wh-footer_copy', '' );
				?>
				<table class="form-table">
					<tr>
						<th>
							<p>Footer Copyrigth</p>
						</th>
						<td>
							<textarea style="width: 100%;" rows="6" name="wh_footer_copy"><?php echo get_option('wh_footer_copy'); ?></textarea>
						</td>
					</tr>
					<tr>
						<th>
                        <p>Select Branding Color</p>
	                    </th>
	                    <td>
	                        <?php 
	                            settings_fields( 'bColor-group' ); 
	                            do_settings_fields( 'bColor-group', '' );
	                        ?>        
	                        <div class="customize-control-content">
	                            <input type="text" class="color-picker" data-alpha="true" maxlength="30" name="brand-color" value="<?php echo get_option('brand-color');?>" >
	                        </div>
	                    </td>
					</tr>
				</table>
			<?php submit_button(); ?>
			</form>
		</div>
    <?php 
}

$url = get_stylesheet_directory() .'/styles/' . $mysite ;

// If tmpl path dosen't exist it creates the folder
if ( !file_exists( $url ) ) {
	wp_mkdir_p($url);	
} 

// copy CSS-VARIABLE
copy(plugin_dir_url(__FILE__) . 'css/sample-css.css', $url . '/'. $mysite .'-styles.css');

// Edit CSS 
$oldMessage = "#E5330D";
$deletedFormat = get_option('brand-color');
//read the entire string
$str_replace=file_get_contents($url . '/'. $mysite .'-styles.css');


//replace something in the file string - this is a VERY simple example
$str_replace=str_replace("$oldMessage", "$deletedFormat",$str_replace);

//write the entire string
file_put_contents($url . '/'. $mysite .'-styles.css', $str_replace);
