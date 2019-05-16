<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			sort.php
//		Description:
//			This file compiles and processes the plugin's configure sort page.
//		Actions:
//			1) compile plugin sort form
//			2) process and save plugin sort fields
//		Date:
//			Added on May 3rd 2011
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
if(!isset($_REQUEST['page']) or $_REQUEST['page'] !== 'members-list-configure-sort') {
	return;
}
//                                *******************************                                 //
//________________________________** ADD EVENTS                **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
add_action('init','WP_members_list_sort_fields_actions');
add_action('wp_ajax_order','WP_members_list_sort_fields_actions');
add_action('init','WP_members_list_sort_fields_styles');
add_action('init','WP_members_list_sort_fields_scripts');
//                                *******************************                                 //
//________________________________** SCRIPTS                   **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_members_list_sort_fields_styles() {
	wp_enqueue_style('thickbox');
}
function WP_members_list_sort_fields_scripts() {
	wp_enqueue_script('TableDnD');
	wp_enqueue_script('thickbox');
}
//                                *******************************                                 //
//________________________________** ACTIONS                   **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_members_list_sort_fields_actions() {
	global $getWP,$tern_wp_members_defaults,$current_user,$wpdb;
	$o = $getWP->getOption('tern_wp_members',$tern_wp_members_defaults);

	if(!isset($_REQUEST['_wpnonce']) or !wp_verify_nonce($_REQUEST['_wpnonce'],'tern_wp_members_nonce')) {
		return false;
	}

	if(isset($_REQUEST['action']) or isset($_REQUEST['action2'])) {
		$action = (isset($_REQUEST['action2']) and !empty($_REQUEST['action2'])) ? $_REQUEST['action2'] : $_REQUEST['action'];
	}
	else {
		return;
	}

	switch($action) {

		case 'order' :
			if(isset($_REQUEST['action']) and $_REQUEST['action'] == 'order') {
				if(!isset($_POST['field_names'])) {
					die('<div id="message" class="updated fade"><p>There was an error.</p></div>');
				}
				$a = array();
				foreach((array)$_POST['field_names'] as $k => $v) {
					$a[$v] = $_POST['field_values'][$k];
				}
				$o['sorts'] = $a;
				if($getWP->getOption('tern_wp_members',$o,true)) {
					die('<div id="message" class="updated fade"><p>Your order has been successfully saved.</p></div>');
				}
				break;
			}

		case 'field' :

			if(!isset($_POST['name']) or empty($_POST['name']) or !isset($_POST['field']) or empty($_POST['field'])) {
				$getWP->addError('Please fill out all the required fields.');
				return;
			}

			$n = $_POST['name'];

			if(isset($o['sorts']) and is_array($o['sorts']) and in_array($_POST['field'],(array)$o['sorts'])) {
				$getWP->addError('This field has already been added.');
				return;
			}
			$o['sorts'] = is_array($o['sorts']) ? $o['sorts'] : array();
			$o['sorts'][$n] = $_POST['field'];

			$o = $getWP->getOption('tern_wp_members',$o,true);
			break;

		case 'delete' :

			if(!isset($_REQUEST['sorts']) or empty($_REQUEST['sorts'])) {
				$getWP->addError('There was an error.');
				return;
			}

			$b = array();
			foreach((array)$o['sorts'] as $k => $v) {
				if(!in_array($v,$_REQUEST['sorts'])) {
					$b[$k] = $v;
				}
			}
			$o['sorts'] = $b;
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
function WP_members_list_sort_fields() {
	global $getWP,$ternSel,$tern_wp_members_defaults,$WP_ml_user_db_fields;
	$o = $getWP->getOption('tern_wp_members',$tern_wp_members_defaults);

	include(MEMBERS_LIST_DIR.'/view/sort.php');
	include(MEMBERS_LIST_DIR.'/view/sort-form.php');
}

/****************************************Terminate Script******************************************/
?>
