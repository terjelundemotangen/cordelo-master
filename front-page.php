<?php

/**
* Front page template
*
* @package		cordelo
* @author		Terje Lundemo Tangen
* @link			http://cordelo.com
* @copyright	Copyright (c) 2018, Terje Lundemo Tangen
* @license		GPL-2.0+
*/

add_action( 'genesis_meta', 'cordelo_home_page_setup' );

function cordelo_home_page_setup() {
	$home_sidebars = array(
		'home_welcome'	=> is_active_sidebar( 'home-welcome' ),
	);
	
	// Return early if no sidebars are active
	if ( ! in_array( true, $home_sidebars ) ) {
		return;
	}
	
	// Add home welcome area if "Home Welcome" widget ares is active
	if ( $home_sidebars['home_welcome'] ) {
		add_action( 'genesis_after_header', 'cordelo_add_home_welcome' );
	}
}

/**
* Display content for the "Home Welcome" section
*
* @since 1.0.0
*/

function cordelo_add_home_welcome() {
	genesis_widget_area( 'home-welcome',
		array(
			'before' => '<div class="home-welcome"><div class="wrap">',
			'after' => '</div></div>',
		)
	);
}

genesis();