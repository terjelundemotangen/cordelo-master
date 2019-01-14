<?php

/**
 * Page template.
 *
 * This file adds the Full width page template to the Trondheim tango Theme.
 *
 * Template Name: Full bredde
 *
 * @package Trondheim tangoklubb
 * @author  Terje Lundemo Tangen
 * @license GPL-2.0+
 * @link    https://trondheimtango.no/
 *
 */
 
function trondheimtango_site_inner_attr( $attributes ) {

    // Adds a class of 'full' for styling this .site-inner differently
    $attributes['class'] .= ' full';

    // Adds an id of 'genesis-content' for accessible skip links
    $attributes['id'] = 'genesis-content';

    // Adds the attributes from .entry, since this replaces the main entry
    $attributes = wp_parse_args( $attributes, genesis_attributes_entry( array() ) );

    return $attributes;
}

// Displays Header.
get_header();

genesis_do_breadcrumbs();

// Displays Content.

the_post(); // sets the 'in the loop' property to true. Needed for Beaver Builder but not Elementor.

the_title( '<h3>', '</h3>' ); // måtte ta med denne for å få tittelen

the_content();

// Displays Comments (if any are already present and if comments are enabled in Genesis settings - disabled by default for Pages).
genesis_get_comments_template();

// Displays Footer.
get_footer();
