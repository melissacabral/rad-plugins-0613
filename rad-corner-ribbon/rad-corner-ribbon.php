<?php 
/* 
Plugin Name: Corner Ribbon - Subscribe to RSS Feed
Description: Adds an eye-catching ribbon to the top right corner of the page
Plugin URI: http://wordpress.melissacabral.com
Author: Melissa Cabral
Version: 0.1
License: GPLv3 or higher
*/


/**
 * Generate HTML output at the bottom of every page
 * @since ver 0.1
 */
add_action( 'wp_footer', 'rad_ribbon_html' );

function rad_ribbon_html(){
	//get the location of the image. __FILE__ is the location of THIS file. 
	$image_path = plugins_url( 'images/corner-ribbon.png', __FILE__ );
	?>
	<!-- Begin Rad Corner Ribbon Output-->
	<a href="<?php bloginfo('rss2_url'); ?>" id="rad-corner-ribbon">
		<img src="<?php echo $image_path; ?>" alt="Subscribe to RSS Feed" />
	</a>
	<!-- End Rad Corner Ribbon Output-->
	<?php	
}


/**
 * Add the stylesheet properly
 * @since ver 0.1
 */
add_action( 'wp_enqueue_scripts', 'rad_ribbon_style' );
function rad_ribbon_style(){
	//get the path to the stylesheet
	$style_path = plugins_url( 'css/style.css', __FILE__ );
	//tell WP that the stylesheet exists
	wp_register_style( 'rad-ribbon-css', $style_path );
	//tell WP to put the stylesheet in the right place
	wp_enqueue_style( 'rad-ribbon-css' );
}


