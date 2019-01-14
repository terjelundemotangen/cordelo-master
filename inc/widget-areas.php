<?php

/**
* Register Widget Areas
*
* @package		cordelo-client
* @author		Terje Lundemo Tangen
* @link			http://cordelo.com/
* @copyright	Copyright (c) 2018, Terje Lundemo Tangen
* @license		GPL-2.0+
*/

//* Register front page widget area
genesis_register_sidebar( array(
	'id'            => 'home-welcome',
	'name'          => __( 'Home Welcome', 'cordelo' ),
	'description'   => __( 'This is a home widget area that will show on the front page.', 'cordelo' ),
) );