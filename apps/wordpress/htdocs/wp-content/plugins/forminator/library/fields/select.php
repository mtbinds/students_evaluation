<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Forminator_SingleValue
 *
 * @property  array field
 * @since 1.0
 */
class Forminator_Select extends Forminator_Field {

	/**
	 * @var string
	 */
	public $name = '';

	/**
	 * @var string
	 */
	public $slug = 'select';

	/**
	 * @var string
	 */
	public $type = 'select';

	/**
	 * @var int
	 */
	public $position = 11;

	/**
	 * @var array
	 */
	public $options = array();

	/**
	 * @var string
	 */
	public $category = 'standard';

	/**
	 * @var string
	 */
	public $icon = 'sui-icon-element-select';

	/**
	 * Forminator_SingleValue constructor.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		parent::__construct();

		$this->name = __( 'Select', Forminator::DOMAIN );
	}

	/**
	 * Field defaults
	 *
	 * @since 1.0
	 * @return array
	 */
	public function defaults() {
		return array(
			'value_type'  => 'single',
			'field_label' => __( 'Select', Forminator::DOMAIN ),
			'options'     => array(
				array(
					'label' => __( 'Option 1', Forminator::DOMAIN ),
					'value' => 'one',
				),
				array(
					'label' => __( 'Option 2', Forminator::DOMAIN ),
					'value' => 'two',
				),
			),
		);
	}

	/**
	 * Autofill Setting
	 *
	 * @since 1.0.5
	 *
	 * @param array $settings
	 *
	 * @return array
	 */
	public function autofill_settings( $settings = array() ) {
		$providers = apply_filters( 'forminator_field_' . $this->slug . '_autofill', array(), $this->slug );

		$autofill_settings = array(
			'select' => array(
				'values' => forminator_build_autofill_providers( $providers ),
			),
		);

		return $autofill_settings;
	}

	/**
	 * Field front-end markup
	 *
	 * @since 1.0
	 *
	 * @param $field
	 * @param $settings
	 *
	 * @return mixed
	 */
	public function markup( $field, $settings = array() ) {
		$this->field = $field;
		$i           = 1;
		$html        = '';
		$id          = self::get_property( 'element_id', $field );
		$name        = $id;
		$id          = $id . '-field';
		$required    = self::get_property( 'required', $field, false, 'bool' );
		$options     = self::get_property( 'options', $field, array() );
		$post_value  = self::get_post_data( $name, false );
		$uniq_id     = uniqid();
		$description = self::get_property( 'description', $field, '' );
		$label       = self::get_property( 'field_label', $field, '' );
		$design      = $this->get_form_style( $settings );
		$field_type  = self::get_property( 'value_type', $field, '' );

		if ( $label ) {
			if ( $required ) {
				$html .= '<div class="forminator-field--label">';
				$html .= sprintf( '<label id="forminator-label-%s" class="forminator-label">%s %s</label>', $id, $label, forminator_get_required_icon() );
				$html .= '</div>';
			} else {
				$html .= '<div class="forminator-field--label">';
				$html .= sprintf( '<label id="forminator-label-%s" class="forminator-label">%s</label>', $id, $label );
				$html .= '</div>';
			}
		}

		if ( "multiselect" === $field_type ) {
			$post_value = self::get_post_data( $name, self::FIELD_PROPERTY_VALUE_NOT_EXIST );
			$name       = $name . '[]';
			$html       .= '<ul class="forminator-multiselect">';

			foreach ( $options as $option ) {
				$value          = $option['value'] ? $option['value'] : $option['label'];
				$input_id       = $id . '-' . $i;
				$option_default = isset( $option['default'] ) ? filter_var( $option['default'], FILTER_VALIDATE_BOOLEAN ) : false;

				$selected = false;
				if ( self::FIELD_PROPERTY_VALUE_NOT_EXIST !== $post_value ) {
					if ( is_array( $post_value ) ) {
						$selected = in_array( $value, $post_value );// phpcs:ignore WordPress.PHP.StrictInArray.MissingTrueStrict
					}
				} else {
					$selected = $option_default;
				}
				$selected = $selected ? 'checked="checked"' : '';

				if ( trim( $this->get_form_style( $settings ) ) === 'clean' ) {
					$html .= '<li class="forminator-multiselect--item">';
					$html .= sprintf( '<input id="%s" type="checkbox" name="%s" value="%s" %s> %s', $input_id . '-' . $uniq_id, $name, $value, $selected, $option['label'] );
					$html .= '</li>';
				} else {
					$html .= sprintf( '<li class="forminator-multiselect--item">' );
					$html .= sprintf( '<input id="%s" name="%s" type="checkbox" value="%s" %s>', $input_id . '-' . $uniq_id, $name, $value, $selected );
					$html .= sprintf( '<label for="%s">%s</label>', $input_id . '-' . $uniq_id, $option['label'] );
					$html .= sprintf( '</li>' );
				}

				$i ++;
			}

			$html .= '</ul>';
		} else {
			$html .= sprintf( '<select class="forminator-select--field forminator-select" id="%s" data-required="%s" name="%s">', $id, $required, $name );

			foreach ( $options as $option ) {
				$value          = $option['value'] ? $option['value'] : '';
				$option_default = isset( $option['default'] ) ? filter_var( $option['default'], FILTER_VALIDATE_BOOLEAN ) : false;
				$selected       = ( $value === $post_value || $option_default ) ? 'selected="selected"' : '';

				$html .= sprintf( '<option value="%s" %s>%s</option>', $value, $selected, $option['label'] );
			}

			$html .= sprintf( '</select>' );
		}

		$html .= self::get_description( $description );

		return apply_filters( 'forminator_field_single_markup', $html, $id, $required, $options );
	}

