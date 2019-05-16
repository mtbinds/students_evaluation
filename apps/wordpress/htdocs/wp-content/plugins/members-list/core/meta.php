<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			meta.php
//		Description:
//			This file compiles and processes the plugin's user meta options.
//		Actions:
//			1) compile options
//			2) process and save options
//		Date:
//			Added on April 30th 2011
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
if(!isset($pagenow) or ($pagenow !== 'profile.php' and $pagenow !== 'user-edit.php')) {
	return;
}
//                                *******************************                                 //
//________________________________** ADD EVENTS                **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
add_action('profile_update','WP_members_list_meta_actions');
add_action('init','WP_members_list_meta_styles');
add_action('init','WP_members_list_meta_scripts');
add_action('edit_user_profile','WP_members_list_meta');
add_action('show_user_profile','WP_members_list_meta');
//                                *******************************                                 //
//________________________________** SCRIPTS                   **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_members_list_meta_styles() {

}
function WP_members_list_meta_scripts() {

}
//                                *******************************                                 //
//________________________________** ACTIONS                   **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_members_list_meta_actions($i) {
	global $getWP,$tern_wp_members_defaults,$current_user,$wpdb,$profileuser,$current_user,$getMap;
	$o = $getWP->getOption('tern_wp_members',$tern_wp_members_defaults);
	$current_user = wp_get_current_user();

	if(!current_user_can('edit_users') and (($o['allow_display'] and $current_user->ID != $i) or !$o['allow_display'])) {
		return;
	}

	delete_user_meta($i,'_tern_wp_member_list');
	foreach((array)$_REQUEST['lists'] as $v) {
		add_user_meta($i,'_tern_wp_member_list',$v);
	}

	$a = array('line1','line2','city','state','zip');
	foreach($a as $v) {
		delete_user_meta($i,'_'.$v);
		add_user_meta($i,'_'.$v,$_POST[$v]);
		$address[$v] = $_POST[$v];
	}
	//delete_user_meta($i,'_address');
	//add_user_meta($i,'_address',$address);


	$l = $getMap->geoLocate($address);
	if(isset($l->lat) and isset($l->lng)) {
		delete_user_meta($i,'_lat');
		delete_user_meta($i,'_lng');
		add_user_meta($i,'_lat',$l->lat);
		add_user_meta($i,'_lng',$l->lng);
	}
}
//                                *******************************                                 //
//________________________________** SETTINGS                  **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_members_list_meta($i) {

	global $getWP,$tern_wp_members_defaults,$profileuser,$current_user,$ternSel,$WP_ml_states;
	$o = $getWP->getOption('tern_wp_members',$tern_wp_members_defaults);
	$current_user = wp_get_current_user();

	if(!current_user_can('edit_users') and (($o['allow_display'] and $current_user->ID != $i->ID) or !$o['allow_display'])) {
		return;
	}
	$addy = array('line1','line2','city','state','zip');
	include(MEMBERS_LIST_DIR.'/view/meta.php');
}

/****************************************Terminate Script******************************************/
?>
