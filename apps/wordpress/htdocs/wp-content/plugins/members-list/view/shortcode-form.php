<form id="WP-ml-shortcode" class="form form-modal">
	<div id="WP-ml-shortcode-fields">
		<h2>Select a Members List</h2>
		<div class="form-field">
			<?php echo $ternSel->create(array(
				'type'			=>	'assoc',
				'data'			=>	$lists,
				'name'			=>	'list-select',
				'select_value'	=>	'Select List'
			)); ?>
		</div>
		<p class="submit">
			<input type="submit" name="submit" class="button-primary" value="Add Shortcode" />
		</p>
	</div>
</form>