	/**
	 * Return field inline validation rules
	 *
	 * @since 1.0
	 * @return string
	 */
	public function get_validation_rules() {
		$rules       = '';
		$field       = $this->field;
		$is_required = $this->is_required( $field );

		if ( $is_required ) {
			$rules .= '"' . $this->get_id( $field ) . '": "required",';
		}

		return $rules;
	}

	/**
	 * Return field inline validation errors
	 *
	 * @since 1.0
	 * @return string
	 */
	public function get_validation_messages() {
		$messages    = '';
		$field       = $this->field;
		$id          = self::get_property( 'element_id', $field );
		$is_required = $this->is_required( $field );

		if ( $is_required ) {
			$required_message = self::get_property( 'required_message', $field, __( 'This field is required. Please select a value', Forminator::DOMAIN ) );
			$required_message = apply_filters(
				'forminator_single_field_required_validation_message',
				$required_message,
				$id,
				$field
			);
			$messages         .= '"' . $this->get_id( $field ) . '": "' . $required_message . '",' . "\n";
		}

		return $messages;
	}

	/**
	 * Field back-end validation
	 *
	 * @since 1.0
	 *
	 * @param array        $field
	 * @param array|string $data
	 */
	public function validate( $field, $data ) {
		if ( $this->is_required( $field ) ) {
			$id = self::get_property( 'element_id', $field );
			if ( empty( $data ) ) {
				$required_message                = self::get_property( 'required_message', $field, __( 'This field is required. Please select a value', Forminator::DOMAIN ) );
				$this->validation_message[ $id ] = apply_filters(
					'forminator_single_field_required_validation_message',
					$required_message,
					$id,
					$field
				);
			}
		}
	}

	/**
	 * Sanitize data
	 *
	 * @since 1.0.2
	 *
	 * @param array        $field
	 * @param array|string $data - the data to be sanitized
	 *
	 * @return array|string $data - the data after sanitization
	 */
	public function sanitize( $field, $data ) {
		// Sanitize
		$data = forminator_sanitize_field( $data );

		return apply_filters( 'forminator_field_single_sanitize', $data, $field );
	}
}
