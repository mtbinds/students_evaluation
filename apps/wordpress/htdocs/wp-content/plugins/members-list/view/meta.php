<?php if(isset($o['lists']) and !empty($o['lists'])) { ?>
<h3>Members Lists</h3>
<table class="form-table">
	<tr>
		<th><label for="lists">Select the lists you'd like this user displayed in:</label></th>
		<td>
			<ul>
				<?php foreach((array)$o['lists'] as $v) { ?>
				<?php if(!isset($v['name'])) { ?>
				<li>The list "<?php echo $v; ?>" was created with an old version of this plugin. Please recreate your list with the latest tools.</li>
				<?php } else { ?>
				<li><input type="checkbox" name="lists[]" value="<?php echo $v['name']; ?>" <?php if(WP_members_list_is_in_list($i->ID,$v['name'])) {?>checked<?php } ?> /> <?php echo $v['name']; ?></li>
				<?php } ?>
				<?php } ?>
			</ul>
		</td>
	</tr>
</table>
<?php } ?>
<h3>Address</h3>

<?php
		foreach($addy as $v) {
			$address[$v] = get_user_meta($i->ID,'_'.$v,true);
		}
		//$address = get_user_meta($i->ID,'_address',true);
	?>
<table class="form-table">
	<tr>
		<th><label for="line1">Address Line 1:</label></th>
		<td><input type="text" name="line1" value="<?php echo $address['line1']; ?>" class="regular-text" /></td>
	</tr>
	<tr>
		<th><label for="line2">Address Line 2:</label></th>
		<td><input type="text" name="line2" value="<?php echo $address['line2']; ?>" class="regular-text" /></td>
	</tr>
	<tr>
		<th><label for="city">City:</label></th>
		<td><input type="text" name="city" value="<?php echo $address['city']; ?>" class="regular-text" /></td>
	</tr>
	<tr>
		<th><label for="state">State:</label></th>
		<td><?php echo $ternSel->create(array(
				'type'			=>	'paired',
				'data'			=>	$WP_ml_states,
				'name'			=>	'state',
				'select_value'	=>	'select',
				'selected'		=>	array($address['state'])
			)); ?></td>
	</tr>
	<tr>
		<th><label for="zip">Zipcode:</label></th>
		<td><input type="text" name="zip" value="<?php echo $address['zip']; ?>" class="regular-text" /></td>
	</tr>
	<tr>
		<th><label for="lat">Latitude:</label></th>
		<td><input type="text" name="lat" value="<?php echo get_user_meta($i->ID,'_lat',true); ?>" class="regular-text" /></td>
	</tr>
	<tr>
		<th><label for="lng">Longitude:</label></th>
		<td><input type="text" name="lng" value="<?php echo get_user_meta($i->ID,'_lng',true); ?>" class="regular-text" /></td>
	</tr>
</table>
