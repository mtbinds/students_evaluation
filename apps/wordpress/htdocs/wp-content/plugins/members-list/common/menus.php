<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			menus.php
//		Description:
//			This file initializes menus for the plugin's administrative tasks
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
	Actions
------------------------------------------------------------------------------------------------*/

add_action('admin_menu','WP_members_list_menu');

/*------------------------------------------------------------------------------------------------
	Menus
------------------------------------------------------------------------------------------------*/

function WP_members_list_menu() {
	if(function_exists('add_menu_page')) {
		add_menu_page('Members List','Members List','manage_options','members-list-settings','WP_members_list_settings');
		add_submenu_page('members-list-settings','Members List','Settings','manage_options','members-list-settings','WP_members_list_settings');
		add_submenu_page('members-list-settings','Create a List','Create a List','manage_options','members-list-create-list','WP_members_list_create');
		add_submenu_page('members-list-settings','Change Sort Fields','Change Sort Fields','manage_options','members-list-configure-sort','WP_members_list_sort_fields');
		add_submenu_page('members-list-settings','Change Search Fields','Change Search Fields','manage_options','members-list-configure-search','WP_members_list_search_fields');
		//add_submenu_page('members-list-settings','Configure Mark-Up','Configure Mark-Up','manage_options','members-list-configure-mark-up','WP_members_list_markup');
		add_submenu_page('members-list-settings','Change Display Fields','Change Display Fields','manage_options','members-list-configure-fields','WP_members_list_fields');
		//add_submenu_page('members-list-settings','Upgrade!','Upgrade!','read','members-list-upgrade','WP_members_list_upgrade');
		//add_submenu_page('members-list-settings','Edit Members','Edit Members','manage_options','members-list-edit-members-list','WP_members_list_list');
		
		 global $submenu;
		 $submenu['members-list-settings'][] = array('Upgrade!','read','http://www.ternstyle.us/members-list-plugin-for-wordpress/');

	}
}

/****************************************Terminate Script******************************************/
?>