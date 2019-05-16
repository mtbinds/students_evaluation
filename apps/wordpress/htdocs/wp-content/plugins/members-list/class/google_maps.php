<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			google_maps.php
//		Description:
//			Functions for dealing with google maps
//		Actions:
//			1) Get coordinates for an address
//		Date:
//			Added on June 18th 2010
//		Version:
//			1.2
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

if(!class_exists('gMaps')) {
//
class gMaps {

	function __construct() {
		$this->h = new WP_Http();
	}

	function geoLocate($a,$k=false) {
		$this->a = array_merge(array(
			'line1'		=>	'',
			'line2'		=>	'',
			'city'		=>	'',
			'state'		=>	'',
			'zip'		=>	'',
			'country'	=>	''
		),$a);

		$a = $this->format_address();
		if(empty($a)) {
			return false;
		}

		if(!$k or empty($k)) {
			$r = $this->h->get('http://maps.google.com/maps/api/geocode/json?sensor=false&language=en&address='.$a);
			$r = json_decode($r['body']);
			if(isset($r->results[0]->geometry->location)) {
				return $r->results[0]->geometry->location;
			}
			elseif(isset($r->error_message)) {
				return $r->error_message;
			}
		}
		else {
			$r = $this->h->get('https://maps.googleapis.com/maps/api/geocode/json?components=country&key='.$k.'&address='.$a);
			$r = json_decode($r['body']);
			if(isset($r->results[0]->geometry->location)) {
				return $r->results[0]->geometry->location;
			}
			elseif(isset($r->error_message)) {
				return $r->error_message;
			}
		}

		return false;
	}
	function format_address() {
		$this->sanitize_address();
		return urlencode(implode(', ',array_filter($this->a,'strlen')));
	}
	function sanitize_address() {
		foreach($this->a as $k => $v) {
			$this->a[$k] = preg_replace("/[^a-zA-Z0-9]+/",'+',trim($v));
		}
		$this->a = array_filter($this->a,'strlen');
	}

}
$getMap = new gMaps;
//
}

/****************************************Terminate Script******************************************/
?>
