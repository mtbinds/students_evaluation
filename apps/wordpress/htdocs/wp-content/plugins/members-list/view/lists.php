<div class="wrap">
	<h1>Members Lists <a href="#TB_inline?width=400&height=700&inlineId=members_list_add_item" id="add_item" class="thickbox page-title-action">Add New</a></h1>
	
	<div class="tern_message">
		<p><strong><a href="http://www.ternstyle.us/members-list-plugin-for-wordpress/" target="_blank">Upgrade to the PRO version of the Members List plugin here!</a></strong></p>
	</div>
	
	<form id="ml_fm" method="post" action="<?php bloginfo('wpurl'); ?>/wp-admin/admin.php?page=members-list-create-list">
		<div class="tablenav">
			<div class="alignleft actions">
				<select name="action">
					<option value="" selected="selected">Bulk Actions</option>
					<option value="delete">Delete</option>
				</select>
				<input type="submit" value="Apply" name="doaction" id="doaction" class="button-secondary action" />
			</div>
			<br class="clear" />
		</div>
		<table id="lists" class="widefat fixed" cellspacing="0">
			<thead>
				<tr class="thead">
					<th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" /></th>
					<th scope="col" class="manage-column">Name</th>
					<th scope="col" class="manage-column">Short Code</th>
				</tr>
			</thead>
			<tfoot>
				<tr class="thead">
					<th scope="col" class="manage-column column-cb check-column"><input type="checkbox" /></th>
					<th scope="col" class="manage-column">Name</th>
					<th scope="col" class="manage-column">Short Code</th>
				</tr>
				</tr>
				
			</tfoot>
			<tbody id="list" class="list:cals cals-list">
				<?php if(isset($o['lists']) and !empty($o['lists'])) { ?>
				<?php foreach((array)$o['lists'] as $k => $v) { $d = empty($d) ? ' class="alternate"' : ''; ?>
				<tr id="list-<?php echo $k; ?>"<?php echo $d; ?>>
					<th scope="row" class="check-column"><input type="checkbox" name="lists[]" value="<?php echo $k; ?>" /></th>
					<td><strong><?php echo $v['name']; ?></strong><br />
						<div class="row-actions">
							<span class='edit'> <a href="admin.php?page=members-list-create-list&lists%5B%5D=<?php echo $k; ?>&action=delete&_wpnonce=<?php echo wp_create_nonce('tern_wp_members_nonce'); ?>">Delete</a> </span>
						</div>
					</td>
					<td><?php echo '[members-list id='.$k.' search=true radius=true alpha=true pagination=true sort=true]'; ?></td>
				</tr>
				<?php }} ?>
			</tbody>
		</table>
		<input type="hidden" name="page" value="members-list-create-list" />
		<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce('tern_wp_members_nonce'); ?>" />
	</form>
</div>