<?php
/**
 * Cordelo client.
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package cordelo
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'cordelo', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'cordelo' ) );

//* Add Image upload and Color select to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Include Customizer CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Cordelo master' );
define( 'CHILD_THEME_URL', 'https://cordelo.com/' );
define( 'CHILD_THEME_VERSION', '2.0.0' );

//* Enqueue Scripts and Styles
add_action( 'wp_enqueue_scripts', 'cordelo_enqueue_scripts_styles' );
function cordelo_enqueue_scripts_styles() {

	wp_enqueue_style( 'genesis-fonts', '//fonts.googleapis.com/css?family=Abel|Quicksand', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	wp_enqueue_script( 'cordelo-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );
	$output = array(
		'mainMenu' => __( 'Menu', 'cordelo' ),
		'subMenu'  => __( 'Menu', 'cordelo' ),
	);
	wp_localize_script( 'cordelo-responsive-menu', 'genesisSampleL10n', $output );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 600,
	'height'          => 160,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Add Image Sizes
add_image_size( 'featured-image', 720, 400, TRUE );

//* Rename primary and secondary navigation menus
add_theme_support( 'genesis-menus' , array( 'primary' => __( 'After Header Menu', 'cordelo' ), 'secondary' => __( 'Footer Menu', 'cordelo' ) ) );

// Removes secondary sidebar
//unregister_sidebar( 'sidebar-alt' );

// Removes site layouts
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'cordelo_secondary_menu_args' );
function cordelo_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

//* Modify size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'cordelo_author_box_gravatar' );
function cordelo_author_box_gravatar( $size ) {

	return 90;

}

//* Modify size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'cordelo_comments_gravatar' );
function cordelo_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;

}
//* Register new widget

genesis_register_sidebar( array(
    'id' => 'after-header',
    'name' => __( 'After Header', 'cordelo' ),
    'description' => __( 'This is the after header before content section.', 'cordelo' ),

) );

/** Add the home featured section */

add_action( 'genesis_after_header', 'kimi_after_header' );

function kimi_after_header() {

	if (is_active_sidebar( 'after-header' )) {

		genesis_widget_area( 'after-header', array(

 			'before' => '<div class="after-header widget-area"><div class="wrap"',

			'after' => '</div></div>'

			) );

	}

}

// full width layout for "corproducts"
//add_filter( 'genesis_site_layout', 'cordelo_cpt_layout' );
// force a layout
function cordelo_cpt_layout() {
    if( 'corproducts' == get_post_type() ) {
        return 'full-width-content';
    }
}

// remove admin tool bar for all users, not admins
add_action( 'after_setup_theme', 'remove_admin_bar' );

function remove_admin_bar() {
    if ( !current_user_can('administrator' ) && !is_admin() ) {
        show_admin_bar( false );
    }
}

//* Using the Gravity Forms editor, be sure to check "Allow field to be populated dynamically under Advanced Options
//* You will need to set the Field Parameter Name value to work with the filter as follows: gform_field_value_$parameter_name

//* Dynamically populate first name for logged in users
add_filter('gform_field_value_first_name', 'populate_first_name');
function populate_first_name($value){
	global $current_user;
	get_currentuserinfo();
	return $current_user->user_firstname;
}

//* Dynamically populate last name for logged in users
add_filter('gform_field_value_last_name', 'populate_last_name');
function populate_last_name($value){
	global $current_user;
	get_currentuserinfo();
	return $current_user->user_lastname;
}

//* Dynamically populate email for logged in users
add_filter('gform_field_value_email', 'populate_email');
function populate_email($value){
	global $current_user;
	get_currentuserinfo();
	return $current_user->user_email;
}

//* This method can also be used for custom user fields, e.g...
//* Dynamically populate phone for logged in users
add_filter('gform_field_value_phone', 'populate_phone');
function populate_phone($value){
	global $current_user;
	get_currentuserinfo();
	return $current_user->phone;
}

// thumbnails in the admin list over posts
add_image_size( 'crunchify-admin-post-featured-image', 100, 100, false );
 
// Add the posts and pages columns filter. They can both use the same function.
add_filter('manage_posts_columns', 'crunchify_add_post_admin_thumbnail_column', 2);
add_filter('manage_pages_columns', 'crunchify_add_post_admin_thumbnail_column', 2);
 
// Add the column
function crunchify_add_post_admin_thumbnail_column($crunchify_columns){
	$crunchify_columns['crunchify_thumb'] = __('Featured Image');
	return $crunchify_columns;
}
 
// Let's manage Post and Page Admin Panel Columns
add_action('manage_posts_custom_column', 'crunchify_show_post_thumbnail_column', 5, 2);
add_action('manage_pages_custom_column', 'crunchify_show_post_thumbnail_column', 5, 2);
 
// Here we are grabbing featured-thumbnail size post thumbnail and displaying it
function crunchify_show_post_thumbnail_column($crunchify_columns, $crunchify_id){
	switch($crunchify_columns){
		case 'crunchify_thumb':
		if( function_exists('the_post_thumbnail') )
			echo the_post_thumbnail( 'crunchify-admin-post-featured-image' );
		else
			echo 'hmm... your theme doesn\'t support featured image...';
		break;
	}
}

// add thumbnails in blog
add_theme_support( 'post-thumbnails' );

// Add theme widget area
include_once( get_stylesheet_directory() . '/includes/widget-areas.php' );

// Customize the post header
//add_filter('genesis_post_info', 'wpt_info_filter');
//function wpt_info_filter($post_info) {
//    if (!is_page()) {
//        $post_info = 'Written by [post_author_posts_link] [post_edit]';
//    }
//    return $post_info;
//}

// Remove the post info function
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

//* Display author box on archive pages
//add_filter( 'get_the_author_genesis_author_box_archive', '__return_true' );

// append shortcode after content
//function wpsnipp_append_shortcode_to_content( $content ) {
//      if( ! is_single() ) {
//        if (in_category('corproducts')) {
//          $content .= do_shortcode( '[adds]' );
//        }
//      }
//      return $content;
//  }
//add_filter('genesis_after_content', 'wpsnipp_append_shortcode_to_content');

//add_action( 'genesis_before_entry_content', 'custom_featured_image' );
///**
// * Show featured image (if present) before content on single posts.
// */
//function custom_featured_image() {
//    // if there is no featured image, abort.
//    if ( ! has_post_thumbnail() ) {
//        return;
//    }
//
//    printf( '<figure><img src="%s" alt="%s" /></figure>', genesis_get_image( 'format=url&size=medium_large' ), the_title_attribute( 'echo=0' ) );
//}

