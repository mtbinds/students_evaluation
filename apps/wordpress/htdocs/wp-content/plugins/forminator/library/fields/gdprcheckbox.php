<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Forminator_GdprCheckbox
 *
 * @since 1.0.5
 */
class Forminator_GdprCheckbox extends Forminator_Field {

	/**
	 * @var string
	 */
	public $name = '';

	/**
	 * @var string
	 */
	public $slug = 'gdprcheckbox';

	/**
	 * @var string
	 */
	public $type = 'gdprcheckbox';

	/**
	 * @var int
	 */
	public $position = 21;

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
	public $icon = 'sui-icon-gdpr';

	/**
	 * Forminator_GdprChecbox constructor.
	 *
	 * @since 1.0.5
	 */

	public function __construct() {
		parent::__construct();

		$this->name = __( 'GDPR Approval', Forminator::DOMAIN );
	}

	/**
	 * Field defaults
	 *
	 * @since 1.0.5
	 * @return array
	 */
	public function defaults() {
		return array(
			'required'         => 'true',
			'field_label'      => 'GDPR',
			'gdpr_description' => __( 'Yes, I agree with <a href="#">privacy policy</a>, <a href="#">terms and condition</a>', Forminator::DOMAIN ),
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
		//Unsupported Autofill
		$autofill_settings = array();

		return $autofill_settings;
	}

	/**
	 * Field front-end markup
	 *
	 * @since 1.0.5
	 *
	 * @param $field
	 * @param $settings
	 *
	 * @return mixed
	 */
	public function markup( $field, $settings = array() ) {
		$this->field = $field;
		$html        = '';
		$id          = self::get_property( 'element_id', $field );
		$name        = $id;
		$description = self::get_property( 'gdpr_description', $field );
		$id          = $id . '-field-' . uniqid();
		$label       = self::get_property( 'field_label', $field );

		if ( $label ) {
			$html .= '<div class="forminator-field--label">';
			$html .= sprintf( '<label id="forminator-label-%s" class="forminator-label">%s %s</label>', $id, $label, forminator_get_required_icon() );
			$html .= '</div>';
		}

		$html .= '<div class="forminator-checkbox">';
		$html .= sprintf( '<input id="%s" type="checkbox" name="%s" value="true" class="forminator-checkbox--input" data-required="true">', $id, $name );
		$html .= sprintf( '<label for="%s" class="forminator-checkbox--design wpdui-icon wpdui-icon-check" aria-hidden="true"></label>', $id );
		$html .= sprintf( '<label for="%s" class="forminator-checkbox--label">%s</label>', $id, $description );
		$html .= '</div>';

		return apply_filters( 'forminator_field_gdprcheckbox_markup', $html, $id, $description );
	}

	/**
	 * Return field inline validation rules
	 *
	 * @since 1.0.5
	 * @return string
	 */
	public function get_validation_rules() {
		$field = $this->field;

		return '"' . $this->get_id( $field ) . '":{"required":true},';
	}

	/**
	 * Return field inline validation errors
	 *
	 * @since 1.0.5
	 * @return string
	 */
	public function get_validation_messages() {
		$messages = '';
		$field    = $this->field;
		$id       = $this->get_id( $field );

		$required_message = apply_filters(
			'forminator_gdprcheckbox_field_required_validation_message',
			__( 'This field is required. Please check it.', Forminator::DOMAIN ),
			$id,
			$field
		);
		$messages         .= '"' . $this->get_id( $field ) . '": {"required":"' . $required_message . '"},' . "\n";

		return $messages;
	}

	/**
	 * Field back-end validation
	 *
	 * @since 1.0.5
	 *
	 * @param array        $field
	 * @param array|string $data
	 */
	public function validate( $field, $data ) {
		// value of gdpr checkbox is `string` *true*
		$id = $this->get_id( $field );
		if ( empty( $data ) || 'true' !== $data ) {
			$this->validation_message[ $id ] = apply_filters(
				'forminator_gdprcheckbox_field_required_validation_message',
				__( 'This field is required. Please check it.', Forminator::DOMAIN ),
				$id,
				$field
			);
		}
	}

	/**
	 * Sanitize data
	 *
	 * @since 1.0.5
	 *
	 * @param array        $field
	 * @param array|string $data - the data to be sanitized
	 *
	 * @return array|string $data - the data after sanitization
	 */
	public function sanitize( $field, $data ) {
		$original_data = $data;
		// Sanitize
		$data = forminator_sanitize_field( $data );

		return apply_filters( 'forminator_field_gdprcheckbox_sanitize', $data, $field, $original_data );
	}
}
