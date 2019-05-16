<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			create.php
//		Description:
//			This file compiles and processes the plugin's configurable lists.
//		Actions:
//			1) compile plugin lists
//			2) process and save plugin lists
//		Date:
//			Added on April 29th 2011
//		Copyright:
//			Copyright (c) 2011 Matthew Praetzel.
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
if(!isset($_GET['page']) or $_GET['page'] !== 'members-list-create-list') {
	return;
}
//                                *******************************                                 //
//________________________________** ADD EVENTS                **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
add_action('init','WP_members_list_create_actions');
add_action('init','WP_members_list_create_styles');
add_action('init','WP_members_list_create_scripts');
//                                *******************************                                 //
//________________________________** SCRIPTS                   **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_members_list_create_styles() {
	wp_enqueue_style('thickbox');
}
function WP_members_list_create_scripts() {
	wp_enqueue_script('thickbox');
}
//                                *******************************                                 //
//________________________________** ACTIONS                   **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_members_list_create_actions() {
	global $getWP,$tern_wp_members_defaults,$current_user,$wpdb;
	$current_user = wp_get_current_user();
	$o = $getWP->getOption('tern_wp_members',$tern_wp_members_defaults);

	if(!isset($_REQUEST['_wpnonce']) or !wp_verify_nonce($_REQUEST['_wpnonce'],'tern_wp_members_nonce')) {
		return false;
	}

	switch($_REQUEST['action']) {

		case 'list' :

			//validate
			if(!isset($_POST['name']) or empty($_POST['name'])) {
				$getWP->addError('Please fill out all the required fields.');
				return;
			}
			$n = $_POST['name'];

			//check if list with same name exists
			$o['lists'] = is_array($o['lists']) ? $o['lists'] : array();
			foreach((array)$o['lists'] as $v) {
				if($v['name'] == $n) {
					$getWP->addError('This list has already been created.');
					return;
				}
			}

			//add list
			$k = array_reverse(array_keys($o['lists']));
			if(!empty($k)) {
				$x = (int)$k[0]+1;
			}
			else {
				$x = 1;
			}
			$o['lists'][$x] = array('name'=>$n);
			$o = $getWP->getOption('tern_wp_members',$o,true);

			if(isset($_POST['all']) and $_POST['all']) {
				$a = $wpdb->get_results('select ID from '.$wpdb->users);
			}
			//elseif($_POST['role']) {
			//	$a = WP_members_list_get_users_by_role(array($_POST['role']));
			//}

			if(isset($a)) {
				foreach($a as $v) {
					$m = get_user_meta($v->ID,'_tern_wp_member_list');
					$m = is_array($m) ? $m : array($m);
					$t = false;
					foreach($m as $w) {
						if($w == $n) {
							$t = true;
							break;
						}
					}
					if(!$t) {
						add_user_meta($v->ID,'_tern_wp_member_list',$n,false);
					}

				}
			}

			break;

		case 'delete' :

			if(!isset($o['lists']) or empty($o['lists'])) {
				$getWP->addError('No lists to delete.');
				return;
			}

			if(!isset($_REQUEST['lists']) or empty($_REQUEST['lists'])) {
				$getWP->addError('Please select lists to delete.');
				return;
			}

			$b = array();
			foreach((array)$o['lists'] as $k => $v) {
				if(!in_array($k,$_REQUEST['lists'])) {
					$b[] = $v;
				}
				else {
					$wpdb->query("delete from $wpdb->usermeta where meta_key='_tern_wp_member_list' and meta_value='".$v['name']."'");
				}
			}
			$o['lists'] = $b;
			$o = $getWP->getOption('tern_wp_members',$o,true);

			break;

		default :
			break;

	}

}
//                                *******************************                                 //
//________________________________** SETTINGS                  **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_members_list_create() {

	global $getWP,$tern_wp_msg,$tern_wp_members_defaults,$notice;
	$o = $getWP->getOption('tern_wp_members',$tern_wp_members_defaults);

	include(MEMBERS_LIST_DIR.'/view/lists.php');
	include(MEMBERS_LIST_DIR.'/view/list-form.php');
}

/****************************************Terminate Script******************************************/
?>
