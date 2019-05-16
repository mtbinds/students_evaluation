<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			conf.php
//		Description:
//			This file configures the Wordpress Plugin - Members List
//		Actions:
//			1) initialize pertinent variables
//			2) load classes and functions
//		Date:
//			Added on June 12th 2010
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
//________________________________** INITIALIZE VARIABLES      **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //

define('MEMBERS_LIST_URL',get_bloginfo('wpurl').'/wp-content/plugins/members-list');
define('MEMBERS_LIST_DIR',dirname(__FILE__));

$tern_wp_members_defaults = array(
	'limit'		=>	10,
	'sort'		=>	'last_name',
	'sorts'		=>	array('Last Name'=>'last_name','First Name'=>'first_name','Registration Date'=>'user_registered','Email'=>'user_email'),
	'order'		=>	'asc',
	'meta'		=>	'',
	'url'		=>	false,
	'gravatars'	=>	1,
	'hide_email'	=>	0,
	'hide'		=>	0,
	'hidden'	=>	array(0),
	'noun'		=>	'members',
	'searches'	=>	array('Last Name'=>'last_name','First Name'=>'first_name','Description'=>'description','User Name'=>'user_nicename','Email'=>'user_email','Display Name'=>'display_name','URL'=>'user_url'),
	'fields'	=>	array('User Name'=>'user_nicename','Email'=>'user_email','URL'=>'user_url'),
	'lists'		=>	array(),
	'allow_display'	=>	0
);
$tern_wp_meta_fields = array(
	'Last Name'		=>	'last_name',
	'First Name'	=>	'first_name',
	'Description'	=>	'description'
);
$tern_wp_members_fields = array(
	'User Name'		=>	'user_nicename',
	'Email Address'	=>	'user_email',
	'Display Name'	=>	'display_name',
	'URL'			=>	'user_url',
	'Registration Date'	=>	'user_registered'
);
$tern_wp_user_fields = array('ID','user_login','user_pass','user_nicename','user_email','user_url','user_registered','user_activation_key','user_status','display_name');

$WP_ml_user_fields = array(
	'User Name'			=>	'user_nicename',
	'Email Address'		=>	'user_email',
	'Display Name'		=>	'display_name',
	'URL'				=>	'user_url',
	'Registration Date'	=>	'user_registered'
);
$WP_ml_user_meta_fields = array(
	'Last Name'		=>	'last_name',
	'First Name'		=>	'first_name',
	'Description'	=>	'description'
);
$WP_ml_user_hidden_meta_fields = array(
	"rich_editing",
	"comment_shortcuts",
	"wp_capabilities",
	"wp_usersettings",
	"wp_usersettingstime",
	"wp_autosave_draft_ids",
	"screen_layout_dashboard",
	"use_ssl",
	"closedpostboxes_post",
	"metaboxhidden_post",
	"closedpostboxes_dashboard",
	"metaboxhidden_dashboard",
	"closedpostboxes_page",
	"metaboxhidden_page",
	"screen_layout_post",
	"edit_per_page",
	"edit_comments_per_page",
	"wp_user-settings",
	"wp_dashboard_quick_press_last_post_id",
	"default_password_nag",
	"meta-box-order_dashboard",
	"show_admin_bar_front",
	"dismissed_wp_pointers",
	"session_tokens",
	'_WP_ML',
	'wporg_favorites',
	'wp_user-settings-time'
);

