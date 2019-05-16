<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			tern_wp_members.php
//		Description:
//			This file initializes the Wordpress Plugin - Members List Plugin
//		Actions:
//			1) list members
//			2) search through members
//			3) perform administrative actions
//		Date:
//			Added on January 29th 2009
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
//________________________________** ADD EVENTS                **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
//hide new members
add_action('user_register','tern_wp_members_hide');
//short code
add_shortcode('members-list','tern_wp_members_shortcode');


//                                *******************************                                 //
//________________________________** SCRIPTS                   **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function tern_wp_members_hide($i) {
	global $getWP,$tern_wp_members_defaults;
	$o = $getWP->getOption('tern_wp_members',$tern_wp_members_defaults);
	if($o['hide'] and !in_array($i,$o['hidden'])) {
		$o['hidden'][] = $i;
		$o = $getWP->getOption('tern_wp_members',$o,true);
	}
}
//                                *******************************                                 //
//________________________________** SHORTCODE                 **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function tern_wp_members_shortcode($a) {
	wp_enqueue_style('ml-style');
	$m = new tern_members;
	return $m->members($a,false);
}

/****************************************Terminate Script******************************************/
?>