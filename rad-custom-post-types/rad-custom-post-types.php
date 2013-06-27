<?php 
/*
Plugin Name: Custom Post Types - Products
Description: Adds the CPT stuff for our products catalog
Author: Melissa Cabral
Version: 0.1
*/

/**
 * Set up the post type in the admin panel
 * @since 0.1
 */
add_action( 'init', 'mmc_register_post_type' );
function mmc_register_post_type(){
	register_post_type( 'product', array(
		'has_archive' => true,
		'public' => true,
		'description' => 'These are products for the catalog',
		'rewrite' => array( 'slug' => 'shop' ),
		'labels' => array(
			'name' => 'Products',
			'singular_name' => 'Product',
			'add_new_item' => 'Add New Product',
			'edit_item' => 'Edit Product',
		),
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 
			'custom-fields', 'revisions' ),
	) );
}

/**
 * Flush Rewrite Rules - Fix 404 errors when the plugin activates
 * @since 0.1
 */
function mmc_flush(){
	mmc_register_post_type();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'mmc_flush' );