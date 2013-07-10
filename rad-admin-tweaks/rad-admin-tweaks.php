<?php /*
Plugin Name: Admin Panel Tweaks
Description:  Makes the admin panel and login screens better
Author: Melissa Cabral
Version: 0.1
*/

/**
 * Style the login and register screens
 * @since 0.1
 */
add_action( 'login_head', 'rad_login_style' );
function rad_login_style(){ ?>
	<style>
	.login h1 a{
	background-image: url(<?php echo plugins_url( 'images/logo.png', __FILE__ ); ?>);
	background-size:auto;
	}
	body.login{
		background-color:#BFE3EE;
	}
	</style>
<?php
}
/**
 * change behavior or login logo link and title
 * @since 0.1
 */
add_filter( 'login_headerurl', 'rad_login_link' );
function rad_login_link(){
	return home_url();
}
add_filter( 'login_headertitle', 'rad_login_title' );
function rad_login_title(){
	return 'The most awesome site ever';
}

/**
 * replace the "howdy, User" with "Ahoy Hoy, user"
 * @since 0.1
 */
add_filter( 'gettext', 'md_replace_howdy' );
function md_replace_howdy( $text ) {
	$text = str_replace( 'Howdy', 'Ahoy Hoy', $text );
	return $text;
}

/**
 * Change the admin bar logo
 * @since 0.1
 */
add_action( 'admin_head', 'rad_admin_bar_logo');
add_action( 'wp_head', 'rad_admin_bar_logo');
function rad_admin_bar_logo(){
	if( is_admin_bar_showing() ): 
		$image = plugins_url('images/admin-logo.png', __FILE__); ?>
		<style>
		#wp-admin-bar-wp-logo>.ab-item .ab-icon{
			background-image: url( <?php echo $image; ?> ) !important ;
			background-position: 0 0 !important;
		}
		</style>
	<?php 
	endif;
}
/**
 * Remove dashboard widgets
 * @since 0.1
 */
add_action('wp_dashboard_setup', 'rad_remove_dashboard_widgets');
function rad_remove_dashboard_widgets(){
	remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' );
}

/**
 * add our own dashboard widget
 */
function rad_dashboard_widget(){
	//handle, title, callback function
	wp_add_dashboard_widget( 'rad_dashboard_help', 'Contact Us For Help!', 'rad_dashboard_build_widget' );	

	//PUSH YOUR WIDGET TO THE TOP OF THE PAGE
	// Globalize the metaboxes array, this holds all the widgets for wp-admin
	global $wp_meta_boxes;	

	// Get the regular dashboard widgets array 
	// (which has our new widget already but at the end)
	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];	

	// Backup and delete our new dashboard widget from the end of the array
	$rad_dashboard_backup = array('rad_dashboard_help' => $normal_dashboard['rad_dashboard_help']);
	unset($normal_dashboard['rad_dashboard_help']);

	// Merge the two arrays together so our widget is at the beginning
	$sorted_dashboard = array_merge($rad_dashboard_backup, $normal_dashboard);

	// Save the sorted array back into the original metaboxes 
	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;

}
//this is the actual content of our custom widget. a good place for client help, contact info, etc. 
function rad_dashboard_build_widget(){
	echo 'This is the widget meat. put any HTML or include a file in here';	
}
add_action('wp_dashboard_setup', 'rad_dashboard_widget');



