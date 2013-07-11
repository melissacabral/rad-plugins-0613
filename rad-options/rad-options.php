<?php /*
Plugin Name: Company Info Options Page 
Description: Adds an options page under "settings"
Author: Melissa Cabral
Version: 0.1
*/

/**
 * Add a section to the admin under "settings"
 * @since 0.1
 */
add_action( 'admin_menu', 'rad_settings_page' );
function rad_settings_page(){
	add_options_page( 'Company Information', 'Company Info', 'manage_options', 'rad-company-info', 'rad_options_build_form' );
}

/**
 * Register the settings group so they are allowed in the DB
 * @since 0.1
 */
add_action( 'admin_init', 'rad_register_setting' );
function rad_register_setting(){
	//group name, DB row name, sanitizing callback
	register_setting( 'rad_options_group', 'rad_options', 'rad_options_sanitize' );
}

/**
 * callback function for the form 
 */
function rad_options_build_form(){
	//check capability for security purposes
	if( ! current_user_can( 'manage_options' ) ):
		wp_die( 'Access denied' );
	else:
		//include the external form file
		require_once( plugin_dir_path( __FILE__ ) . 'rad-options-form.php' );
	endif;
}

/**
 * sanitizing callback
 * @todo make this actually sanitize
 */
function rad_options_sanitize($input){
	//go through each field, clean up the data!
	$input['phone'] = wp_filter_nohtml_kses( $input['phone'] );
	$input['email'] = wp_filter_nohtml_kses( $input['email'] );

	//allowed HTML
	$allowed_tags = array(
		'p' => array( 'class' => array() ),
		'br' => array(),
		'a' =>	array( 'href' => array() ),
		);

	$input['address'] = wp_kses( $input['address'] , $allowed_tags );

	//done!  send all cleaned data back to WP so it can put it in the DB
	return $input;
}