<div id="members_list_add_item" class="form-modal">
	<form id="members_list_add_item_form" class="WP-ml-modal-form" method="post" action="<?php bloginfo('wpurl'); ?>/wp-admin/admin.php?page=members-list-create-list">
		<h2><?php _e('Add a new list','ml'); ?>:</h2>
		<div class="form-field">
			<label><?php _e('Name','ml'); ?>:</label>
			<input type="text" name="name" size="40" />
		</div>
		<div class="form-field">
			<label><input type="checkbox" name="all" value="1" /> <?php _e('Add all users to this list','ml'); ?>:</label>
		</div>
		<p class="submit">
			<input type="submit" value="Add List" class="btn button-secondary action" />
		</p>
		<input type="hidden" name="item" /> <input type="hidden" name="action" value="list" />
		<input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('tern_wp_members_nonce'); ?>" />
	</form>
</div>
