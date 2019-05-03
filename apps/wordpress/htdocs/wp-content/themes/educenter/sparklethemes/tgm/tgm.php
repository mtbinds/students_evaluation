<?php
/**
 * Recommended plugins
 *
 * @package Educenter
 */

if ( ! function_exists( 'educenter_recommended_plugins' ) ) :

	/**
	 * Recommend plugins.
	 *
	 * @since 1.0.0
	 */
	function educenter_recommended_plugins() {

		$plugins = array(
			
			array(
				'name'     => esc_html__( 'Contact Form 7', 'educenter' ),
				'slug'     => 'contact-form-7',
				'required' => false,
			),

			array(
				'name'     => esc_html__( 'WooCommerce', 'educenter' ),
				'slug'     => 'woocommerce',
				'required' => false,
			),
			
			array(
				'name'     => esc_html__( 'One Click Demo Import', 'educenter' ),
				'slug'     => 'one-click-demo-import',
				'required' => false,
			),
		);

		tgmpa( $plugins );

	}

endif;

add_action( 'tgmpa_register', 'educenter_recommended_plugins' );
