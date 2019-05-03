<?php
/**
 * Loads the child theme textdomain.
 */
function onepagec_child_theme_setup() {
    load_child_theme_textdomain('onepagec');
}
add_action( 'after_setup_theme', 'onepagec_child_theme_setup' );

function onepagec_child_enqueue_styles() {
    $parent_style = 'onepagec-parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	 wp_enqueue_style( 'onepagec-style',get_stylesheet_directory_uri() . '/onepagec.css');
}
add_action( 'wp_enqueue_scripts', 'onepagec_child_enqueue_styles',99);
?>