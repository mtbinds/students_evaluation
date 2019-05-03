<?php
$empty_icon   = forminator_plugin_url() . 'assets/images/forminator-noicon.png';
$empty_icon2x = forminator_plugin_url() . 'assets/images/forminator-noicon@2x.png';
if ( empty( $quiz_id ) ) {
	$quiz_id = 0;
}

$show_action = false;

$icon_class_action = 'sui-icon-plus';
$tooltip           = __( 'Configure Integration', Forminator::DOMAIN );
$main_action       = 'forminator_addon_settings';

$multi_id   = 0;
$multi_name = false;

if ( ! empty( $quiz_id ) ) {
	$main_action       = 'forminator_addon_quiz_settings';
	$show_action       = false;
	$icon_class_action = 'sui-icon-plus';
	if ( isset( $addon['is_quiz_settings_available'] ) && ! empty( $addon['is_quiz_settings_available'] ) && true === $addon['is_quiz_settings_available'] ) {
		$show_action = true;
		if ( $addon['is_allow_multi_on_quiz'] ) {
			if ( isset( $addon['multi_name'] ) ) {
				$icon_class_action = 'sui-icon-widget-settings-config';
				$tooltip           = __( 'Configure Integration', Forminator::DOMAIN );
				$multi_id          = $addon['multi_id'];
				$multi_name        = $addon['multi_name'];
			} else {
				if ( isset( $addon['multi_id'] ) ) {
					$multi_id = $addon['multi_id'];
				}
				$icon_class_action = 'sui-icon-plus';
				$tooltip           = __( 'Add Integration', Forminator::DOMAIN );
			}
		} else {
			if ( $addon['is_quiz_connected'] ) {
				$icon_class_action = 'sui-icon-widget-settings-config';
				$tooltip           = __( 'Configure Integration', Forminator::DOMAIN );
			} else {
				$icon_class_action = 'sui-icon-plus';
				$tooltip           = __( 'Add Integration', Forminator::DOMAIN );
			}
		}

	}
} else {
	// on integrations page
	if ( isset( $addon['is_settings_available'] ) && ! empty( $addon['is_settings_available'] ) && true === $addon['is_settings_available'] ) {
		$show_action = true;
		if ( $addon['is_connected'] ) {
			$icon_class_action = 'sui-icon-widget-settings-config';
			$tooltip           = __( 'Configure Integration', Forminator::DOMAIN );
		} else {
			$icon_class_action = 'sui-icon-plus';
			$tooltip           = __( 'Add Integration', Forminator::DOMAIN );
		}
	}
}

$action_available = false;
if ( ! empty( $show_pro_info ) && $show_pro_info ) {
	$show_pro_info = true;
} else {
	$show_pro_info = false;
}

/**
 * force Disable pro tag y default
 */
$show_pro_info = false;

$pro_url        = 'https://premium.wpmudev.org';
$pro_url_target = '_blank';

// MULTI NAME (SAMPLE)
// To be added in the table later when design is ready.
/*
<td><?php if ( ! empty( $multi_name ) ): ?>
	<?php echo esc_html( $multi_name ); ?>
<?php endif; ?></td>
*/ ?>

<tr class="<?php echo( $is_active ? 'fui-integration-enabled' : '' ); ?>">

	<td class="sui-table-item-title">

		<span>

			<?php if ( isset( $addon['icon'] ) && ! empty( $addon['icon'] ) ) { ?>
				<img src="<?php echo esc_url( $addon['icon'] ); ?>"
				     srcset="<?php echo esc_url( $addon['icon'] ); ?> 1x, <?php echo esc_url( $addon['icon_x2'] ); ?> 2x"
				     alt="<?php echo esc_attr( $addon['short_title'] ); ?>"
				     class="sui-image"
				     aria-hidden="true"/>
			<?php } else { ?>
				<img src="<?php echo esc_url( $empty_icon ); ?>"
				     srcset="<?php echo esc_url( $empty_icon ); ?> 1x, <?php echo esc_url( $empty_icon2x ); ?> 2x"
				     alt="<?php echo esc_attr( $addon['short_title'] ); ?>"
				     class="sui-image"
				     aria-hidden="true"/>
			<?php } ?>

			<span><?php echo esc_html( $addon['title'] ); ?><?php if ( $show_pro_info && $addon['is_pro'] ) : ?>
					<span class="sui-tag sui-tag-pro">
					<?php esc_html_e( "PRO", Forminator::DOMAIN ); ?>
				</span>
				<?php endif; ?></span>

			<?php if ( $show_action ) : ?>
				<button class="sui-button-icon sui-tooltip sui-tooltip-top-right connect-integration"
				        data-tooltip="<?php echo esc_attr( $tooltip ); ?>"
				        data-slug="<?php echo esc_attr( $addon['slug'] ); ?>"
				        data-title="<?php echo esc_attr( $addon['title'] ); ?>"
				        data-image="<?php echo esc_attr( $addon['image'] ); ?>"
				        data-imagex2="<?php echo esc_attr( $addon['image_x2'] ); ?>"
				        data-nonce="<?php echo wp_create_nonce( 'forminator_addon_action' ); // WPCS: XSS ok. ?>"
				        data-action="<?php echo esc_attr( $main_action ); ?>"
				        data-quiz-id="<?php echo esc_attr( $quiz_id ); ?>"
				        data-multi-id="<?php echo esc_attr( $multi_id ); ?>">
					<i class="<?php echo esc_attr( $icon_class_action ); ?>" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_html_e( 'Connect this integration', Forminator::DOMAIN ); ?></span>
				</button>
			<?php endif; ?>

		</span>

	</td>

</tr>
