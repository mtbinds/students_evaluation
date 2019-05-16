<div id="members_list_add_item" class="form-modal">
	<form id="members_list_add_item_form" class="WP-ml-modal-form" method="post" action="<?php bloginfo('wpurl'); ?>/wp-admin/admin.php?page=members-list-configure-sort">
		<h2><?php _e('Add a new sort field','ml'); ?>:</h2>
		<div class="form-field">
			<label><?php _e('Name','ml'); ?>:</label>
			<input type="text" name="name" size="40" />
		</div>
		<div class="form-field">
			<label><?php _e('Field','ml'); ?>:</label>
			<?php echo $ternSel->create(array(
				'type'			=>	'tiered',
				'data'			=>	$WP_ml_user_db_fields,
				'key'			=>	0,
				'value'			=>	1,
				'name'			=>	'field',
				'select_value'	=>	'Add New Field'
			)); ?>
		</div>
		<p class="submit">
			<input type="submit" value="<?php _e('Add Field','ml'); ?>" class="btn button-secondary action" />
		</p>
		<input type="hidden" name="item" />
		<input type="hidden" name="action" value="field" />
		<input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('tern_wp_members_nonce'); ?>" />
	</form>
</div>