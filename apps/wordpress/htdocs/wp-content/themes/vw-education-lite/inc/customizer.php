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
function vw_education_lite_customize_register( $wp_customize ) {

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
		'priority'   => 30,
		'panel' => 'vw_education_lite_panel_id'
	) );

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('vw_education_lite_theme_options',array(
	        'default' => '',
	        'sanitize_callback' => 'vw_education_lite_sanitize_choices'	        
	    )
    );

	$wp_customize->add_control('vw_education_lite_theme_options',
	    array(
	        'type' => 'radio',
	        'label' => __('Change Layouts','vw-education-lite'),
	        'section' => 'vw_education_lite_left_right',
	        'choices' => array(
	            'Left Sidebar' => __('Left Sidebar','vw-education-lite'),
	            'Right Sidebar' => __('Right Sidebar','vw-education-lite'),
	            'One Column' => __('One Column','vw-education-lite'),
	            'Three Columns' => __('Three Columns','vw-education-lite'),
	            'Four Columns' => __('Four Columns','vw-education-lite'),
	            'Grid Layout' => __('Grid Layout','vw-education-lite')
	        ),
	    )
    );

    $font_array = array(
        '' => __( 'No Fonts', 'vw-education-lite' ),
        'Abril Fatface' => __( 'Abril Fatface', 'vw-education-lite' ),
        'Acme' => __( 'Acme', 'vw-education-lite' ),
        'Anton' => __( 'Anton', 'vw-education-lite' ),
        'Architects Daughter' => __( 'Architects Daughter', 'vw-education-lite' ),
        'Arimo' => __( 'Arimo', 'vw-education-lite' ),
        'Arsenal' => __( 'Arsenal', 'vw-education-lite' ),
        'Arvo' => __( 'Arvo', 'vw-education-lite' ),
        'Alegreya' => __( 'Alegreya', 'vw-education-lite' ),
        'Alfa Slab One' => __( 'Alfa Slab One', 'vw-education-lite' ),
        'Averia Serif Libre' => __( 'Averia Serif Libre', 'vw-education-lite' ),
        'Bangers' => __( 'Bangers', 'vw-education-lite' ),
        'Boogaloo' => __( 'Boogaloo', 'vw-education-lite' ),
        'Bad Script' => __( 'Bad Script', 'vw-education-lite' ),
        'Bitter' => __( 'Bitter', 'vw-education-lite' ),
        'Bree Serif' => __( 'Bree Serif', 'vw-education-lite' ),
        'BenchNine' => __( 'BenchNine', 'vw-education-lite' ),
        'Cabin' => __( 'Cabin', 'vw-education-lite' ),
        'Cardo' => __( 'Cardo', 'vw-education-lite' ),
        'Courgette' => __( 'Courgette', 'vw-education-lite' ),
        'Cherry Swash' => __( 'Cherry Swash', 'vw-education-lite' ),
        'Cormorant Garamond' => __( 'Cormorant Garamond', 'vw-education-lite' ),
        'Crimson Text' => __( 'Crimson Text', 'vw-education-lite' ),
        'Cuprum' => __( 'Cuprum', 'vw-education-lite' ),
        'Cookie' => __( 'Cookie', 'vw-education-lite' ),
        'Chewy' => __( 'Chewy', 'vw-education-lite' ),
        'Days One' => __( 'Days One', 'vw-education-lite' ),
        'Dosis' => __( 'Dosis', 'vw-education-lite' ),
        'Droid Sans' => __( 'Droid Sans', 'vw-education-lite' ),
        'Economica' => __( 'Economica', 'vw-education-lite' ),
        'Fredoka One' => __( 'Fredoka One', 'vw-education-lite' ),
        'Fjalla One' => __( 'Fjalla One', 'vw-education-lite' ),
        'Francois One' => __( 'Francois One', 'vw-education-lite' ),
        'Frank Ruhl Libre' => __( 'Frank Ruhl Libre', 'vw-education-lite' ),
        'Gloria Hallelujah' => __( 'Gloria Hallelujah', 'vw-education-lite' ),
        'Great Vibes' => __( 'Great Vibes', 'vw-education-lite' ),
        'Handlee' => __( 'Handlee', 'vw-education-lite' ),
        'Hammersmith One' => __( 'Hammersmith One', 'vw-education-lite' ),
        'Inconsolata' => __( 'Inconsolata', 'vw-education-lite' ),
        'Indie Flower' => __( 'Indie Flower', 'vw-education-lite' ),
        'IM Fell English SC' => __( 'IM Fell English SC', 'vw-education-lite' ),
        'Julius Sans One' => __( 'Julius Sans One', 'vw-education-lite' ),
        'Josefin Slab' => __( 'Josefin Slab', 'vw-education-lite' ),
        'Josefin Sans' => __( 'Josefin Sans', 'vw-education-lite' ),
        'Kanit' => __( 'Kanit', 'vw-education-lite' ),
        'Lobster' => __( 'Lobster', 'vw-education-lite' ),
        'Lato' => __( 'Lato', 'vw-education-lite' ),
        'Lora' => __( 'Lora', 'vw-education-lite' ),
        'Libre Baskerville' => __( 'Libre Baskerville', 'vw-education-lite' ),
        'Lobster Two' => __( 'Lobster Two', 'vw-education-lite' ),
        'Merriweather' => __( 'Merriweather', 'vw-education-lite' ),
        'Monda' => __( 'Monda', 'vw-education-lite' ),
        'Montserrat' => __( 'Montserrat', 'vw-education-lite' ),
        'Muli' => __( 'Muli', 'vw-education-lite' ),
        'Marck Script' => __( 'Marck Script', 'vw-education-lite' ),
        'Noto Serif' => __( 'Noto Serif', 'vw-education-lite' ),
        'Open Sans' => __( 'Open Sans', 'vw-education-lite' ),
        'Overpass' => __( 'Overpass', 'vw-education-lite' ),
        'Overpass Mono' => __( 'Overpass Mono', 'vw-education-lite' ),
        'Oxygen' => __( 'Oxygen', 'vw-education-lite' ),
        'Orbitron' => __( 'Orbitron', 'vw-education-lite' ),
        'Patua One' => __( 'Patua One', 'vw-education-lite' ),
        'Pacifico' => __( 'Pacifico', 'vw-education-lite' ),
        'Padauk' => __( 'Padauk', 'vw-education-lite' ),
        'Playball' => __( 'Playball', 'vw-education-lite' ),
        'Playfair Display' => __( 'Playfair Display', 'vw-education-lite' ),
        'PT Sans' => __( 'PT Sans', 'vw-education-lite' ),
        'Philosopher' => __( 'Philosopher', 'vw-education-lite' ),
        'Permanent Marker' => __( 'Permanent Marker', 'vw-education-lite' ),
        'Poiret One' => __( 'Poiret One', 'vw-education-lite' ),
        'Quicksand' => __( 'Quicksand', 'vw-education-lite' ),
        'Quattrocento Sans' => __( 'Quattrocento Sans', 'vw-education-lite' ),
        'Raleway' => __( 'Raleway', 'vw-education-lite' ),
        'Rubik' => __( 'Rubik', 'vw-education-lite' ),
        'Rokkitt' => __( 'Rokkitt', 'vw-education-lite' ),
        'Russo One' => __( 'Russo One', 'vw-education-lite' ),
        'Righteous' => __( 'Righteous', 'vw-education-lite' ),
        'Slabo' => __( 'Slabo', 'vw-education-lite' ),
        'Source Sans Pro' => __( 'Source Sans Pro', 'vw-education-lite' ),
        'Shadows Into Light Two' => __( 'Shadows Into Light Two', 'vw-education-lite'),
        'Shadows Into Light' => __( 'Shadows Into Light', 'vw-education-lite' ),
        'Sacramento' => __( 'Sacramento', 'vw-education-lite' ),
        'Shrikhand' => __( 'Shrikhand', 'vw-education-lite' ),
        'Tangerine' => __( 'Tangerine', 'vw-education-lite' ),
        'Ubuntu' => __( 'Ubuntu', 'vw-education-lite' ),
        'VT323' => __( 'VT323', 'vw-education-lite' ),
        'Varela Round' => __( 'Varela Round', 'vw-education-lite' ),
        'Vampiro One' => __( 'Vampiro One', 'vw-education-lite' ),
        'Vollkorn' => __( 'Vollkorn', 'vw-education-lite' ),
        'Volkhov' => __( 'Volkhov', 'vw-education-lite' ),
        'Yanone Kaffeesatz' => __( 'Yanone Kaffeesatz', 'vw-education-lite' )
    );

	//Typography
	$wp_customize->add_section( 'vw_education_lite_typography', array(
    	'title'      => __( 'Typography', 'vw-education-lite' ),
		'priority'   => 30,
		'panel' => 'vw_education_lite_panel_id'
	) );
	
	// This is Paragraph Color picker setting
	$wp_customize->add_setting( 'vw_education_lite_paragraph_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vw_education_lite_paragraph_color', array(
		'label' => __('Paragraph Color', 'vw-education-lite'),
		'section' => 'vw_education_lite_typography',
		'settings' => 'vw_education_lite_paragraph_color',
	)));

	//This is Paragraph FontFamily picker setting
	$wp_customize->add_setting('vw_education_lite_paragraph_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'vw_education_lite_sanitize_choices'
	));
	$wp_customize->add_control(
	    'vw_education_lite_paragraph_font_family', array(
	    'section'  => 'vw_education_lite_typography',
	    'label'    => __( 'Paragraph Fonts','vw-education-lite'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	$wp_customize->add_setting('vw_education_lite_paragraph_font_size',array(
		'default'	=> '12px',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_education_lite_paragraph_font_size',array(
		'label'	=> __('Paragraph Font Size','vw-education-lite'),
		'section'	=> 'vw_education_lite_typography',
		'setting'	=> 'vw_education_lite_paragraph_font_size',
		'type'	=> 'text'
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'vw_education_lite_atag_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vw_education_lite_atag_color', array(
		'label' => __('"a" Tag Color', 'vw-education-lite'),
		'section' => 'vw_education_lite_typography',
		'settings' => 'vw_education_lite_atag_color',
	)));

	//This is "a" Tag FontFamily picker setting
	$wp_customize->add_setting('vw_education_lite_atag_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'vw_education_lite_sanitize_choices'
	));
	$wp_customize->add_control(
	    'vw_education_lite_atag_font_family', array(
	    'section'  => 'vw_education_lite_typography',
	    'label'    => __( '"a" Tag Fonts','vw-education-lite'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'vw_education_lite_li_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vw_education_lite_li_color', array(
		'label' => __('"li" Tag Color', 'vw-education-lite'),
		'section' => 'vw_education_lite_typography',
		'settings' => 'vw_education_lite_li_color',
	)));

	//This is "li" Tag FontFamily picker setting
	$wp_customize->add_setting('vw_education_lite_li_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'vw_education_lite_sanitize_choices'
	));
	$wp_customize->add_control(
	    'vw_education_lite_li_font_family', array(
	    'section'  => 'vw_education_lite_typography',
	    'label'    => __( '"li" Tag Fonts','vw-education-lite'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	// This is H1 Color picker setting
	$wp_customize->add_setting( 'vw_education_lite_h1_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vw_education_lite_h1_color', array(
		'label' => __('H1 Color', 'vw-education-lite'),
		'section' => 'vw_education_lite_typography',
		'settings' => 'vw_education_lite_h1_color',
	)));

	//This is H1 FontFamily picker setting
	$wp_customize->add_setting('vw_education_lite_h1_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'vw_education_lite_sanitize_choices'
	));
	$wp_customize->add_control(
	    'vw_education_lite_h1_font_family', array(
	    'section'  => 'vw_education_lite_typography',
	    'label'    => __( 'H1 Fonts','vw-education-lite'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H1 FontSize setting
	$wp_customize->add_setting('vw_education_lite_h1_font_size',array(
		'default'	=> '50px',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_education_lite_h1_font_size',array(
		'label'	=> __('H1 Font Size','vw-education-lite'),
		'section'	=> 'vw_education_lite_typography',
		'setting'	=> 'vw_education_lite_h1_font_size',
		'type'	=> 'text'
	));

	// This is H2 Color picker setting
	$wp_customize->add_setting( 'vw_education_lite_h2_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vw_education_lite_h2_color', array(
		'label' => __('h2 Color', 'vw-education-lite'),
		'section' => 'vw_education_lite_typography',
		'settings' => 'vw_education_lite_h2_color',
	)));

	//This is H2 FontFamily picker setting
	$wp_customize->add_setting('vw_education_lite_h2_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'vw_education_lite_sanitize_choices'
	));
	$wp_customize->add_control(
	    'vw_education_lite_h2_font_family', array(
	    'section'  => 'vw_education_lite_typography',
	    'label'    => __( 'h2 Fonts','vw-education-lite'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H2 FontSize setting
	$wp_customize->add_setting('vw_education_lite_h2_font_size',array(
		'default'	=> '45px',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_education_lite_h2_font_size',array(
		'label'	=> __('h2 Font Size','vw-education-lite'),
		'section'	=> 'vw_education_lite_typography',
		'setting'	=> 'vw_education_lite_h2_font_size',
		'type'	=> 'text'
	));

	// This is H3 Color picker setting
	$wp_customize->add_setting( 'vw_education_lite_h3_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vw_education_lite_h3_color', array(
		'label' => __('h3 Color', 'vw-education-lite'),
		'section' => 'vw_education_lite_typography',
		'settings' => 'vw_education_lite_h3_color',
	)));

	//This is H3 FontFamily picker setting
	$wp_customize->add_setting('vw_education_lite_h3_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'vw_education_lite_sanitize_choices'
	));
	$wp_customize->add_control(
	    'vw_education_lite_h3_font_family', array(
	    'section'  => 'vw_education_lite_typography',
	    'label'    => __( 'h3 Fonts','vw-education-lite'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H3 FontSize setting
	$wp_customize->add_setting('vw_education_lite_h3_font_size',array(
		'default'	=> '36px',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_education_lite_h3_font_size',array(
		'label'	=> __('h3 Font Size','vw-education-lite'),
		'section'	=> 'vw_education_lite_typography',
		'setting'	=> 'vw_education_lite_h3_font_size',
		'type'	=> 'text'
	));

	// This is H4 Color picker setting
	$wp_customize->add_setting( 'vw_education_lite_h4_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vw_education_lite_h4_color', array(
		'label' => __('h4 Color', 'vw-education-lite'),
		'section' => 'vw_education_lite_typography',
		'settings' => 'vw_education_lite_h4_color',
	)));

	//This is H4 FontFamily picker setting
	$wp_customize->add_setting('vw_education_lite_h4_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'vw_education_lite_sanitize_choices'
	));
	$wp_customize->add_control(
	    'vw_education_lite_h4_font_family', array(
	    'section'  => 'vw_education_lite_typography',
	    'label'    => __( 'h4 Fonts','vw-education-lite'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H4 FontSize setting
	$wp_customize->add_setting('vw_education_lite_h4_font_size',array(
		'default'	=> '30px',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_education_lite_h4_font_size',array(
		'label'	=> __('h4 Font Size','vw-education-lite'),
		'section'	=> 'vw_education_lite_typography',
		'setting'	=> 'vw_education_lite_h4_font_size',
		'type'	=> 'text'
	));

	// This is H5 Color picker setting
	$wp_customize->add_setting( 'vw_education_lite_h5_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vw_education_lite_h5_color', array(
		'label' => __('h5 Color', 'vw-education-lite'),
		'section' => 'vw_education_lite_typography',
		'settings' => 'vw_education_lite_h5_color',
	)));

	//This is H5 FontFamily picker setting
	$wp_customize->add_setting('vw_education_lite_h5_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'vw_education_lite_sanitize_choices'
	));
	$wp_customize->add_control(
	    'vw_education_lite_h5_font_family', array(
	    'section'  => 'vw_education_lite_typography',
	    'label'    => __( 'h5 Fonts','vw-education-lite'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H5 FontSize setting
	$wp_customize->add_setting('vw_education_lite_h5_font_size',array(
		'default'	=> '25px',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_education_lite_h5_font_size',array(
		'label'	=> __('h5 Font Size','vw-education-lite'),
		'section'	=> 'vw_education_lite_typography',
		'setting'	=> 'vw_education_lite_h5_font_size',
		'type'	=> 'text'
	));

	// This is H6 Color picker setting
	$wp_customize->add_setting( 'vw_education_lite_h6_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vw_education_lite_h6_color', array(
		'label' => __('h6 Color', 'vw-education-lite'),
		'section' => 'vw_education_lite_typography',
		'settings' => 'vw_education_lite_h6_color',
	)));

	//This is H6 FontFamily picker setting
	$wp_customize->add_setting('vw_education_lite_h6_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'vw_education_lite_sanitize_choices'
	));
	$wp_customize->add_control(
	    'vw_education_lite_h6_font_family', array(
	    'section'  => 'vw_education_lite_typography',
	    'label'    => __( 'h6 Fonts','vw-education-lite'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H6 FontSize setting
	$wp_customize->add_setting('vw_education_lite_h6_font_size',array(
		'default'	=> '18px',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_education_lite_h6_font_size',array(
		'label'	=> __('h6 Font Size','vw-education-lite'),
		'section'	=> 'vw_education_lite_typography',
		'setting'	=> 'vw_education_lite_h6_font_size',
		'type'	=> 'text'
	));
	
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

	//Social Icons(topbar)
	$wp_customize->add_section('vw_education_lite_topbar_header',array(
		'title'	=> __('Social Icon Section','vw-education-lite'),
		'description'	=> __('Add Header Content here','vw-education-lite'),
		'priority'	=> null,
		'panel' => 'vw_education_lite_panel_id',
	));

	$wp_customize->add_setting('vw_education_lite_youtube_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control('vw_education_lite_youtube_url',array(
		'label'	=> __('Add Youtube link','vw-education-lite'),
		'section'	=> 'vw_education_lite_topbar_header',
		'setting'	=> 'vw_education_lite_youtube_url',
		'type'		=> 'url'
	));

	$wp_customize->add_setting('vw_education_lite_facebook_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control('vw_education_lite_facebook_url',array(
		'label'	=> __('Add Facebook link','vw-education-lite'),
		'section'	=> 'vw_education_lite_topbar_header',
		'setting'	=> 'vw_education_lite_facebook_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('vw_education_lite_twitter_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control('vw_education_lite_twitter_url',array(
		'label'	=> __('Add Twitter link','vw-education-lite'),
		'section'	=> 'vw_education_lite_topbar_header',
		'setting'	=> 'vw_education_lite_twitter_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('vw_education_lite_rss_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control('vw_education_lite_rss_url',array(
		'label'	=> __('Add RSS link','vw-education-lite'),
		'section'	=> 'vw_education_lite_topbar_header',
		'setting'	=> 'vw_education_lite_rss_url',
		'type'	=> 'url'
	));


	//home page slider
	$wp_customize->add_section( 'vw_education_lite_slidersettings' , array(
    	'title'      => __( 'Slider Settings', 'vw-education-lite' ),
		'priority'   => 30,
		'panel' => 'vw_education_lite_panel_id'
	) );

	for ( $count = 1; $count <= 4; $count++ ) {

		// Add color scheme setting and control.
		$wp_customize->add_setting( 'vw_education_lite_slidersettings-page-' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'absint'
		) );

		$wp_customize->add_control( 'vw_education_lite_slidersettings-page-' . $count, array(
			'label'    => __( 'Select Slide Image Page', 'vw-education-lite' ),
			'section'  => 'vw_education_lite_slidersettings',
			'type'     => 'dropdown-pages'
		) );
	}

	//OUR services
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

		$wp_customize->add_setting( 'vw_education_lite_courses_settings-page-' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'absint'
		));
		$wp_customize->add_control( 'vw_education_lite_courses_settings-page-' . $count, array(
			'label'    => __( 'Select Courses Page', 'vw-education-lite' ),
			'section'  => 'vw_education_lite_our_courses',
			'type'     => 'dropdown-pages'
		));
	}
	
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
		$manager->add_section(
			new VW_Education_Lite_Customize_Section_Pro(
				$manager,
				'example_1',
				array(
					'priority'	=> 9,
					'title'    => esc_html__( 'VW Education Pro', 'vw-education-lite' ),
					'pro_text' => esc_html__( 'Upgrade Pro',         'vw-education-lite' ),
					'pro_url'  => esc_url('https://www.vwthemes.com/product/vw-education-theme/')
				)
			)
		);

		$manager->add_section(
			new VW_Education_Lite_Customize_Section_Pro(
				$manager,
				'example_2',
				array(
					'priority'	=> 9,
					'title'    => esc_html__( 'Documentation', 'vw-education-lite' ),
					'pro_text' => esc_html__( 'View Docs',         'vw-education-lite' ),
					'pro_url'  => admin_url( 'themes.php?page=vw_education_lite_guide' )
				)
			)
		);
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