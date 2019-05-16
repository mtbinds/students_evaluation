<div class="wrap">
	<h1>Members Settings</h1>
	
	<div class="tern_message">
		<p><strong><a href="http://www.ternstyle.us/members-list-plugin-for-wordpress/" target="_blank">Upgrade to the PRO version of the Members List plugin here!</a></strong></p>
	</div>
	
	<form method="post" action="">
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="noun">Use a word other than "Members" on the front-end</label></th>
				<td><input type="text" name="noun" class="regular-text" value="<?php echo isset($o['noun']) ? $o['noun'] : ''; ?>" /> <span class="setting-description">i.e. "Clients" or "Users"</span></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="limit">Number of viewable members at one time</label></th>
				<td><?php
						$a = array(5,10,15,20,25,50,100,200);
						echo $ternSel->create(array(
							'type'			=>	'select',
							'data'			=>	$a,
							'id'			=>	'limit',
							'name'			=>	'limit',
							'selected'		=>	isset($o['limit']) ? array((int)$o['limit']) : array()
						));
					?></td>
			</tr>
		</table>
		<h3>Sorting Members</h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="sort">Sort the members list originally by</label></th>
				<td><?php echo $ternSel->create(array(
				'type'			=>	'tiered',
				'data'			=>	$WP_ml_user_db_fields,
				'key'			=>	0,
				'value'			=>	1,
				'name'			=>	'sort',
				'selected'		=>	isset($o['sort']) ? array($o['sort']) : array()
			)); ?></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="order">Sort members list originally in this order</label></th>
				<td><input type="radio" name="order" value="asc" <?php if(isset($o['order']) and $o['order'] == 'asc') { echo 'checked'; } ?> /> Ascending <input type="radio" name="order" value="desc" <?php if(isset($o['order']) and $o['order'] == 'desc') { echo 'checked'; } ?> /> Descending </td>
			</tr>
		</table>
		<h3>Display Options</h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="allow_display">Allow users to choose which lists they wish to be a part of?</label></th>
				<td><input type="radio" name="allow_display" value="1" <?php if(isset($o['allow_display']) and $o['allow_display']) { echo 'checked'; } ?> /> yes <input type="radio" name="allow_display" value="0" <?php if(!isset($o['allow_display']) or !$o['allow_display']) { echo 'checked'; } ?> /> no </td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="gravatars">Use gravatars?</label></th>
				<td><input type="radio" name="gravatars" value="1" <?php if(isset($o['gravatars']) and $o['gravatars']) { echo 'checked'; } ?> /> yes <input type="radio" name="gravatars" value="0" <?php if(!isset($o['gravatars']) or !$o['gravatars']) { echo 'checked'; } ?> /> no </td>
			</tr>
		</table>
		<p class="submit"><input type="submit" name="submit" class="button-primary" value="Save Changes" /></p>
		<input type="hidden" id="page" name="page" value="members-list/core/members-list.php" /> <input type="hidden" name="action" value="WP-members-list-update" /> <input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce('tern_wp_members_nonce'); ?>" /> <input type="hidden" name="_wp_http_referer" value="<?php wp_get_referer(); ?>" />
	</form>
</div>
