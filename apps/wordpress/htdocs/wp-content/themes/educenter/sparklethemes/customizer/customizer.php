<?php
/**
 * Educenter Theme Customizer
 *
 * @package Educenter
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function educenter_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';


	/**
	 * List All Pages
	*/
	$slider_pages = array();
	$slider_pages_obj = get_pages();
	$slider_pages[''] = esc_html__('Select Page','educenter');
	foreach ($slider_pages_obj as $page) {
	  $slider_pages[$page->ID] = $page->post_title;
	}

	/**
	 * List All Category
	*/
	$categories = get_categories( );
	$educenter_cat = array();
	foreach( $categories as $category ) {
	    $educenter_cat[$category->term_id] = $category->name;
	}
	

	/**
	 * Important Link
	*/
	$wp_customize->add_section('educenter_implink_link_section',array(
		'title' 			=> esc_html__( 'Important Links', 'educenter' ),
		'priority'			=> 2
	));

		$wp_customize->add_setting('educenter_implink_link_options', array(
			'sanitize_callback' => 'sanitize_text_field'
		));

		$wp_customize->add_control( new Educenter_Customize_Control_Info_Text( $wp_customize, 'educenter_implink_link_options', array(
			'settings'		=> 'educenter_implink_link_options',
			'section'		=> 'educenter_implink_link_section',
			'description'	=> '<a class="educenter-implink" href="http://docs.sparklewpthemes.com/educenter/" target="_blank">'.esc_html__('Documentation', 'educenter').'</a><a class="educenter-implink" href="http://demo.sparklewpthemes.com/educenter/" target="_blank">'.esc_html__('Live Demo', 'educenter').'</a><a class="educenter-implink" href="https://sparklewpthemes.com/support/" target="_blank">'.esc_html__('Support Forum', 'educenter').'</a><a class="educenter-implink" href="https://www.facebook.com/sparklewpthemes" target="_blank">'.esc_html__('Like Us in Facebook', 'educenter').'</a>',
		)));

	/**
	 * General Settings Panel
	*/
	$wp_customize->add_panel('educenter_general_settings', array(
	   'priority' => 2,
	   'title' => esc_html__('General Settings', 'educenter')
	));
		
		/**
	     * Logo & Tagline Settings
	    */
		$wp_customize->add_section( 'title_tagline', array(
		     'title' => esc_html__( 'Site Logo/Title/Tagline', 'educenter' ),
		     'panel' => 'educenter_general_settings',
		) );

		/**
	     * Background Settings
	    */
		$wp_customize->add_section( 'background_image', array(
		     'title' => esc_html__( 'Background Image', 'educenter' ),
		     'panel' => 'educenter_general_settings',
		) );


		/**
		 * Themes Color Settings
		*/	
			$wp_customize->get_section('colors' )->title = esc_html__('Themes Colors Settings', 'educenter');
			$wp_customize->get_section('colors' )->priority = 2;

			$wp_customize->add_setting('educenter_primary_color', array(
			    'default' => '#004A8D',
			    'sanitize_callback' => 'sanitize_hex_color',        
			));
			$wp_customize->add_control('educenter_primary_color', array(
			    'type'     => 'color',
			    'label'    => esc_html__('Primary Theme Colors', 'educenter'),
			    'section'  => 'colors',
			    'setting'  => 'educenter_primary_color',
			));
		

		/**
		 * Top Header Settings Panel
		*/
		$wp_customize->add_panel('educenter_top_header_settings', array(
		   'priority' => 3,
		   'title' => esc_html__('Top Header Settings', 'educenter')
		));

			/**
			 * Top Header Quick Contact Information Settings Area 
			*/
			$wp_customize->add_section( 'educenter_header_quickinfo', array(
			    'priority'       => 1,
			    'title'          => esc_html__( 'Quick Contact Information', 'educenter' ),
			    'panel' => 'educenter_top_header_settings',
			) );
			 
				$wp_customize->add_setting('educenter_email_address', array(
					'default' => '',
					'sanitize_callback' => 'sanitize_email',  // done
				));

				$wp_customize->add_control('educenter_email_address',array(
					'type' => 'text',
					'label' => esc_html__('Email Address', 'educenter'),
					'section' => 'educenter_header_quickinfo',
					'setting' => 'educenter_email_address'
				));

				$wp_customize->add_setting('educenter_phone_number', array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',  // done
				));  

				$wp_customize->add_control('educenter_phone_number',array(
					'type' => 'text',
					'label' => esc_html__('Phone Number', 'educenter'),
					'section' => 'educenter_header_quickinfo',
				'setting' => 'educenter_phone_number'
				));

				$wp_customize->add_setting('educenter_map_address', array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',  // done
				));

				$wp_customize->add_control('educenter_map_address',array(
					'type' => 'text',
					'label' => esc_html__('Address', 'educenter'),
					'section' => 'educenter_header_quickinfo',
					'setting' => 'educenter_map_address'
				));

				$wp_customize->add_setting('educenter_opeening_time', array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',  // done
				));

				$wp_customize->add_control('educenter_opeening_time',array(
					'type' => 'text',
					'label' => esc_html__('Opeening Time', 'educenter'),
					'section' => 'educenter_header_quickinfo',
					'setting' => 'educenter_opeening_time'
				));

			/**
			 * Top Header Social Icon Settings Area 
			*/
			$wp_customize->add_section('educenter_social_link_activate_settings', array(
			    'priority' => 2,
			    'title'    => esc_html__('Social Media Link Options', 'educenter'),
			    'panel' => 'educenter_top_header_settings',
			));

			    $educenter_social_links = array( 
			        'educenter_social_facebook' => array(
			            'id' => 'educenter_social_facebook',
			            'title' => esc_html__('Facebook', 'educenter'),
			            'default' => '',
			        ),
			        'educenter_social_twitter' => array(
			            'id' => 'educenter_social_twitter',
			            'title' => esc_html__('Twitter', 'educenter'),
			            'default' => '',
			        ),
			        'educenter_social_googleplus' => array(
			            'id' => 'educenter_social_googleplus',
			            'title' => esc_html__('Google-Plus', 'educenter'),
			            'default' => '',
			        ),
			        'educenter_social_instagram' => array(
			            'id' => 'educenter_social_instagram',
			            'title' => esc_html__('Instagram', 'educenter'),
			            'default' => '',
			        ),
			        'educenter_social_pinterest' => array(
			            'id' => 'educenter_social_pinterest',
			            'title' => esc_html__('Pinterest', 'educenter'),
			            'default' => '',
			        ),
			        'educenter_social_linkedin' => array(
			            'id' => 'educenter_social_linkedin',
			            'title' => esc_html__('Linkedin', 'educenter'),
			            'default' => '',
			        ),
			        'educenter_social_youtube' => array(
			            'id' => 'educenter_social_youtube',
			            'title' => esc_html__('YouTube', 'educenter'),
			            'default' => '',
			        )
			    );

			    $i = 20;
			    foreach($educenter_social_links as $educenter_social_link) {
			        $wp_customize->add_setting($educenter_social_link['id'], array(
			            'default' => $educenter_social_link['default'],
			            'capability' => 'edit_theme_options',
			            'sanitize_callback' => 'esc_url_raw'
			        ));

			        $wp_customize->add_control($educenter_social_link['id'], array(
			            'label' => $educenter_social_link['title'],
			            'section'=> 'educenter_social_link_activate_settings',
			            'settings'=> $educenter_social_link['id'],
			            'priority' => $i
			        ));

			        $i++;
			    }

			/**
			 * Main Header Settings
			*/
			$wp_customize->add_section( 'educenter_main_header', array(
				'title'           => esc_html__('Main Header Settings', 'educenter'),
				'priority'        => 4,
			));

				$wp_customize->add_setting( 'educenter_top_header', array(
					'default'            =>  0,
					'sanitize_callback'  =>  'educenter_enabledisable_sanitize',
				));

				$wp_customize->add_control(new Educenter_Switch_Control( $wp_customize,'educenter_top_header', 
					array(
						'section'       => 'educenter_main_header',
						'label'         =>  esc_html__('Disable Top Header?', 'educenter'),
						'type'          =>  'switch',
						'description'   =>  esc_html__('Choose Options to Disable Top Header','educenter'),
						'output'        =>  array('Enable', 'Disable')
					)
				));


				$wp_customize->add_setting( 'educenter_main_header_sticky', array(
					'default'            =>  0,
					'sanitize_callback'  =>  'educenter_enabledisable_sanitize',
				));

				$wp_customize->add_control(new Educenter_Switch_Control( $wp_customize,'educenter_main_header_sticky', 
					array(
						'section'       => 'educenter_main_header',
						'label'         =>  esc_html__('Disable Sticky Menu?', 'educenter'),
						'type'          =>  'switch',
						'description'   =>  esc_html__('Choose Options to Disable Sticky Menu','educenter'),
						'output'        =>  array('Enable', 'Disable')
					)
				));

				$wp_customize->add_setting( 'educenter_sidebar_sticky', array(
					'default'            =>  1,
					'sanitize_callback'  =>  'educenter_enabledisable_sanitize',
				));

				$wp_customize->add_control(new Educenter_Switch_Control( $wp_customize,'educenter_sidebar_sticky', 
					array(
						'section'       => 'educenter_main_header',
						'label'         =>  esc_html__('Disable Sidebar Sticky?', 'educenter'),
						'type'          =>  'switch',
						'output'        =>  array('Enable', 'Disable')
					)
				));


			/**
			 * Banner Slider
			*/
			$wp_customize->add_section( 'educenter_banner_slider', array(
				'title'           => esc_html__('Main Banner Slider Settings', 'educenter'),
				'priority'        => 4,
			));

				$wp_customize->add_setting( 'educenter_slider_options', array(
					'default'            =>  1,
					'sanitize_callback'  =>  'educenter_enabledisable_sanitize',
				));

				$wp_customize->add_control(new Educenter_Switch_Control( $wp_customize,'educenter_slider_options', 
					array(
						'section'       => 'educenter_banner_slider',
						'label'         =>  esc_html__('Choose Enable/Disable Slider', 'educenter'),
						'type'          =>  'switch',
						'description'   =>  esc_html__('Choose Options to Disable Sticky Menu','educenter'),
						'output'        =>  array('Enable', 'Disable')
					)
				));

			    /**
			     * Slider Settings Area
			    */
		        $wp_customize->add_setting( 'educenter_banner_all_sliders', array(
		          'sanitize_callback' => 'educenter_sanitize_repeater',
		          'default' => json_encode( array(
		            array(
		                  'top_title' => '',
		                  'slider_page' => '',
		                  'button_text' => '',
		                  'button_url' => ''
		                )
		            ) )        
		        ));

		        $wp_customize->add_control( new Educenter_Repeater_Controler( $wp_customize, 'educenter_banner_all_sliders', array(
		          'label'   => esc_html__('Slider Settings Area','educenter'),
		          'section' => 'educenter_banner_slider',
		          'settings' => 'educenter_banner_all_sliders',
		          'educenter_box_label' => esc_html__('Slider Settings Options','educenter'),
		          'educenter_box_add_control' => esc_html__('Add New Slider','educenter'),
		        ),
		        array(
		        	
		        	'slider_page' => array(
						'type'      => 'select',
						'label'     => esc_html__( 'Select Slider Page', 'educenter' ),
						'options'   => $slider_pages
					),
					'button_text' => array(
						'type'      => 'text',
						'label'     => esc_html__( 'Enter Button Text', 'educenter' ),
						'default'   => ''
					),
					'button_url' => array(
						'type'      => 'text',
						'label'     => esc_html__( 'Enter Button Url', 'educenter' ),
						'default'   => ''
					)	          
		        )));


		/**
		 * Header Settings
		*/
		$wp_customize->get_section('header_image')->title = esc_html__( 'Inner Page Background Images', 'educenter' );
		$wp_customize->get_section('header_image' )->priority = 5;


		/**
		 * HomePage Settings Panel
		*/
		$wp_customize->add_panel('educenter_homepage_settings', array(
		   'priority' => 5,
		   'title' => esc_html__('HomePage Block Section Area', 'educenter')
		));

			/**
			 * Front Page Active Area
			*/
			$wp_customize->add_section( 'educenter_frontpage_settings', array(
				'title'           => esc_html__('Enable Front Page', 'educenter'),
				'priority'        => 1,
				'panel'			  => 'educenter_homepage_settings'
			));

				$wp_customize->add_setting( 'educenter_set_frontpage', array(
					'sanitize_callback' => 'sanitize_text_field',
					'default' => false
				));

				$wp_customize->add_control( 'educenter_set_frontpage', array(
					'type' => 'checkbox',
					'label' => esc_html__( 'Enable Front Page','educenter' ),
					'section' => 'educenter_frontpage_settings'
				));

			/**
			 * Features Services Area
			*/
			$wp_customize->add_section( 'educenter_fservices_settings', array(
				'title'           => esc_html__('Features Services Settings', 'educenter'),
				'priority'        => 1,
				'panel'			  => 'educenter_homepage_settings'
			));

				$wp_customize->add_setting( 'educenter_fservices_area_options', array(
					'default'            =>  0,
					'sanitize_callback'  =>  'educenter_enabledisable_sanitize',
				));

				$wp_customize->add_control(new Educenter_Switch_Control( $wp_customize,'educenter_fservices_area_options', 
					array(
						'section'       => 'educenter_fservices_settings',
						'label'         =>  esc_html__('Choose Enable/Disable Section', 'educenter'),
						'type'          =>  'switch',
						'description'   =>  esc_html__('Choose Options to Disable Featues Section','educenter'),
						'output'        =>  array('Enable', 'Disable')
					)
				));


				$wp_customize->add_setting('educenter_fservices_section_title', array(
				    'default'       =>      '',
				    'sanitize_callback' => 'sanitize_text_field'
				));

				$wp_customize->add_control('educenter_fservices_section_title', array(
				    'section'    => 'educenter_fservices_settings',
				    'label'      => esc_html__('Enter Features Services Title', 'educenter'),
				    'type'       => 'text'  
				));

				$wp_customize->add_setting('educenter_fservices_section_subtitle', array(
				    'default'       =>      '',
				    'sanitize_callback' => 'sanitize_text_field'
				));

				$wp_customize->add_control('educenter_fservices_section_subtitle', array(
				    'section'    => 'educenter_fservices_settings',
				    'label'      => esc_html__('Enter Features Services Sub Title', 'educenter'),
				    'type'       => 'text'  
				));

			    /**
			     * Feature Services Settings Area
			    */
		        $wp_customize->add_setting( 'educenter_fservices_area_settings', array(
		          'sanitize_callback' => 'educenter_sanitize_repeater',
		          'default' => json_encode( array(
		            array(
		            	  'services_icon' => 'fa fa-desktop',
		                  'services_page' => '' 
		                )
		            ) )        
		        ));

		        $wp_customize->add_control( new Educenter_Repeater_Controler( $wp_customize, 'educenter_fservices_area_settings', array(
		          'label'   => esc_html__('Features Services Settings Area','educenter'),
		          'section' => 'educenter_fservices_settings',
		          'settings' => 'educenter_fservices_area_settings',
		          'educenter_box_label' => esc_html__('Features Services','educenter'),
		          'educenter_box_add_control' => esc_html__('Add New Services','educenter'),
		        ),
		        array(
					'services_icon' => array(
						'type'      => 'icon',
						'label'     => esc_html__( 'Select Services Icon', 'educenter' ),
						'default'   => 'fa fa-desktop'
					),
					'services_page' => array(
						'type'      => 'select',
						'label'     => esc_html__( 'Select Services Page', 'educenter' ),
						'options'   => $slider_pages
					)          
		        )));


		    /**
			 * About Secton Area
			*/
			$wp_customize->add_section( 'educenter_aboutus_settings', array(
				'title'           => esc_html__('About Us Section Settings', 'educenter'),
				'priority'        => 2,
				'panel'			  => 'educenter_homepage_settings'
			));

				$wp_customize->add_setting( 'educenter_aboutus_section_area_options', array(
					'default'            =>  1,
					'sanitize_callback'  =>  'educenter_enabledisable_sanitize',
				));

				$wp_customize->add_control(new Educenter_Switch_Control( $wp_customize,'educenter_aboutus_section_area_options', 
					array(
						'section'       => 'educenter_aboutus_settings',
						'label'         =>  esc_html__('Choose Enable/Disable Section', 'educenter'),
						'type'          =>  'switch',
						'description'   =>  esc_html__('Choose Options to Disable About Us Section','educenter'),
						'output'        =>  array('Enable', 'Disable')
					)
				));


				$wp_customize->add_setting('educenter_aboutus_main_title', array(
				    'default'       =>   '',
				    'sanitize_callback' => 'sanitize_text_field'
				));

				$wp_customize->add_control('educenter_aboutus_main_title', array(
				    'section'    => 'educenter_aboutus_settings',
				    'label'      => esc_html__('Enter About Us Main Title', 'educenter'),
				    'type'       => 'text'  
				));

				$wp_customize->add_setting('educenter_aboutus_main_subtitle', array(
				    'default'       =>  '',
				    'sanitize_callback' => 'sanitize_text_field'
				));

				$wp_customize->add_control('educenter_aboutus_main_subtitle', array(
				    'section'    => 'educenter_aboutus_settings',
				    'label'      => esc_html__('Enter About Us Sub Title', 'educenter'),
				    'type'       => 'text'  
				));


				$wp_customize->add_setting( 'educenter_aboutus_page_features_image', array(
	    		    'default'       =>      '',
	    		    'sanitize_callback' => 'esc_url_raw'
	    		));
	    		
	    		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'educenter_aboutus_page_features_image', array(
	    		    'section'       => 'educenter_aboutus_settings',
	    		    'label'         => esc_html__('Upload About Us Features Image', 'educenter'),
	    		    'type'          => 'image',
	    		)));

			    /**
			     * About Us Pages Area
			    */
		        $wp_customize->add_setting( 'educenter_aboutus_area_settings', array(
		          'sanitize_callback' => 'educenter_sanitize_repeater',
		          'default' => json_encode( array(
		            array(
		            	  'about_icon' => 'fa fa-desktop',
		                  'about_page' => 0, 
		                )
		            ) )        
		        ));

		        $wp_customize->add_control( new Educenter_Repeater_Controler( $wp_customize, 'educenter_aboutus_area_settings', array(
						'label'   => esc_html__('About Us Settings Area','educenter'),
						'section' => 'educenter_aboutus_settings',
						'settings' => 'educenter_aboutus_area_settings',
						'educenter_box_label' => esc_html__('About US Plan Pages','educenter'),
						'educenter_box_add_control' => esc_html__('Add New Page','educenter'),
			        ),
			        array(
						'about_icon' => array(
							'type'      => 'icon',
							'label'     => esc_html__( 'Select Icon', 'educenter' ),
							'default'   => 'fa fa-desktop'
						),
						'about_page' => array(
							'type'      => 'select',
							'label'     => esc_html__( 'Select Page', 'educenter' ),
							'options'   => $slider_pages
						)          
			        ) ) );

		    /**
			 * Call To Action
			*/
			$wp_customize->add_section( 'educenter_cta_settings', array(
				'title'           => esc_html__('Call To Action', 'educenter'),
				'priority'        => 3,
				'panel'			  => 'educenter_homepage_settings'
			));


				$wp_customize->add_setting( 'educenter_cta_area_options', array(
					'default'            =>  1,
					'sanitize_callback'  =>  'educenter_enabledisable_sanitize',
				));

				$wp_customize->add_control(new Educenter_Switch_Control( $wp_customize,'educenter_cta_area_options', 
					array(
						'section'       => 'educenter_cta_settings',
						'label'         =>  esc_html__('Choose Enable/Disable Section', 'educenter'),
						'type'          =>  'switch',
						'description'   =>  esc_html__('Choose Options to Disable Call To Action Section','educenter'),
						'output'        =>  array('Enable', 'Disable')
					)
				));


				$wp_customize->add_setting( 'educenter_cta_pageid', array(
					'sanitize_callback' => 'absint',
				) );

				$wp_customize->add_control( 'educenter_cta_pageid', array(
					'type' => 'dropdown-pages',
					'section' => 'educenter_cta_settings',
					'label' => esc_html__( 'Select Call To Action Pages','educenter' )
				) );
		

				$wp_customize->add_setting('educenter_cta_button_text', array(
				    'default'       =>      '',
				    'sanitize_callback' => 'sanitize_text_field'
				));

				$wp_customize->add_control('educenter_cta_button_text', array(
				    'section'    => 'educenter_cta_settings',
				    'label'      => esc_html__('Enter Button Text', 'educenter'),
				    'type'       => 'text'  
				));

				$wp_customize->add_setting('educenter_cta_button_url', array(
				    'default'       =>      '',
				    'sanitize_callback' => 'esc_url_raw'
				));

				$wp_customize->add_control('educenter_cta_button_url', array(
				    'section'    => 'educenter_cta_settings',
				    'label'      => esc_html__('Enter Button URL', 'educenter'),
				    'type'       => 'url'  
				));

		    /**
			 * Services Area
			*/
			$wp_customize->add_section( 'educenter_services_settings', array(
				'title'           => esc_html__('Services Settings', 'educenter'),
				'priority'        => 4,
				'panel'			  => 'educenter_homepage_settings'
			));

				$wp_customize->add_setting( 'educenter_services_area_options', array(
					'default'            =>  1,
					'sanitize_callback'  =>  'educenter_enabledisable_sanitize',
				));

				$wp_customize->add_control(new Educenter_Switch_Control( $wp_customize,'educenter_services_area_options', 
					array(
						'section'       => 'educenter_services_settings',
						'label'         =>  esc_html__('Choose Enable/Disable Section', 'educenter'),
						'type'          =>  'switch',
						'description'   =>  esc_html__('Choose Options to Disable Services','educenter'),
						'output'        =>  array('Enable', 'Disable')
					)
				));


				$wp_customize->add_setting('educenter_services_main_title', array(
				    'default'       =>   '',
				    'sanitize_callback' => 'sanitize_text_field'
				));

				$wp_customize->add_control('educenter_services_main_title', array(
				    'section'    => 'educenter_services_settings',
				    'label'      => esc_html__('Enter Services Main Title', 'educenter'),
				    'type'       => 'text'  
				));

				$wp_customize->add_setting('educenter_services_main_subtitle', array(
				    'default'       =>  '',
				    'sanitize_callback' => 'sanitize_text_field'
				));

				$wp_customize->add_control('educenter_services_main_subtitle', array(
				    'section'    => 'educenter_services_settings',
				    'label'      => esc_html__('Enter Services Sub Title', 'educenter'),
				    'type'       => 'text'  
				));

				/**
			     * Services Settings Area
			    */
		        $wp_customize->add_setting( 'educenter_services_area_settings', array(
		          'sanitize_callback' => 'educenter_sanitize_repeater',
		          'default' => json_encode( array(
		            array(
		            	  'services_icon' => 'fa fa-desktop',
		                  'services_page' => '' 
		                )
		            ) )        
		        ));

		        $wp_customize->add_control( new Educenter_Repeater_Controler( $wp_customize, 'educenter_services_area_settings', array(
		          'label'   => esc_html__('Services Settings Area','educenter'),
		          'section' => 'educenter_services_settings',
		          'settings' => 'educenter_services_area_settings',
		          'educenter_box_label' => esc_html__('Main Services','educenter'),
		          'educenter_box_add_control' => esc_html__('Add New Services','educenter'),
		        ),
		        array(
					'services_icon' => array(
						'type'      => 'icon',
						'label'     => esc_html__( 'Select Services Icon', 'educenter' ),
						'default'   => 'fa fa-desktop'
					),
					'services_page' => array(
						'type'      => 'select',
						'label'     => esc_html__( 'Select Services Page', 'educenter' ),
						'options'   => $slider_pages
					)          
		        )));

		    /**
			 * Courses Section
			*/
			$wp_customize->add_section( 'educenter_courses_settings', array(
				'title'           => esc_html__('Courses Section Settings', 'educenter'),
				'priority'        => 6,
				'panel'			  => 'educenter_homepage_settings'
			));

				$wp_customize->add_setting( 'educenter_courses_section_area_options', array(
					'default'            =>  1,
					'sanitize_callback'  =>  'educenter_enabledisable_sanitize',
				));

				$wp_customize->add_control(new Educenter_Switch_Control( $wp_customize,'educenter_courses_section_area_options', 
					array(
						'section'       => 'educenter_courses_settings',
						'label'         =>  esc_html__('Choose Enable/Disable Section', 'educenter'),
						'type'          =>  'switch',
						'description'   =>  esc_html__('Choose Options to Disable Courses Section','educenter'),
						'output'        =>  array('Enable', 'Disable')
					)
				));


				$wp_customize->add_setting('educenter_courses_section_title', array(
				    'default'       =>      '',
				    'sanitize_callback' => 'sanitize_text_field'
				));

				$wp_customize->add_control('educenter_courses_section_title', array(
				    'section'    => 'educenter_courses_settings',
				    'label'      => esc_html__('Enter Courses Main Title', 'educenter'),
				    'type'       => 'text'  
				));

				$wp_customize->add_setting('educenter_courses_section_subtitle', array(
				    'default'       =>      '',
				    'sanitize_callback' => 'sanitize_text_field'
				));

				$wp_customize->add_control('educenter_courses_section_subtitle', array(
				    'section'    => 'educenter_courses_settings',
				    'label'      => esc_html__('Enter Courses Main Sub Title', 'educenter'),
				    'type'       => 'text'  
				));

			    /**
			     * Course Section Settings
			    */
		        $wp_customize->add_setting( 'educenter_course_area_settings', array(
		          'sanitize_callback' => 'educenter_sanitize_repeater',
		          'default' => json_encode( array(
		            array(
		                  'course_page' => '',
		                  'course_price' => '' 
		                )
		            ) )        
		        ));

		        $wp_customize->add_control( new Educenter_Repeater_Controler( $wp_customize, 'educenter_course_area_settings', array(
					'label'   => esc_html__('Course Settings Area','educenter'),
					'section' => 'educenter_courses_settings',
					'settings' => 'educenter_course_area_settings',
					'educenter_box_label' => esc_html__('Course settings Area','educenter'),
					'educenter_box_add_control' => esc_html__('Add New Course','educenter'),
		        ),
		        array(
					'course_page' => array(
						'type'      => 'select',
						'label'     => esc_html__( 'Select Courses Page', 'educenter' ),
						'options'   => $slider_pages
					),
					'course_price' => array(
						'type'      => 'text',
						'label'     => esc_html__( 'Enter Course Price', 'educenter' ),
						'default'   => ''
					),      
		        )));



		    /**
			 * Gallery Section
			*/
			$wp_customize->add_section( 'educenter_gallery_settings', array(
				'title'           => esc_html__('Gallery Section Settings', 'educenter'),
				'priority'        => 7,
				'panel'			  => 'educenter_homepage_settings'
			));

				$wp_customize->add_setting( 'educenter_gallery_area_options', array(
					'default'            =>  1,
					'sanitize_callback'  =>  'educenter_enabledisable_sanitize',
				));

				$wp_customize->add_control(new Educenter_Switch_Control( $wp_customize,'educenter_gallery_area_options', 
					array(
						'section'       => 'educenter_gallery_settings',
						'label'         =>  esc_html__('Choose Enable/Disable Section', 'educenter'),
						'type'          =>  'switch',
						'description'   =>  esc_html__('Choose Options to Disable Gallery Section','educenter'),
						'output'        =>  array('Enable', 'Disable')
					)
				));


				$wp_customize->add_setting('educenter_gallery_section_title', array(
				    'default'       =>      '',
				    'sanitize_callback' => 'sanitize_text_field'
				));

				$wp_customize->add_control('educenter_gallery_section_title', array(
				    'section'    => 'educenter_gallery_settings',
				    'label'      => esc_html__('Enter Gallery Main Title', 'educenter'),
				    'type'       => 'text'  
				));

				$wp_customize->add_setting('educenter_gallery_section_subtitle', array(
				    'default'       =>      '',
				    'sanitize_callback' => 'sanitize_text_field'
				));

				$wp_customize->add_control('educenter_gallery_section_subtitle', array(
				    'section'    => 'educenter_gallery_settings',
				    'label'      => esc_html__('Enter Gallery Main SubTitle', 'educenter'),
				    'type'       => 'text'  
				));

				$wp_customize->add_setting( 'educenter_gallery_image', array(
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field' // Done
				) );

				$wp_customize->add_control( new Educenter_Display_Gallery_Control( $wp_customize, 'educenter_gallery_image', array(
					'settings'		=> 'educenter_gallery_image',
					'section'		=> 'educenter_gallery_settings',
					'label'			=> esc_html__( 'Upload Gallery Images', 'educenter' ),
				)));


		    /**
			 * Counter Secton Area
			*/
			$wp_customize->add_section( 'educenter_counter_settings', array(
				'title'           => esc_html__('Counter Section Settings', 'educenter'),
				'priority'        => 8,
				'panel'			  => 'educenter_homepage_settings'
			));

				$wp_customize->add_setting( 'educenter_counter_section_area_options', array(
					'default'            =>  1,
					'sanitize_callback'  =>  'educenter_enabledisable_sanitize',
				));

				$wp_customize->add_control(new Educenter_Switch_Control( $wp_customize,'educenter_counter_section_area_options', 
					array(
						'section'       => 'educenter_counter_settings',
						'label'         =>  esc_html__('Choose Enable/Disable Section', 'educenter'),
						'type'          =>  'switch',
						'description'   =>  esc_html__('Choose Options to Disable Counter Section','educenter'),
						'output'        =>  array('Enable', 'Disable')
					)
				));


				$wp_customize->add_setting( 'educenter_counter_bg_image', array(
	    		    'default'       =>      '',
	    		    'sanitize_callback' => 'esc_url_raw'
	    		));
	    		
	    		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'educenter_counter_bg_image', array(
	    		    'section'       => 'educenter_counter_settings',
	    		    'label'         => esc_html__('Upload Counter BG Image', 'educenter'),
	    		    'type'          => 'image',
	    		)));

			    /**
			     * Counter Details
			    */
		        $wp_customize->add_setting( 'educenter_counter_area_settings', array(
		          'sanitize_callback' => 'educenter_sanitize_repeater',
		          'default' => json_encode( array(
		            array(
		            	  'counter_icon' => 'fa fa-desktop',
		            	  'counter_number' => '',
		                  'counter_title' => '' 
		                )
		            ) )        
		        ));

		        $wp_customize->add_control( new Educenter_Repeater_Controler( $wp_customize, 'educenter_counter_area_settings', array(
		          'label'   => esc_html__('Counter Settings Area','educenter'),
		          'section' => 'educenter_counter_settings',
		          'settings' => 'educenter_counter_area_settings',
		          'educenter_box_label' => esc_html__('Counter Settings Area','educenter'),
		          'educenter_box_add_control' => esc_html__('Add New Counter','educenter'),
		        ),
		        array(
					'counter_icon' => array(
						'type'      => 'icon',
						'label'     => esc_html__( 'Select Counter Icon', 'educenter' ),
						'default'   => 'fa fa-desktop'
					),
					'counter_number' => array(
						'type'      => 'text',
						'label'     => esc_html__( 'Enter Counter Number', 'educenter' ),
						'default'   => ''
					),
					'counter_title' => array(
						'type'      => 'text',
						'label'     => esc_html__( 'Enter Counter Title', 'educenter' ),
						'default'   => ''
					)         
		        )));	    


			/**
			 * Our Team Member Area
			*/
			$wp_customize->add_section( 'educenter_team_settings', array(
				'title'           => esc_html__('Our Team Settings', 'educenter'),
				'priority'        => 9,
				'panel'			  => 'educenter_homepage_settings'
			));


				$wp_customize->add_setting( 'educenter_team_area_options', array(
					'default'            =>  1,
					'sanitize_callback'  =>  'educenter_enabledisable_sanitize',
				));

				$wp_customize->add_control(new Educenter_Switch_Control( $wp_customize,'educenter_team_area_options', 
					array(
						'section'       => 'educenter_team_settings',
						'label'         =>  esc_html__('Choose Enable/Disable Section', 'educenter'),
						'type'          =>  'switch',
						'description'   =>  esc_html__('Choose Options to Disable Team Section','educenter'),
						'output'        =>  array('Enable', 'Disable')
					)
				));

				$wp_customize->add_setting('educenter_team_area_title', array(
				    'default'       =>      '',
				    'sanitize_callback' => 'sanitize_text_field'
				));

				$wp_customize->add_control('educenter_team_area_title', array(
				    'section'    => 'educenter_team_settings',
				    'label'      => esc_html__('Enter Team Title', 'educenter'),
				    'type'       => 'text'  
				));

				$wp_customize->add_setting('educenter_team_area_subtitle', array(
				    'default'       =>      '',
				    'sanitize_callback' => 'sanitize_text_field'
				));

				$wp_customize->add_control('educenter_team_area_subtitle', array(
				    'section'    => 'educenter_team_settings',
				    'label'      => esc_html__('Enter Team Sub Title', 'educenter'),
				    'type'       => 'text'  
				));

			    /**
			     * Team Settings Area
			    */
		        $wp_customize->add_setting( 'educenter_team_area_settings', array(
		          'sanitize_callback' => 'educenter_sanitize_repeater',
		          'default' => json_encode( array(
		            array(
		            	  'team_page' => '',
		                  'team_position' => ''
		                )
		            ) )        
		        ));

		        $wp_customize->add_control( new Educenter_Repeater_Controler( $wp_customize, 'educenter_team_area_settings', array(
		          'label'   => esc_html__('Team Settings Area','educenter'),
		          'section' => 'educenter_team_settings',
		          'settings' => 'educenter_team_area_settings',
		          'educenter_box_label' => esc_html__('Our Team Settings','educenter'),
		          'educenter_box_add_control' => esc_html__('Add New Team','educenter'),
		        ),
		        array(
					'team_page' => array(
						'type'      => 'select',
						'label'     => esc_html__( 'Select Team Page', 'educenter' ),
						'options'   => $slider_pages
					),
					'team_position' => array(
						'type'      => 'text',
						'label'     => esc_html__( 'Enter Member Position', 'educenter' ),
						'default'   => ''
					)       
		        )));


	    	/**
	    	 * Testimonial Area
	    	*/
	    	$wp_customize->add_section( 'educenter_testimonial_settings', array(
	    		'title'           => esc_html__('Our Testimonial Settings', 'educenter'),
	    		'priority'        => 10,
	    		'panel'			  => 'educenter_homepage_settings'
	    	));
	    		
	    		$wp_customize->add_setting( 'educenter_testimonial_area_options', array(
	    			'default'            =>  1,
	    			'sanitize_callback'  =>  'educenter_enabledisable_sanitize',
	    		));

	    		$wp_customize->add_control(new Educenter_Switch_Control( $wp_customize,'educenter_testimonial_area_options', 
	    			array(
	    				'section'       => 'educenter_testimonial_settings',
	    				'label'         =>  esc_html__('Choose Enable/Disable Section', 'educenter'),
	    				'type'          =>  'switch',
	    				'description'   =>  esc_html__('Choose Options to Disable Testimonial Section','educenter'),
	    				'output'        =>  array('Enable', 'Disable')
	    			)
	    		));

	    		$wp_customize->add_setting('educenter_testimonial_title', array(
	    		    'default'       =>  '',
	    		    'sanitize_callback' => 'sanitize_text_field'
	    		));

	    		$wp_customize->add_control('educenter_testimonial_title', array(
	    		    'section'    => 'educenter_testimonial_settings',
	    		    'label'      => esc_html__('Enter Testimonial Title', 'educenter'),
	    		    'type'       => 'text'  
	    		));

	    		$wp_customize->add_setting('educenter_testimonial_subtitle', array(
				    'default'       =>      '',
				    'sanitize_callback' => 'sanitize_text_field'
				));

				$wp_customize->add_control('educenter_testimonial_subtitle', array(
				    'section'    => 'educenter_testimonial_settings',
				    'label'      => esc_html__('Enter Testimonial Sub Title', 'educenter'),
				    'type'       => 'text'  
				));


	    	    /**
	    	     * Testimonial Settings Area
	    	    */
	            $wp_customize->add_setting( 'educenter_testimonial_area_settings', array(
	              'sanitize_callback' => 'educenter_sanitize_repeater',
	              'default' => json_encode( array(
	                array(
	                      'testimonial_page' => ''
	                    )
	                ) )        
	            ));

	            $wp_customize->add_control( new Educenter_Repeater_Controler( $wp_customize, 'educenter_testimonial_area_settings', array(
	              'label'   => esc_html__('Testimonial Settings Area','educenter'),
	              'section' => 'educenter_testimonial_settings',
	              'settings' => 'educenter_testimonial_area_settings',
	              'educenter_box_label' => esc_html__('Testimonial Settings','educenter'),
	              'educenter_box_add_control' => esc_html__('Add New Testimonial','educenter'),
	            ),
	            array(
	    			'testimonial_page' => array(
	    				'type'      => 'select',
	    				'label'     => esc_html__( 'Select Testimonial Page', 'educenter' ),
	    				'options'   => $slider_pages
	    			)         
	            )));


			/**
			 * Our Blogs Area
			*/
			$wp_customize->add_section( 'educenter_blog_settings', array(
				'title'           => esc_html__('Our Blogs Settings', 'educenter'),
				'priority'        => 11,
				'panel'			  => 'educenter_homepage_settings'
			));


				$wp_customize->add_setting( 'educenter_blog_area_options', array(
					'default'            =>  1,
					'sanitize_callback'  =>  'educenter_enabledisable_sanitize',
				));

				$wp_customize->add_control(new Educenter_Switch_Control( $wp_customize,'educenter_blog_area_options', 
					array(
						'section'       => 'educenter_blog_settings',
						'label'         =>  esc_html__('Choose Enable/Disable Section', 'educenter'),
						'type'          =>  'switch',
						'description'   =>  esc_html__('Choose Options to Disable Blog Section','educenter'),
						'output'        =>  array('Enable', 'Disable')
					)
				));

				$wp_customize->add_setting('educenter_blog_title', array(
				    'default'       =>      '',
				    'sanitize_callback' => 'sanitize_text_field'
				));

				$wp_customize->add_control('educenter_blog_title', array(
				    'section'    => 'educenter_blog_settings',
				    'label'      => esc_html__('Enter Blog Title', 'educenter'),
				    'type'       => 'text'  
				));


				$wp_customize->add_setting('educenter_blog_subtitle', array(
				    'default'       =>      '',
				    'sanitize_callback' => 'sanitize_text_field'
				));

				$wp_customize->add_control('educenter_blog_subtitle', array(
				    'section'    => 'educenter_blog_settings',
				    'label'      => esc_html__('Enter Blog Sub Title', 'educenter'),
				    'type'       => 'text'  
				));


				$wp_customize->add_setting( 'educenter_blog_area_term_id', array(
					'default'			=> '',
					'sanitize_callback' => 'sanitize_text_field'
				) );
				
				$wp_customize->add_control( new Educenter_Customize_Control_Checkbox_Multiple( $wp_customize, 'educenter_blog_area_term_id', array(
			        'label' => esc_html__( 'Select Blog Cateogry', 'educenter' ),
			        'section' => 'educenter_blog_settings',
			        'settings' => 'educenter_blog_area_term_id',
			        'choices' => $educenter_cat
			    ) ) );

	    /**
		 * Section Reorder
		*/
		$wp_customize->add_section( 'educenter_homepage_section_reorder', array(
		    'title'		=> esc_html__( 'FrontPage Section Re Order', 'educenter' ),
		    'priority'  => 5,
		) );
		
		$wp_customize->add_setting( 'educenter_homepage_section_order_list', array(
		    'default' => '',
		    'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_control( new Educenter_Section_Re_Order( $wp_customize, 'educenter_homepage_section_order_list', array(
		    'type' => 'dragndrop',
		    'priority'  => 3,
		    'label' => esc_html__( 'FrontPage Section Re Order', 'educenter' ),
		    'section' => 'educenter_homepage_section_reorder',
			    'choices'   => array(
			        'features'  	=> esc_html__( 'Features Services', 'educenter' ),
			        'aboutus'  		=> esc_html__( 'About Us', 'educenter' ),
			        'cta'           => esc_html__( 'Call To Action', 'educenter' ),
			        'services'      => esc_html__( 'Services Section', 'educenter' ),
			        'counter'       => esc_html__( 'Counter Section', 'educenter' ),
			        'courses'      	=> esc_html__( 'Courses Section', 'educenter' ),
			        'ourteam'    	=> esc_html__( 'Our Team Member', 'educenter' ),
			        'gallery'       => esc_html__( 'Gallery Section', 'educenter' ),
			        'testimonial'  	=> esc_html__( 'Testimonial Area', 'educenter' ),
			        'ourblog'   	=> esc_html__( 'Our Blogs', 'educenter' )
			    ),
		) ) );
	

		/**
		 * Switch(Enable/Diable) Sanitization Function
		*/
		function educenter_enabledisable_sanitize($input) {
		    if ( $input == 1 ) {
		        return 1;
		    } else {
		        return '';
		    }
		}


		/**
		 * Repeat Fields Sanitization
		*/
		function educenter_sanitize_repeater($input){        
		  $input_decoded = json_decode( $input, true );
		  $allowed_html = array(
		    'br' => array(),
		    'em' => array(),
		    'strong' => array(),
		    'a' => array(
		      'href' => array(),
		      'class' => array(),
		      'id' => array(),
		      'target' => array()
		    ),
		    'button' => array(
		      'class' => array(),
		      'id' => array()
		    )
		  ); 

		  if(!empty($input_decoded)) {
		    foreach ($input_decoded as $boxes => $box ){
		      foreach ($box as $key => $value){
		        $input_decoded[$boxes][$key] = sanitize_text_field( $value );
		      }
		    }
		    return json_encode($input_decoded);
		  }      
		  return $input;
		}

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'educenter_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'educenter_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'educenter_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function educenter_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function educenter_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function educenter_customize_preview_js() {
	wp_enqueue_script( 'educenter-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'educenter_customize_preview_js' );
