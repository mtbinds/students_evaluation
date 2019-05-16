<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			scripts.php
//		Description:
//			This file includes the necerssary CSS and Javascript files.
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

add_action('init','WP_members_list_register_styles',0);
add_action('init','WP_members_list_register_scripts',0);
add_action('wp_print_scripts','WP_members_list_js_root');

/*------------------------------------------------------------------------------------------------
	Scripts
------------------------------------------------------------------------------------------------*/

function WP_members_list_register_styles() {
	wp_register_style('ml-admin',MEMBERS_LIST_URL.'/css/admin.css',array(),'4.0');
	wp_register_style('ml-style',MEMBERS_LIST_URL.'/css/members-list.css',array(),'4.0');
	
	if(is_admin()) {
		wp_enqueue_style('ml-admin');
	}
}
function WP_members_list_register_scripts() {
	wp_register_script('TableDnD',MEMBERS_LIST_URL.'/js/jquery.tablednd.js',array('jquery'),'0.8',true);
	wp_register_script('ml-admin',MEMBERS_LIST_URL.'/js/admin.js',array('jquery'),'1.0',true);
	wp_register_script('ml-scripts',MEMBERS_LIST_URL.'/js/scripts.js',array('jquery'),'1.0',true);
	
	if(is_admin()) {
		wp_enqueue_script('ml-admin');
	}
}
function WP_members_list_js_root() {
	echo '<script type="text/javascript">var tern_wp_root = "'.get_bloginfo('url').'";</script>'."\n";
}

/****************************************Terminate Script******************************************/
?>