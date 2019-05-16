<?php
/**
 * VW Education Lite Theme Customizer
 *
 * @package VW Education Lite
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function vw_education_lite_custom_controls() {

    load_template( trailingslashit( get_template_directory() ) . '/inc/custom-controls.php' );
}
add_action( 'customize_register', 'vw_education_lite_custom_controls' );

function vw_education_lite_customize_register( $wp_customize ) {

	load_template( trailingslashit( get_template_directory() ) . 'inc/customize-homepage/class-customize-homepage.php' );

	//add home page setting pannel
	$wp_customize->add_panel( 'vw_education_lite_panel_id', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'VW Settings', 'vw-education-lite' ),
	    'description' => __( 'Description of what this panel does.', 'vw-education-lite' ),
	) );

	//Layouts
	$wp_customize->add_section( 'vw_education_lite_left_right', array(
    	'title'      => __( 'General Settings', 'vw-education-lite' ),
		'priority'   => null,
		'panel' => 'vw_education_lite_panel_id'
	) );

	$wp_customize->add_setting('vw_education_lite_width_option',array(
        'default' => __('Full Width','vw-education-lite'),
        'sanitize_callback' => 'vw_education_lite_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Education_Lite_Image_Radio_Control($wp_customize, 'vw_education_lite_width_option', array(
        'type' => 'select',
        'label' => __('Width Layouts','vw-education-lite'),
        'description' => __('Here you can change the width layout of Website.','vw-education-lite'),
        'section' => 'vw_education_lite_left_right',
        'choices' => array(
            'Full Width' => get_template_directory_uri().'/images/full-width.png',
            'Wide Width' => get_template_directory_uri().'/images/wide-width.png',
            'Boxed' => get_template_directory_uri().'/images/boxed-width.png',
    ))));

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('vw_education_lite_theme_options',array(
        'default' => __('Right Sidebar','vw-education-lite'),
        'sanitize_callback' => 'vw_education_lite_sanitize_choices'	        
	) );
	$wp_customize->add_control('vw_education_lite_theme_options', array(
        'type' => 'select',
        'label' => __('Post Sidebar Layout','vw-education-lite'),
        'description' => __('Here you can change the sidebar layout for posts. ','vw-education-lite'),
        'section' => 'vw_education_lite_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','vw-education-lite'),
            'Right Sidebar' => __('Right Sidebar','vw-education-lite'),
            'One Column' => __('One Column','vw-education-lite'),
            'Three Columns' => __('Three Columns','vw-education-lite'),
            'Four Columns' => __('Four Columns','vw-education-lite'),
            'Grid Layout' => __('Grid Layout','vw-education-lite')
        ),
	));

	$wp_customize->add_setting('vw_education_lite_page_layout',array(
        'default' => __('One Column','vw-education-lite'),
        'sanitize_callback' => 'vw_education_lite_sanitize_choices'
	));
	$wp_customize->add_control('vw_education_lite_page_layout',array(
        'type' => 'select',
        'label' => __('Page Sidebar Layout','vw-education-lite'),
        'description' => __('Here you can change the sidebar layout for pages. ','vw-education-lite'),
        'section' => 'vw_education_lite_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','vw-education-lite'),
            'Right Sidebar' => __('Right Sidebar','vw-education-lite'),
            'One Column' => __('One Column','vw-education-lite')
        ),
	) );

	// Topbar
	$wp_customize->add_section('vw_education_lite_headercont_section',array(
		'title'	=> __('Topbar','vw-education-lite'),
		'description'	=> __('Add topbar contact details here','vw-education-lite'),
		'priority'	=> null,
		'panel' => 'vw_education_lite_panel_id'
	));
	
	$wp_customize->add_setting('vw_education_lite_cont_phone',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_education_lite_cont_phone',array(
		'label'	=> __('Add contact number','vw-education-lite'),
		'section'	=> 'vw_education_lite_headercont_section',
		'setting'	=> 'vw_education_lite_cont_phone',
		'type'	=> 'text'
	));
	
	$wp_customize->add_setting('vw_education_lite_cont_email',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_education_lite_cont_email',array(
		'label'	=> __('Add email address here','vw-education-lite'),
		'section'	=> 'vw_education_lite_headercont_section',
		'setting'	=> 'vw_education_lite_cont_email',
		'type'		=> 'text'
	));

	//home page slider
	$wp_customize->add_section( 'vw_education_lite_slidersettings' , array(
      'title'      => __( 'Slider Settings', 'vw-education-lite' ),
	    'priority'   => null,
	    'panel' => 'vw_education_lite_panel_id'
	  ) );

	$wp_customize->add_setting( 'vw_education_lite_slider_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_education_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Education_Lite_Toggle_Switch_Custom_control( $wp_customize, 'vw_education_lite_slider_hide_show',
       array(
		'label' => esc_html__( 'Show / Hide Slider','vw-education-lite' ),
		'section' => 'vw_education_lite_slidersettings'
    )));

	for ( $count = 1; $count <= 4; $count++ ) {

	    // Add color scheme setting and control.
	    $wp_customize->add_setting( 'vw_education_lite_slider_page' . $count, array(
	      'default'           => '',
	      'sanitize_callback' => 'vw_education_lite_sanitize_dropdown_pages'
	    ) );
	    $wp_customize->add_control( 'vw_education_lite_slider_page' . $count, array(
	      'label'    => __( 'Select Slide Image Page', 'vw-education-lite' ),
	      'description' => __('Slider image size (1500 x 765)','vw-education-lite'),
	      'section'  => 'vw_education_lite_slidersettings',
	      'type'     => 'dropdown-pages'
	    ) );
  	}

  	//content layout
	$wp_customize->add_setting('vw_education_lite_slider_content_option',array(
        'default' => __('Center','vw-education-lite'),
        'sanitize_callback' => 'vw_education_lite_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Education_Lite_Image_Radio_Control($wp_customize, 'vw_education_lite_slider_content_option', array(
        'type' => 'select',
        'label' => __('Slider Content Layouts','vw-education-lite'),
        'section' => 'vw_education_lite_slidersettings',
        'choices' => array(
            'Left' => get_template_directory_uri().'/images/slider-content1.png',
            'Center' => get_template_directory_uri().'/images/slider-content2.png',
            'Right' => get_template_directory_uri().'/images/slider-content3.png',
    ))));

    //Slider excerpt
	$wp_customize->add_setting( 'vw_education_lite_slider_excerpt_number', array(
		'default'              => 30,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'vw_education_lite_slider_excerpt_number', array(
		'label'       => esc_html__( 'Slider Excerpt length','vw-education-lite' ),
		'section'     => 'vw_education_lite_slidersettings',
		'type'        => 'range',
		'settings'    => 'vw_education_lite_slider_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Opacity
	$wp_customize->add_setting('vw_education_lite_slider_opacity_color',array(
      'default'              => 0.5,
      'sanitize_callback' => 'vw_education_lite_sanitize_choices'
	));

	$wp_customize->add_control( 'vw_education_lite_slider_opacity_color', array(
	'label'       => esc_html__( 'Slider Image Opacity','vw-education-lite' ),
	'section'     => 'vw_education_lite_slidersettings',
	'type'        => 'select',
	'settings'    => 'vw_education_lite_slider_opacity_color',
	'choices' => array(
      '0' =>  esc_attr('0','vw-education-lite'),
      '0.1' =>  esc_attr('0.1','vw-education-lite'),
      '0.2' =>  esc_attr('0.2','vw-education-lite'),
      '0.3' =>  esc_attr('0.3','vw-education-lite'),
      '0.4' =>  esc_attr('0.4','vw-education-lite'),
      '0.5' =>  esc_attr('0.5','vw-education-lite'),
      '0.6' =>  esc_attr('0.6','vw-education-lite'),
      '0.7' =>  esc_attr('0.7','vw-education-lite'),
      '0.8' =>  esc_attr('0.8','vw-education-lite'),
      '0.9' =>  esc_attr('0.9','vw-education-lite')
	),
	));

	//Our Featured Courses
	$wp_customize->add_section('vw_education_lite_our_courses',array(
		'title'	=> __('Our Featured Courses','vw-education-lite'),
		'description'=> __('This section will appear below the slider.','vw-education-lite'),
		'panel' => 'vw_education_lite_panel_id'
	));	
	
	$wp_customize->add_setting('vw_education_lite_sec1_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_education_lite_sec1_title',array(
		'label'	=> __('Section Title','vw-education-lite'),
		'section'=> 'vw_education_lite_our_courses',
		'setting'=> 'vw_education_lite_sec1_title',
		'type'=> 'text'
	));	
	
	for ( $count = 0; $count <= 2; $count++ ) {

		$wp_customize->add_setting( 'vw_education_lite_courses_settings' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'vw_education_lite_sanitize_dropdown_pages'
		));
		$wp_customize->add_control( 'vw_education_lite_courses_settings' . $count, array(
			'label'    => __( 'Select Courses Page', 'vw-education-lite' ),
			'section'  => 'vw_education_lite_our_courses',
			'type'     => 'dropdown-pages'
		));
	}

	//Blog Post
	$wp_customize->add_section('vw_education_lite_blog_post',array(
		'title'	=> __('Blog Post Settings','vw-education-lite'),
		'panel' => 'vw_education_lite_panel_id',
	));	

	$wp_customize->add_setting( 'vw_education_lite_toggle_postdate',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_education_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Education_Lite_Toggle_Switch_Custom_control( $wp_customize, 'vw_education_lite_toggle_postdate',array(
        'label' => esc_html__( 'Post Date','vw-education-lite' ),
        'section' => 'vw_education_lite_blog_post'
    )));

    $wp_customize->add_setting( 'vw_education_lite_toggle_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_education_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Education_Lite_Toggle_Switch_Custom_control( $wp_customize, 'vw_education_lite_toggle_author',array(
		'label' => esc_html__( 'Author','vw-education-lite' ),
		'section' => 'vw_education_lite_blog_post'
    )));

    $wp_customize->add_setting( 'vw_education_lite_toggle_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_education_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Education_Lite_Toggle_Switch_Custom_control( $wp_customize, 'vw_education_lite_toggle_comments',array(
		'label' => esc_html__( 'Comments','vw-education-lite' ),
		'section' => 'vw_education_lite_blog_post'
    )));

    $wp_customize->add_setting( 'vw_education_lite_excerpt_number', array(
		'default'              => 30,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'vw_education_lite_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','vw-education-lite' ),
		'section'     => 'vw_education_lite_blog_post',
		'type'        => 'range',
		'settings'    => 'vw_education_lite_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Content Creation
	$wp_customize->add_section( 'vw_education_lite_content_section' , array(
    	'title' => __( 'Customize Home Page Settings', 'vw-education-lite' ),
		'priority' => null,
		'panel' => 'vw_education_lite_panel_id'
	) );

	$wp_customize->add_setting('vw_education_lite_content_creation_main_control', array(
		'sanitize_callback' => 'esc_html',
	) );

	$homepage= get_option( 'page_on_front' );

	$wp_customize->add_control(	new VW_Education_Lite_Content_Creation( $wp_customize, 'vw_education_lite_content_creation_main_control', array(
		'options' => array(
			esc_html__( 'First select static page in homepage setting for front page.Below given edit button is to customize Home Page. Just click on the edit option, add whatever elements you want to include in the homepage, save the changes and you are good to go.','vw-education-lite' ),
		),
		'section' => 'vw_education_lite_content_section',
		'button_url'  => admin_url( 'post.php?post='.$homepage.'&action=edit'),
		'button_text' => esc_html__( 'Edit', 'vw-education-lite' ),
	) ) );
	
	//Footer Text
	$wp_customize->add_section('vw_education_lite_footer_section',array(
		'title'	=> __('Footer Text','vw-education-lite'),
		'description'	=> __('Add some text for footer like copyright etc.','vw-education-lite'),
		'priority'	=> null,
		'panel' => 'vw_education_lite_panel_id'
	));
	
	$wp_customize->add_setting('vw_education_lite_footer_copy',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field',
	));
	
	$wp_customize->add_control('vw_education_lite_footer_copy',array(
		'label'	=> __('Copyright Text','vw-education-lite'),
		'section'	=> 'vw_education_lite_footer_section',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('vw_education_lite_scroll_top_alignment',array(
        'default' => __('Right','vw-education-lite'),
        'sanitize_callback' => 'vw_education_lite_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Education_Lite_Image_Radio_Control($wp_customize, 'vw_education_lite_scroll_top_alignment', array(
        'type' => 'select',
        'label' => __('Scroll To Top','vw-education-lite'),
        'section' => 'vw_education_lite_footer_section',
        'settings' => 'vw_education_lite_scroll_top_alignment',
        'choices' => array(
            'Left' => get_template_directory_uri().'/images/layout1.png',
            'Center' => get_template_directory_uri().'/images/layout2.png',
            'Right' => get_template_directory_uri().'/images/layout3.png'
    ))));
    
}
add_action( 'customize_register', 'vw_education_lite_customize_register' );

load_template( trailingslashit( get_template_directory() ) . '/inc/logo-resizer.php' );
//Integer
function vw_education_lite_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
        return absint( $input );
    }
}

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class VW_Education_Lite_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'VW_Education_Lite_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(new VW_Education_Lite_Customize_Section_Pro($manager,'example_1',array(
			'priority'	=> 1,
			'title'    => esc_html__( 'VW Education Pro', 'vw-education-lite' ),
			'pro_text' => esc_html__( 'UPGRADE PRO', 'vw-education-lite' ),
			'pro_url'  => esc_url('https://www.vwthemes.com/product/vw-education-theme/')
		)));

		$manager->add_section(new VW_Education_Lite_Customize_Section_Pro($manager,'example_2',array(
			'priority'	=> 1,
			'title'    => esc_html__( 'DOCUMENATATION', 'vw-education-lite' ),
			'pro_text' => esc_html__( 'DOCS',  'vw-education-lite' ),
			'pro_url'  => admin_url( 'themes.php?page=vw_education_lite_guide' )
		)));
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'vw-education-lite-customize-controls', trailingslashit( get_template_directory_uri() ) . '/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'vw-education-lite-customize-controls', trailingslashit( get_template_directory_uri() ) . '/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
VW_Education_Lite_Customize::get_instance();