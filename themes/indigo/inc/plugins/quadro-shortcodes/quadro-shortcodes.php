<?php
/*
Plugin Name: Quadro Shortcodes
Description: Registers Quadro's Shortcodes.
Version: 1.0.1
Author: Quadro Ideas
Author URI: http://quadroideas.com
*/


// Enqueue scripts and styles for Quadro Shortcodes Plugin
function qi_shortcodes_enqueue() {
    wp_enqueue_script( 'qi-shortcodes-scripts', plugins_url('/js/qi-shortcodes-scripts.js', __FILE__), array('jquery'), '', true );
    wp_enqueue_style( 'qi-shortcodes-style', plugins_url('/qi-shortcodes-styles.css', __FILE__) ); 
}
add_action('wp_enqueue_scripts', 'qi_shortcodes_enqueue');

// Adds Typed.js shortcode
function qi_typed_shortcode($atts) {
    $atts = shortcode_atts( array(
        'strings' => '',
        'startdelay' => '800',
        'typespeed' => '40',
        'backspeed' => '0',
        'backdelay' => '800',
        'loop' => true,
    ), $atts, 'qi_typed' );
    return '<span class="qi-typed" data-strings="' . wp_kses_post( $atts['strings'] ) . '" data-start="' . esc_attr( $atts['startdelay'] ) . '" data-speed="' . esc_attr( $atts['typespeed'] ) . '" data-backspeed="' . esc_attr( $atts['backspeed'] ) . '" data-backdelay="' . esc_attr( $atts['backdelay'] ) . '" data-loop="' . esc_attr( $atts['loop'] ) . '"></span>';
}
add_shortcode( 'qi_typed', 'qi_typed_shortcode' );


?>