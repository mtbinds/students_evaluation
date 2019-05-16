<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Forminator_Template_Contact_Form
 *
 * @since 1.0
 */
class Forminator_Template_Contact_Form extends Forminator_Template {

	/**
	 * Template defaults
	 *
	 * @since 1.0
	 * @return array
	 */
	public function defaults() {
		return array(
			'id'          => 'contact_form',
			'name'        => __( 'Contact Forms', Forminator::DOMAIN ),
			'description' => __( "A simple contact form for your users to contact you", Forminator::DOMAIN ),
			'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="19" viewBox="0 0 13 19" preserveAspectRatio="none" class="wpmudev-icon wpmudev-i_cforms"><path fill-rule="evenodd" d="M12.916 17.035v-.228.228c0 .305-.105.563-.316.774-.21.21-.47.315-.774.315H1.174c-.305 0-.563-.105-.774-.316-.21-.212-.316-.47-.316-.775V2.287v.21-.227c0-.305.105-.566.316-.783.21-.216.47-.325.774-.325H4.25V.46c0-.095.032-.174.097-.238.064-.065.143-.097.237-.097h3.85c.093 0 .172.032.237.097.065.064.098.143.098.237v.702h3.058c.305 0 .563.11.774.325.21.217.316.478.316.783v14.765zm-2.074-.984V3.237H9.805v.668-.08.08c0 .106-.035.194-.106.264-.07.07-.16.105-.264.105H3.564c-.105 0-.193-.035-.263-.105-.07-.07-.105-.158-.105-.264v-.668H2.14V16.05h8.702zm-6.61-8.77v.544c0 .06-.023.114-.07.167-.047.054-.105.08-.176.08H3.44c-.07 0-.127-.026-.174-.08-.047-.052-.07-.107-.07-.166V7.28c0-.07.023-.13.07-.176.047-.047.105-.07.175-.07h.546c.07 0 .13.023.176.07.047.046.07.105.07.175zm5.573 0v.527c0 .07-.024.13-.07.184-.048.054-.106.08-.176.08H5.532c-.07 0-.13-.026-.176-.08-.046-.052-.07-.113-.07-.183V7.28c0-.07.024-.133.07-.185.047-.053.106-.08.176-.08H9.56c.07 0 .127.027.174.08.047.052.07.114.07.184zM4.232 9.353v.544c0 .07-.023.13-.07.176-.047.047-.105.07-.176.07H3.44c-.057 0-.113-.023-.166-.07-.052-.047-.08-.105-.08-.176v-.544c0-.07.028-.13.08-.176.053-.047.11-.07.167-.07h.546c.07 0 .13.023.176.07.047.047.07.105.07.176zm5.573 0v.544c0 .07-.024.13-.07.176-.048.047-.106.07-.176.07H5.532c-.07 0-.13-.023-.176-.07-.046-.047-.07-.105-.07-.176v-.544c0-.07.024-.13.07-.176.047-.047.106-.07.176-.07H9.56c.07 0 .127.023.174.07.047.047.07.105.07.176zm-5.573 2.074v.545c0 .07-.023.13-.07.175-.047.047-.105.07-.176.07H3.44c-.057 0-.113-.023-.166-.07-.052-.046-.08-.105-.08-.175v-.545c0-.06.028-.115.08-.167.053-.052.11-.078.167-.078h.546c.07 0 .13.026.176.08.047.05.07.107.07.166zm5.573 0v.545c0 .07-.024.13-.07.175-.048.047-.106.07-.176.07H5.532c-.07 0-.13-.023-.176-.07-.046-.046-.07-.105-.07-.175v-.545c0-.06.024-.115.07-.167.047-.052.106-.078.176-.078H9.56c.07 0 .127.026.174.08.047.05.07.107.07.166z"/></svg>',
			'priortiy'    => 1,
		);
	}

	/**
	 * Template fields
	 *
	 * @since 1.0
	 * @return array
	 */
	public function fields() {
		return array(
			array(
				'wrapper_id' => 'wrapper-1511347711918-1669',
				'fields'     => array(
					array(
						'element_id'        => 'name-1',
						'type'              => 'name',
						'cols'              => '12',
						"required"          => "true",
						"field_label"       => __( "First Name", Forminator::DOMAIN ),
						"placeholder"       => __( "E.g. John", Forminator::DOMAIN ),
						"prefix_label"      => __( "Prefix", Forminator::DOMAIN ),
						"fname_label"       => __( "First Name", Forminator::DOMAIN ),
						"fname_placeholder" => __( "E.g. John", Forminator::DOMAIN ),
						"mname_label"       => __( "Middle Name", Forminator::DOMAIN ),
						"mname_placeholder" => __( "E.g. Smith", Forminator::DOMAIN ),
						"lname_label"       => __( "Last Name", Forminator::DOMAIN ),
						"lname_placeholder" => __( "E.g. Doe", Forminator::DOMAIN ),
					),
				),
			),
			array(
				'wrapper_id' => 'wrapper-1511347712118-1739',
				'fields'     => array(
					array(
						'element_id'      => 'email-1',
						'type'            => 'email',
						'cols'            => '12',
						"required"        => "true",
						"field_label"     => __( "Email Address", Forminator::DOMAIN ),
						"placeholder"     => __( "E.g. john@doe.com", Forminator::DOMAIN ),
						"validation"      => true,
						"validation_text" => "",
					),
				),
			),
			array(
				'wrapper_id' => 'wrapper-1311247712118-1194',
				'fields'     => array(
					array(
						'element_id'      => 'phone-1',
						'type'            => 'phone',
						'cols'            => '12',
						"required"        => false,
						"field_label"     => __( "Phone Number", Forminator::DOMAIN ),
						"placeholder"     => __( "E.g. +1 3004005000", Forminator::DOMAIN ),
						"validation"      => true,
						"validation_text" => "",
					),
				),
			),
			array(
				'wrapper_id' => 'wrapper-1988247712118-9871',
				'fields'     => array(
					array(
						'element_id'  => 'textarea-1',
						'type'        => 'textarea',
						'cols'        => '12',
						"required"    => false,
						"field_label" => __( "Message", Forminator::DOMAIN ),
						"placeholder" => __( "Enter your message...", Forminator::DOMAIN ),
						"input_type"  => "paragraph",
						'limit'       => '180',
						'limit_type'  => 'characters',
					),
				),
			),
		);
	}

