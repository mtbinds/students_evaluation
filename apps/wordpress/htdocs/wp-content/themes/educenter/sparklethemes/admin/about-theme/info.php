<?php
/**
 * Info setup
 *
 * @package Educenter
 */

if ( ! function_exists( 'Educenter_info_setup' ) ) :

	/**
	 * Info setup.
	 *
	 * @since 1.0.0
	 */
	function Educenter_info_setup() {

		$config = array(

			// Welcome content.
			'welcome_content' => sprintf( esc_html__( '%1$s is a user-friendly, elegant, easy to apply and responsive best FREE WordPress education theme with colorful design and stunning customization flexibility. Educenter WordPress theme is designed especially for colleges, university, institutions, schools, online courses and different other educationvbased websites. The theme shows your website within the satisfactory viable way on smartphones, iPhones, tablets, and laptops, as well as large laptop screens. This theme will help you to create very high-quality and perfect instructional website effortlessly and easily in less time.', 'educenter' ), 'Educenter' ),

			// Tabs.
			'tabs' => array(
				'getting-started' => esc_html__( 'Getting Started', 'educenter' ),
				'support'         => esc_html__( 'Support', 'educenter' ),
				'useful-plugins'  => esc_html__( 'Useful Plugins', 'educenter' ),
				'demo-content'    => esc_html__( 'Demo Content', 'educenter' ),
				/*'upgrade-to-pro'  => esc_html__( 'Upgrade to Pro', 'educenter' ),*/
			),

			// Quick links.
			'quick_links' => array(

				'theme_url' => array(
					'text' => esc_html__( 'Theme Details', 'educenter' ),
					'url'  => 'https://sparklewpthemes.com/wordpress-themes/educenter/',
				),

				'demo_url' => array(
					'text' => esc_html__( 'View Demo', 'educenter' ),
					'url'  => 'http://demo.sparklewpthemes.com/educenter/',
				),

				'documentation_url' => array(
					'text' => esc_html__( 'View Documentation', 'educenter' ),
					'url'  => 'http://docs.sparklewpthemes.com/educenter/',
				),

				'rating_url' => array(
					'text' => esc_html__( 'Rate This Theme','educenter' ),
					'url'  => 'https://wordpress.org/support/theme/educenter/reviews/#new-post',
				),

				/*'upgrade_to_pro' => array(
					'text' => esc_html__( 'Buy Pro Themes','educenter' ),
					'url'  => 'https://sparklewpthemes.com/wordpress-themes/educenter-pro/',
				)*/

			),

			// Getting started.
			'getting_started' => array(
				'one' => array(
					'title'       => esc_html__( 'Theme Documentation', 'educenter' ),
					'icon'        => 'dashicons dashicons-format-aside',
					'description' => esc_html__( 'Please check our full documentation for detailed information on how to setup and customize the theme.', 'educenter' ),
					'button_text' => esc_html__( 'View Documentation', 'educenter' ),
					'button_url'  => 'http://docs.sparklewpthemes.com/educenter/',
					'button_type' => 'link',
					'is_new_tab'  => true,
					),
				
				'three' => array(
					'title'       => esc_html__( 'Theme Options', 'educenter' ),
					'icon'        => 'dashicons dashicons-admin-customizer',
					'description' => esc_html__( 'Theme uses Customizer API for theme options. Using the Customizer you can easily customize different aspects of the theme.', 'educenter' ),
					'button_text' => esc_html__( 'Customize', 'educenter' ),
					'button_url'  => wp_customize_url(),
					'button_type' => 'primary',
					),
				
				'five' => array(
					'title'       => esc_html__( 'Demo Content', 'educenter' ),
					'icon'        => 'dashicons dashicons-layout',
					'description' => sprintf( esc_html__( 'To import sample demo content, %1$s plugin should be installed and activated. After plugin is activated, visit Import Demo Data menu under Appearance.', 'educenter' ), esc_html__( 'One Click Demo Import', 'educenter' ) ),
					'button_text' => esc_html__( 'Demo Content', 'educenter' ),
					'button_url'  => admin_url( 'themes.php?page=educenter-info&tab=demo-content' ),
					'button_type' => 'secondary',
					)
				
				),

			// Support.
			'support' => array(
				'one' => array(
					'title'       => esc_html__( 'Contact Support', 'educenter' ),
					'icon'        => 'dashicons dashicons-sos',
					'description' => esc_html__( 'Got theme support question or found bug or got some feedbacks? Best place to ask your query is the dedicated Support forum for the theme.', 'educenter' ),
					'button_text' => esc_html__( 'Contact Support', 'educenter' ),
					'button_url'  => 'https://sparklewpthemes.com/support/forum/wordpress-themes/free-themes/',
					'button_type' => 'link',
					'is_new_tab'  => true,
					),
				'two' => array(
					'title'       => esc_html__( 'Theme Documentation', 'educenter' ),
					'icon'        => 'dashicons dashicons-format-aside',
					'description' => esc_html__( 'Please check our full documentation for detailed information on how to setup and customize the theme.', 'educenter' ),
					'button_text' => esc_html__( 'View Documentation', 'educenter' ),
					'button_url'  => 'http://docs.sparklewpthemes.com/educenter/',
					'button_type' => 'link',
					'is_new_tab'  => true,
					),
				'three' => array(
					'title'       => esc_html__( 'Child Theme', 'educenter' ),
					'icon'        => 'dashicons dashicons-admin-tools',
					'description' => esc_html__( 'For advanced theme customization, it is recommended to use child theme rather than modifying the theme file itself. Using this approach, you wont lose the customization after theme update.', 'educenter' ),
					'button_text' => esc_html__( 'Learn More', 'educenter' ),
					'button_url'  => 'https://developer.wordpress.org/themes/advanced-topics/child-themes/',
					'button_type' => 'link',
					'is_new_tab'  => true,
					),
				),

			// Useful plugins.
			'useful_plugins' => array(
				'description' => esc_html__( 'Theme supports some helpful WordPress plugins to enhance your site. But, please enable only those plugins which you need in your site. For example, enable WooCommerce only if you are using e-commerce.', 'educenter' ),
				),

			// Demo content.
			'demo_content' => array(
				'description' => sprintf( esc_html__( 'To import demo content for this theme, %1$s plugin is needed. Please make sure plugin is installed and activated. After plugin is activated, you will see Import Demo Data menu under Appearance.', 'educenter' ), '<a href="https://wordpress.org/plugins/one-click-demo-import/" target="_blank">' . esc_html__( 'One Click Demo Import', 'educenter' ) . '</a>' ),
				),

			/*// Upgrade content.
			'upgrade_to_pro' => array(
				'description' => esc_html__( 'If you want more advanced features then you can upgrade to the premium version of the theme.', 'educenter' ),
				'button_text' => esc_html__( 'Buy Pro Themes', 'educenter' ),
				'button_url'  => 'https://sparklewpthemes.com/wordpress-themes/educenter-pro/',
				'button_type' => 'primary',
				'is_new_tab'  => true,
				),*/
			);

		Educenter::init( $config );
	}

endif;

add_action( 'after_setup_theme', 'Educenter_info_setup' );
