<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			users.php
//		Description:
//			This file is responsible for user functions.
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
	Functions
------------------------------------------------------------------------------------------------*/

function WP_members_list_is_in_list($u,$l) {
	$m = get_user_meta($u,'_tern_wp_member_list');
	$m = is_array($m) ? $m : array($m);
	foreach($m as $v) {
		if($v == $l) {
			return true;
		}
	}

	return false;
}
function WP_members_list_get_users_by_role($r) {
	global $wpdb;
	
	foreach($r as $v) {
		$x .= empty($x) ? " $wpdb->usermeta.meta_value LIKE '%$v%' " : " or $wpdb->usermeta.meta_value LIKE %'$v'% ";
	}
	return $wpdb->get_results("select ID from $wpdb->users inner join $wpdb->usermeta on($wpdb->users.ID = $wpdb->usermeta.user_id) where $wpdb->usermeta.meta_key='$wpdb->prefix"."capabilities' and ($x)");  
}


function WP_ml_get_users_by_role($r) {
	global $wpdb;
	
	foreach($r as $v) {
		$x .= empty($x) ? " $wpdb->usermeta.meta_value LIKE '%$v%' " : " or $wpdb->usermeta.meta_value LIKE %'$v'% ";
	}
	return $wpdb->get_results("select ID from $wpdb->users inner join $wpdb->usermeta on($wpdb->users.ID = $wpdb->usermeta.user_id) where $wpdb->usermeta.meta_key='$wpdb->prefix"."capabilities' and ($x)");  
}
function WP_ml_is_in_list($u,$l) {
	$m = get_user_meta($u,'_WP_ML');
	$m = is_array($m) ? $m : array($m);
	foreach($m as $v) {
		if($v == $l) {
			return true;
		}
	}

	return false;
}
function WP_ml_user_db_fields() {
	global $wpdb,$WP_ml_user_fields,$WP_ml_user_meta_fields,$WP_ml_user_hidden_meta_fields;
	foreach((array)$WP_ml_user_fields as $k => $v) {
		//foreach((array)$list['fields'] as $w) {
		//	if($v == $w['name']) {
		//		continue 2;
		//	}
		//}
		$a['Standard Fields'][] = array($k,$v);
	}
	foreach($WP_ml_user_meta_fields as $k => $v) {
		//foreach((array)$list['fields'] as $w) {
		//	if($v == $w['name']) {
		//		continue 2;
		//	}
		//}
		$a['Standard Meta Fields'][] = array($k,$v);
	}
	$r = $wpdb->get_col("select distinct meta_key from $wpdb->usermeta");
	foreach($r as $v) {
		if(in_array($v,$WP_ml_user_fields) or in_array($v,$WP_ml_user_meta_fields) or in_array($v,$WP_ml_user_hidden_meta_fields)) {
			continue;
		}
		//foreach((array)$list['fields'] as $w) {
		//	if($v == $w['name']) {
		//		continue 2;
		//	}
		//}
		$a['Available Meta Fields'][] = array($v,$v);
	}
	return $a;
}
function  WP_ml_user_by_all() {
	global $wpdb;
	$a = $wpdb->get_results('select ID from '.$wpdb->users);
	WP_ml_users_add($a);
}
function WP_ml_user_remove($l='') {
	global $wpdb;
	$a = $wpdb->query('delete from '.$wpdb->usermeta.' where meta_key="_WP_ML" and meta_value="'.$l.'"');
}
function WP_ml_user_by_role() {
	WP_ml_users_add(WP_ml_get_users_by_role(array($_POST['role'])));
}
function WP_ml_users_add($a=array()) {
	if(!empty($a)) {
		foreach($a as $v) {
			$m = get_user_meta($v->ID,'_WP_ML');
			$m = is_array($m) ? $m : array($m);
			$t = false;
			foreach($m as $w) {
				if($w == $_POST['name']) {
					//$t = true;
					break;
				}
			}
			if(!$t) {
				add_user_meta($v->ID,'_WP_ML',$_POST['name'],false);
			}
		}
	}
}
function WP_ml_author_fields_get() {
	global $ml_options;
	if(isset($ml_options['author_field']) and !empty($ml_options['author_field']) and isset($ml_options['author_field_title']) and !empty($ml_options['author_field_title'])) {
		return array_combine($ml_options['author_field_title'],$ml_options['author_field']);
	}
	return false;
}
function WP_ml_user_name_get($u=0) {
	$n = get_user_meta($u,'first_name',true);
	$l = get_user_meta($u,'last_name',true);
	if($n and $l) {
		$n .= ' '.$l;
	}
	else {
		$n = get_the_author_meta('user_nicename',$u);
	}
	return $n;
}

/****************************************Terminate Script******************************************/
?>