	/**
	 * Template settings
	 *
	 * @since 1.0
	 * @return array
	 */
	public function settings() {
		return array(
			"submission-behaviour"   => "behaviour-thankyou",
			"thankyou-message"       => __( "Thank you for contacting us, we will be in touch shortly.", Forminator::DOMAIN ),
			'submitData'             => array(
				"custom-submit-text"          => __( "Send Message", Forminator::DOMAIN ),
				"custom-invalid-form-message" => __( "Error: Your form is not valid, please fix the errors!", Forminator::DOMAIN ),
			),
			'enable-ajax'            => 'true',
			'validation-inline'      => true,
			'fields-style'			 => 'open',
			"form-expire"			 => 'no_expire',
			'use-admin-email'        => 'true',
			'admin-email-title'      => __( "New Form Entry #{submission_id} for {form_name}", Forminator::DOMAIN ),
			'admin-email-editor'     => __( "You have a new website form submission: <br/> {all_fields} <br/>---<br/> This message was sent from {site_url}.", Forminator::DOMAIN ),
			'admin-email-recipients' => array(
				get_option( 'admin_email' ),
			),
			'user-email-title'      => __( "Thank you", Forminator::DOMAIN ),
			'user-email-editor'     => __( "Thank you for contacting us, we will be in touch shortly. <br/>---<br/> This message was sent from {site_url}.", Forminator::DOMAIN ),

			// Main container
			'form-padding-top'              => '0',
			'form-padding-right'            => '0',
			'form-padding-bottom'           => '0',
			'form-padding-left'             => '0',
			'form-border-width'             => '0',
			'form-border-style'             => 'none',
			'form-border-radius'            => '0',
			// Typography - Label
			'cform-label-font-family'		=> 'Roboto',
			'cform-label-custom-family'		=> '',
			'cform-label-font-size'			=> '12',
			'cform-label-font-weight'		=> 'bold',
			// Typography - Section Title
			'cform-title-font-family'		=> 'Roboto',
			'cform-title-custom-family'		=> '',
			'cform-title-font-size'			=> '45',
			'cform-title-font-weight'		=> 'normal',
			'cform-title-text-align'		=> 'left',
			// Typography - Section Subtitle
			'cform-subtitle-font-family'	=> 'Roboto',
			'cform-subtitle-custom-font'	=> '',
			'cform-subtitle-font-size'		=> '18',
			'cform-subtitle-font-weight'	=> 'normal',
			'cform-subtitle-text-align'		=> 'left',
			// Typography - Input & Textarea
			'cform-input-font-family'		=> 'Roboto',
			'cform-input-custom-font'		=> '',
			'cform-input-font-size'			=> '16',
			'cform-input-font-weight'		=> 'normal',
			// Typography - Radio & Checkbox
			'cform-radio-font-family'		=> 'Roboto',
			'cform-radio-custom-font'		=> '',
			'cform-radio-font-size'			=> '14',
			'cform-radio-font-weight'		=> 'normal',
			// Typography - Select
			'cform-select-font-family'		=> 'Roboto',
			'cform-select-custom-family'	=> '',
			'cform-select-font-size'		=> '16',
			'cform-select-font-weight'		=> 'normal',
			// Typography - Multi Select
			'cform-multiselect-font-family'	=> 'Roboto',
			'cform-multiselect-custom-font'	=> '',
			'cform-multiselect-font-size'	=> '16',
			'cform-multiselect-font-weight'	=> 'normal',
			// Typography - Dropdown
			'cform-dropdown-font-family'	=> 'Roboto',
			'cform-dropdown-custom-font'	=> '',
			'cform-dropdown-font-size'		=> '16',
			'cform-dropdown-font-weight'	=> 'normal',
			// Typography - Calendar
			'cform-calendar-font-family'	=> 'Roboto',
			'cform-calendar-custom-font'	=> '',
			'cform-calendar-font-size'		=> '13',
			'cform-calendar-font-weight'	=> 'normal',
			// Typography - Buttons
			'cform-button-font-family'		=> 'Roboto',
			'cform-button-custom-font'		=> '',
			'cform-button-font-size'		=> '14',
			'cform-button-font-weight'		=> '500',
			// Typography - Timeline
			'cform-timeline-font-family'	=> 'Roboto',
			'cform-timeline-custom-font'	=> '',
			'cform-timeline-font-size'		=> '12',
			'cform-timeline-font-weight'	=> 'normal',
			// Typography - Pagination
			'cform-pagination-font-family'      => '',
			'cform-pagination-custom-font'      => '',
			'cform-pagination-font-size'        => '16',
			'cform-pagination-font-weight'      => 'normal',
		);
	}
}
