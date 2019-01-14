<?php

//* Template Name: Archive products

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'trondheimtango_product_loop' );

function trondheimtango_product_loop() {

    global $paged;
    global $query_args;

    // Show Residents
    $args = array(
        'post_type'         => 'corproducts',
        'posts_per_page'    => '36',
        'post_status'       => 'publish',
        'paged'             => $paged
    );

    genesis_custom_loop( wp_parse_args($query_args, $args) );

}

add_action( 'genesis_entry_content', 'add_some_gold', 12 );

function add_some_gold() {
    
    $price = get_post_meta( get_the_ID(), 'item_information_price', true );
    
    // henter ut verdier, corcolor kan ha flere enn en verdi
    $args = array( 'orderby' => 'name', 'order' => 'ASC', 'fields' => 'names' );
    
    $corsize = wp_get_post_terms( get_the_ID(), 'corsize', $args );
    $corcolor = wp_get_post_terms( get_the_ID(), 'corcolor', $args );
    $corheel = wp_get_post_terms( get_the_ID(), 'corheel', $args );
    
    //$test = wp_get_current_user();
    //$test = get_user_meta( 2 );
    //var_dump( $test );
    //echo $current_user->ID;
    
    $user_id = get_the_author_meta( 'ID' );
    $key = 'phone';
    $single = true;
    $phone = get_user_meta( $user_id, $key, $single );
    //print_r( $all_meta_for_user );
    
    if ( ! empty( $price ) ) {
        echo '<div class="cor-price">Pris: ' . $price . '</div>';
    }
    if ( ! empty( $corcolor ) ) {
        $i = 0;
        echo '<div class="cor-color">Farge: ';
        foreach ( $corcolor as $farge ) {
            if ( $i == 0 ) {
                echo $farge;
            } else {
                echo ', ' . $farge;
            }
            $i++;
        } 
        echo '</div>';
    }
    if ( ! empty( $corsize ) ) {
        echo '<div class="cor-size">Størrelse: ' . $corsize[0] . '</div>';
    }
    if ( ! empty( $corheel ) ) {
        echo '<div class="cor-heel">Hælhøyde: ' . $corheel[0] . '</div>';
    }
    echo '<div class="cor-date">Sist endret: ' . get_the_modified_date( $d, get_the_ID() ) . '</div>';
    echo '<div class="cor-selger"><p>Selger er ' . get_the_author_meta( 'first_name' ) . ' ' . get_the_author_meta( 'last_name' ) . '<br>';
    echo 'E-post: <a mailto="' . get_the_author_meta( 'user_email' ) . '">' . get_the_author_meta( 'user_email' ) . '</a><br>';
    echo 'Telefon: ' . $phone;
    echo '</div>';
}

add_action( 'genesis_after_content', 'cordelo_shortcode' );

function cordelo_shortcode() {
    echo do_shortcode( '[adds]' );
}

/*
$loop  = new WP_Query( array(
    'post_type'     => 'corproducts',
	'posts_per_page' => 20
) );
*/

/* fungerer bra
function be_display_spain_posts() {
  $loop = new WP_Query( array(
    'posts_per_page' => 5,
    'post_type' => 'corproducts',
    'post_status' => 'publish'
  ) );
  
  if( $loop->have_posts() ): 
    echo '<h3>Terje loop, med takk til Bill</h3>';
    echo '<ul>';
    while( $loop->have_posts() ): $loop->the_post();
      echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
    endwhile;
    echo '</ul>';
  endif;
  wp_reset_postdata();
}
// kjører bare en enkel ADD, og så er det med på leken
add_action( 'genesis_after_entry', 'be_display_spain_posts' );
*/

// $current_user = wp_get_current_user();

/*
$the_query = new WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
      $the_query->the_post();
	  
      // Do Stuff
	} // end while
} // endif

// Reset Post Data
wp_reset_postdata();
*/


genesis();