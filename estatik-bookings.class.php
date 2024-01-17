<?php

class Estatik_Bookings {

public static function init() {
    add_action( 'init', array('Estatik_Bookings', 'setup_post_type') );

    register_activation_hook( __FILE__, array('Estatik_Bookings', 'plugin_activate'));
    register_deactivation_hook( __FILE__, array('Estatik_Bookings', 'plugin_deactivate'));

    add_action( 'save_post', array('Estatik_Bookings', 'save_postdata') );
    add_action( 'add_meta_boxes', array('Estatik_Bookings','add_custom_box') );

    add_filter( 'the_content', array('Estatik_Bookings', 'add_frontend_content'), 1);
}

public static function setup_post_type() {
    register_post_type( 'booking', ['public' => true, 'label' => 'Booking', 'supports' => ['title'] ] ); 
} 

public static function plugin_activate() { 
    // Trigger our function that registers the custom post type plugin.
    Estatik_Bookings::setup_post_type(); 
    // Clear the permalinks after the post type has been registered.
    flush_rewrite_rules(); 
}

/**
 * Deactivation hook.
 */
public static function plugin_deactivate() {
    // Unregister the post type, so the rules are no longer in memory.
    unregister_post_type( 'booking' );
    // Clear the permalinks to remove our post type's rules from the database.
    flush_rewrite_rules();
}

public static function save_postdata( $post_id ) {
    if ( array_key_exists( 'eb_start_date_field', $_POST ) ) {
        update_post_meta(
            $post_id,
            'eb_start_date',
            strtotime($_POST['eb_start_date_field'])
        );
    }
    if ( array_key_exists( 'eb_end_date_field', $_POST ) ) {
        update_post_meta(
            $post_id,
            'eb_end_date',
            strtotime($_POST['eb_end_date_field'])
        );
    }
    if ( array_key_exists( 'eb_address_field', $_POST ) ) {
        update_post_meta(
            $post_id,
            'eb_address',
            $_POST['eb_address_field']
        );
    }
}

public static function booking_settings( $post ) {
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

    $startDate = get_post_meta( $post->ID, 'eb_start_date', true );
    $endDate = get_post_meta( $post->ID, 'eb_end_date', true );
    $address = get_post_meta( $post->ID, 'eb_address', true );

    require plugin_dir_path( __FILE__ ) . '/estatik-bookings.template.php';
}

public static function add_custom_box() {
    $screens = [ 'booking' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'eb_estatik_booking',                 // Unique ID
            'Booking Settings',           // Box title
            array('Estatik_Bookings', 'booking_settings'),        // Content callback, must be of type callable
            $screen                         // Post type
        );
    }
}

public static function add_frontend_content($content) {
    if ( is_singular() 
            && in_the_loop() 
            && is_main_query() 
            && get_post_type() == 'booking' ) {
            
        $startDate = get_post_meta( get_the_id(), 'eb_start_date', true );
        $endDate = get_post_meta( get_the_id(), 'eb_end_date', true );
        $address = get_post_meta( get_the_id(), 'eb_address', true );
        
        $newContent = 'start date: ' . date("d M y", $startDate) . " <br> end date: " . date("d M y", $endDate) . " <br> " . $address;
        $gmap = '<iframe
        width="450"
        height="250"
        frameborder="0" style="border:0"
        referrerpolicy="no-referrer-when-downgrade"
        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBDYWIabyIPJ5uyBnV-bqa0Y9G2gAfMfFY&q='
        .$address.'"
        allowfullscreen>
      </iframe>';
        $content .= $newContent.$gmap;
    }
    return $content;
}
}