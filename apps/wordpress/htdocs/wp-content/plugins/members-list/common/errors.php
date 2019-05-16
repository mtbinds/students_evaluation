<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			errors.php
//		Description:
//			This file renders errors for the plugin's administrative tasks.
//		Copyright:
//			Copyright (c) 2016 Ternstyle LLC.
//		License:
//			This file (software) is licensed under the terms of the End User License Agreement (EULA) 
//			provided with this software. In the event the EULA is not present with this software
//			or you have not read it, please visit:
//			http://www.ternstyle.us/members-list-plugin-for-wordpress/license.html
//
////////////////////////////////////////////////////////////////////////////////////////////////////

/****************************************Commence Script*******************************************/

/*------------------------------------------------------------------------------------------------
	Events
------------------------------------------------------------------------------------------------*/

add_action('all_admin_notices','WP_members_list_errors');

/*------------------------------------------------------------------------------------------------
	Errors
------------------------------------------------------------------------------------------------*/

function WP_members_list_errors() {
	global $getWP;

	$e = $getWP->renderErrors();
	if($e) {
		echo '<div class="tern_error">'.$e.'</div>';
	}
	
	$e = $getWP->renderWarnings();
	if($e) {
		echo '<div class="tern_warning">'.$e.'</div>';
	}
	
	$a = $getWP->renderAlerts();
	if($a) {
		echo '<div class="tern_alert">'.$a.'</div>';
	}
}

/****************************************Terminate Script******************************************/
?>