<?php
/**
 * Typography control class.
 *
 * @since  1.0.0
 * @access public
 */

class VW_Education_Lite_Control_Typography extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'typography';

	/**
	 * Array 
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $l10n = array();

	/**
	 * Set up our control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @param  string  $id
	 * @param  array   $args
	 * @return void
	 */
	public function __construct( $manager, $id, $args = array() ) {

		// Let the parent class do its thing.
		parent::__construct( $manager, $id, $args );

		// Make sure we have labels.
		$this->l10n = wp_parse_args(
			$this->l10n,
			array(
				'color'       => esc_html__( 'Font Color', 'vw-education-lite' ),
				'family'      => esc_html__( 'Font Family', 'vw-education-lite' ),
				'size'        => esc_html__( 'Font Size',   'vw-education-lite' ),
				'weight'      => esc_html__( 'Font Weight', 'vw-education-lite' ),
				'style'       => esc_html__( 'Font Style',  'vw-education-lite' ),
				'line_height' => esc_html__( 'Line Height', 'vw-education-lite' ),
				'letter_spacing' => esc_html__( 'Letter Spacing', 'vw-education-lite' ),
			)
		);
	}

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_script( 'vw-education-lite-ctypo-customize-controls' );
		wp_enqueue_style(  'vw-education-lite-ctypo-customize-controls' );
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		// Loop through each of the settings and set up the data for it.
		foreach ( $this->settings as $setting_key => $setting_id ) {

			$this->json[ $setting_key ] = array(
				'link'  => $this->get_link( $setting_key ),
				'value' => $this->value( $setting_key ),
				'label' => isset( $this->l10n[ $setting_key ] ) ? $this->l10n[ $setting_key ] : ''
			);

			if ( 'family' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_families();

			elseif ( 'weight' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_weight_choices();

			elseif ( 'style' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_style_choices();
		}
	}

	/**
	 * Underscore JS template to handle the control's output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function content_template() { ?>

		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<ul>

		<# if ( data.family && data.family.choices ) { #>

			<li class="typography-font-family">

				<# if ( data.family.label ) { #>
					<span class="customize-control-title">{{ data.family.label }}</span>
				<# } #>

				<select {{{ data.family.link }}}>

					<# _.each( data.family.choices, function( label, choice ) { #>
						<option value="{{ choice }}" <# if ( choice === data.family.value ) { #> selected="selected" <# } #>>{{ label }}</option>
					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.weight && data.weight.choices ) { #>

			<li class="typography-font-weight">

				<# if ( data.weight.label ) { #>
					<span class="customize-control-title">{{ data.weight.label }}</span>
				<# } #>

				<select {{{ data.weight.link }}}>

					<# _.each( data.weight.choices, function( label, choice ) { #>

						<option value="{{ choice }}" <# if ( choice === data.weight.value ) { #> selected="selected" <# } #>>{{ label }}</option>

					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.style && data.style.choices ) { #>

			<li class="typography-font-style">

				<# if ( data.style.label ) { #>
					<span class="customize-control-title">{{ data.style.label }}</span>
				<# } #>

				<select {{{ data.style.link }}}>

					<# _.each( data.style.choices, function( label, choice ) { #>

						<option value="{{ choice }}" <# if ( choice === data.style.value ) { #> selected="selected" <# } #>>{{ label }}</option>

					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.size ) { #>

			<li class="typography-font-size">

				<# if ( data.size.label ) { #>
					<span class="customize-control-title">{{ data.size.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.size.link }}} value="{{ data.size.value }}" />

			</li>
		<# } #>

		<# if ( data.line_height ) { #>

			<li class="typography-line-height">

				<# if ( data.line_height.label ) { #>
					<span class="customize-control-title">{{ data.line_height.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.line_height.link }}} value="{{ data.line_height.value }}" />

			</li>
		<# } #>

		<# if ( data.letter_spacing ) { #>

			<li class="typography-letter-spacing">

				<# if ( data.letter_spacing.label ) { #>
					<span class="customize-control-title">{{ data.letter_spacing.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.letter_spacing.link }}} value="{{ data.letter_spacing.value }}" />

			</li>
		<# } #>

		</ul>
	<?php }

	/**
	 * Returns the available fonts.  Fonts should have available weights, styles, and subsets.
	 *
	 * @todo Integrate with Google fonts.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_fonts() { return array(); }

	/**
	 * Returns the available font families.
	 *
	 * @todo Pull families from `get_fonts()`.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	function get_font_families() {

		return array(
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
	}

	/**
	 * Returns the available font weights.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_font_weight_choices() {

		return array(
			'' => esc_html__( 'No Fonts weight', 'vw-education-lite' ),
			'100' => esc_html__( 'Thin',       'vw-education-lite' ),
			'300' => esc_html__( 'Light',      'vw-education-lite' ),
			'400' => esc_html__( 'Normal',     'vw-education-lite' ),
			'500' => esc_html__( 'Medium',     'vw-education-lite' ),
			'700' => esc_html__( 'Bold',       'vw-education-lite' ),
			'900' => esc_html__( 'Ultra Bold', 'vw-education-lite' ),
		);
	}

	/**
	 * Returns the available font styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_font_style_choices() {

		return array(
			'normal'  => esc_html__( 'Normal', 'vw-education-lite' ),
			'italic'  => esc_html__( 'Italic', 'vw-education-lite' ),
			'oblique' => esc_html__( 'Oblique', 'vw-education-lite' )
		);
	}
}
