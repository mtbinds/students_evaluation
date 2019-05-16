<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			settings.php
//		Description:
//			This file compiles and processes the plugin's various settings pages.
//		Actions:
//			1) compile overall plugin settings form
//			2) process and save plugin settings
//		Date:
//			Added on September 15th 2010
//		Copyright:
//			Copyright (c) 2010 Matthew Praetzel.
//		License:
//			This software is licensed under the terms of the GNU Lesser General Public License v3
//			as published by the Free Software Foundation. You should have received a copy of of
//			the GNU Lesser General Public License along with this software. In the event that you
//			have not, please visit: http://www.gnu.org/licenses/gpl-3.0.txt
//
////////////////////////////////////////////////////////////////////////////////////////////////////

/****************************************Commence Script*******************************************/

//                                *******************************                                 //
//________________________________** INITIALIZE                **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
if(!isset($_GET['page']) or $_GET['page'] !== 'members-list-settings') {
	return;
}
//                                *******************************                                 //
//________________________________** ADD EVENTS                **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //

add_action('init','WP_members_list_settings_actions');

//                                *******************************                                 //
//________________________________** ACTIONS                   **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_members_list_settings_actions() {
	global $getWP,$tern_wp_members_defaults,$current_user;
	$current_user = wp_get_current_user();
	$o = $getWP->getOption('tern_wp_members',$tern_wp_members_defaults);

	if(isset($_REQUEST['action']) and $_REQUEST['action'] == 'WP-members-list-update') {
		$_POST['meta'] = empty($_POST['meta']) ? '' : $_POST['meta'];
		$getWP->updateOption('tern_wp_members',$tern_wp_members_defaults,'tern_wp_members_nonce');
	}

}
//                                *******************************                                 //
//________________________________** SETTINGS                  **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_members_list_settings() {
	global $getWP,$ternSel,$tern_wp_members_defaults,$WP_ml_user_db_fields;
	$o = $getWP->getOption('tern_wp_members',$tern_wp_members_defaults);
	include(MEMBERS_LIST_DIR.'/view/settings.php');
}

/****************************************Terminate Script******************************************/
?>