$WP_ml_states = array('Alabama'=>'AL','Alaska'=>'AK','Arizona'=>'AZ','Arkansas'=>'AR','California'=>'CA','Colorado'=>'CO','Connecticut'=>'CT','Delaware'=>'DE','Florida'=>'FL','Georgia'=>'GA','Hawaii'=>'HI','Idaho'=>'ID','Illinois'=>'IL','Indiana'=>'IN','Iowa'=>'IA','Kansas'=>'KS','Kentucky'=>'KY','Louisiana'=>'LA','Maine'=>'ME','Maryland'=>'MD','Massachusetts'=>'MA','Michigan'=>'MI','Minnesota'=>'MN','Mississippi'=>'MS','Missouri'=>'MO','Montana'=>'MT','Nebraska'=>'NE','Nevada'=>'NV','New Hampshire'=>'NH','New Jersey'=>'NJ','New Mexico'=>'NM','New York'=>'NY','North Carolina'=>'NC','North Dakota'=>'ND','Ohio'=>'OH','Oklahoma'=>'OK','Oregon'=>'OR','Pennsylvania'=>'PA','Rhode Island'=>'RI','South Carolina'=>'SC','South Dakota'=>'SD','Tennessee'=>'TN','Texas'=>'TX','Utah'=>'UT','Vermont'=>'VT','Virginia'=>'VA','Washington'=>'WA','West Virginia'=>'WV','Wisconsin'=>'WI','Wyoming'=>'WY','Alberta '=>'AB','British Columbia '=>'BC','Manitoba '=>'MB','New Brunswick '=>'NB','Newfoundland and Labrador '=>'NL','Northwest Territories '=>'NT','Nova Scotia '=>'NS','Nunavut '=>'NU','Ontario '=>'ON','Prince Edward Island '=>'PE','Quebec '=>'QC','Saskatchewan '=>'SK','Yukon '=>'YT');

//                                *******************************                                 //
//________________________________** FILE CLASS                **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
require_once(dirname(__FILE__).'/class/file.php');
$getFILE = new fileClass;
//                                *******************************                                 //
//________________________________** LOAD CLASSES              **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
$l = $getFILE->directoryList(array(
	'dir'	=>	dirname(__FILE__).'/class/',
	'rec'	=>	true,
	'flat'	=>	true,
	'depth'	=>	1
));
if(is_array($l)) {
	foreach($l as $k => $v) {
		require_once($v);
	}
}
//                                *******************************                                 //
//________________________________** INITIALIZE INCLUDES       **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //

$l = $getFILE->directoryList(array(
	'dir'	=>	dirname(__FILE__).'/common/',
	'rec'	=>	true,
	'flat'	=>	true,
	'depth'	=>	1,
	'ext'	=>	array('php')
));
foreach((array)$l as $k => $v) {
	require_once($v);
}

$l = $getFILE->directoryList(array(
	'dir'	=>	dirname(__FILE__).'/core/',
	'rec'	=>	true,
	'flat'	=>	true,
	'depth'	=>	1
));
if(is_array($l)) {
	foreach($l as $k => $v) {
		require_once($v);
	}
}

/*------------------------------------------------------------------------------------------------
	Initialize Plugin
------------------------------------------------------------------------------------------------*/

add_action('init','WP_members_list_init',-9999);
function WP_members_list_init() {
	global $getWP,$WP_ml_user_db_fields,$tern_wp_members_defaults;
	$WP_ml_user_db_fields = WP_ml_user_db_fields();

	//check to see if the plugin has been properly updated
	$o = $getWP->getOption('tern_wp_members',$tern_wp_members_defaults);

	//check lists
	foreach((array)$o['lists'] as $v) {
		if(!isset($v['name'])) {
			$o['lists'] = array();
			$o = $getWP->getOption('tern_wp_members',$o,true);
			$getWP->addError('Your lists were created in an outdated version of the Members List plugin. They have been cleared. Please <a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=members-list-create-list">click here</a> to recreate them.');
			break;
		}
	}

	//check display fields
	foreach((array)$o['fields'] as $v) {
		if(is_array($v)) {
			$o['fields'] = array('User Name'=>'user_nicename','Email'=>'user_email','URL'=>'user_url');
			$o = $getWP->getOption('tern_wp_members',$o,true);
			$getWP->addError('Your display fields were created in an outdated version of the Members List plugin. They have been reset. Please <a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=members-list-configure-fields">click here</a> to recreate them.');
			break;
		}
	}
}

/****************************************Terminate Script******************************************/
?>
