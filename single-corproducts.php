<?php

//* Template Name: Single products



add_action( 'genesis_before_entry_content', 'custom_featured_image' );
/**
 * Show featured image (if present) before content on single posts.
 */
function custom_featured_image() {
    // if there is no featured image, abort.
    if ( ! has_post_thumbnail() ) {
        return;
    }

    printf( '<figure><img src="%s" alt="%s" /></figure>', genesis_get_image( 'format=url&size=medium_large' ), the_title_attribute( 'echo=0' ) );
}

add_action( 'genesis_entry_content', 'add_some_gold', 12 );

function add_some_gold() {
    
    $price = get_post_meta( get_the_ID(), 'item_information_price', true );
    
    // henter ut verdier, corcolor kan ha flere enn en verdi
    $args = array( 'orderby' => 'name', 'order' => 'ASC', 'fields' => 'names' );
    
    $corsize = wp_get_post_terms( get_the_ID(), 'corsize', $args );
    $corcolor = wp_get_post_terms( get_the_ID(), 'corcolor', $args );
    $corheel = wp_get_post_terms( get_the_ID(), 'corheel', $args );
    
    //$test = get_the_author_meta( 'ID' );
    //$test = get_user_meta( 2 );
    //var_dump( $test );
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
    echo '<div class="cor-selger-full"><p>Selger er ' . get_the_author_meta( 'first_name' ) . ' ' . get_the_author_meta( 'last_name' ) . '<br>';
    echo 'E-post: <a mailto="' . get_the_author_meta( 'user_email' ) . '">' . get_the_author_meta( 'user_email' ) . '</a><br>';
    echo 'Telefon: ' . $phone;
    echo '</div>';
}

genesis();