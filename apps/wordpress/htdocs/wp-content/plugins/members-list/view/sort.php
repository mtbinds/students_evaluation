<div class="wrap">
	<h1><?php _e('Sort Fields','ml'); ?> <a href="#TB_inline?width=400&height=700&inlineId=members_list_add_item" id="add_item" class="thickbox page-title-action"><?php _e('Add New','ml'); ?></a></h1>
	
	<div class="tern_message">
		<p><strong><a href="http://www.ternstyle.us/members-list-plugin-for-wordpress/" target="_blank">Upgrade to the PRO version of the Members List plugin here!</a></strong></p>
	</div>
	
	<?php if(isset($o['sorts']) and !empty($o['sorts'])) { ?>
	<form id="tern_wp_members_list_fm" method="post" action="<?php bloginfo('wpurl'); ?>/wp-admin/admin.php?page=members-list-configure-sort">
		<div class="tablenav">
			<div class="alignleft actions">
				<select name="action2">
					<option value="" selected="selected">Bulk Actions</option>
					<option value="delete">Delete</option>
				</select>
				<input type="submit" value="Apply" name="doaction" id="doaction" class="button-secondary action" />
			</div>
			<br class="clear" />
		</div>
		<table id="members_list_fields" class="widefat fixed" cellspacing="0">
			<thead>
				<tr class="thead">
					<th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" /></th>
					<th scope="col" class="manage-column" style="width:15%;">Name</th>
					<th scope="col" class="manage-column" style="width:15%;">Field</th>
				</tr>
			</thead>
			<tfoot>
				<tr class="thead">
					<th scope="col" class="manage-column column-cb check-column"><input type="checkbox" /></th>
					<th scope="col" class="manage-column">Name</th>
					<th scope="col" class="manage-column">Field</th>
				</tr>
			</tfoot>
			<tbody id="fields" class="list:sort sort-list">
				<?php foreach((array)$o['sorts'] as $k => $v) { $d = empty($d) ? ' class="alternate"' : ''; ?>
				<tr id="list-<?php echo $v; ?>"<?php echo $d; ?>>
					<th scope="row" class="check-column"> <input type="checkbox" name="sorts[]" id="sorts_<?php echo $v; ?>" value="<?php echo $v; ?>" /> <input type="hidden" name="field_names[]" value="<?php echo $k; ?>" /> <input type="hidden" name="field_values[]" value="<?php echo $v; ?>" /> </th>
					<td><strong><?php echo $k; ?></strong><br />
						<div class="row-actions">
							<span class='edit'> <a href="admin.php?page=members-list-configure-sort&sorts%5B%5D=<?php echo $v; ?>&action=delete&_wpnonce=<?php echo wp_create_nonce('tern_wp_members_nonce'); ?>">Delete</a> </span>
						</div></td>
					<td><?php echo $v; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<input type="hidden" name="action" value="order" /> <input type="hidden" name="page" value="members-list-configure-sort" /> <input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce('tern_wp_members_nonce'); ?>" />
	</form>
	<?php } ?>
</div>
