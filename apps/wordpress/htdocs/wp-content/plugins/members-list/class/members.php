<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			members.php
//		Description:
//			This class controls the compilation of the members list and its pagination.
//		Actions:
//			1) compile members list
//			2) compile members list pagination
//			3) compile members list search options
//		Date:
//			Added January 29th, 2009
//		Version:
//			1.0
//		Copyright:
//			Copyright (c) 2009 Matthew Praetzel.
//		License:
//			This software is licensed under the terms of the GNU Lesser General Public License v3
//			as published by the Free Software Foundation. You should have received a copy of of
//			the GNU Lesser General Public License along with this software. In the event that you
//			have not, please visit: http://www.gnu.org/licenses/gpl-3.0.txt
//
////////////////////////////////////////////////////////////////////////////////////////////////////

/****************************************Commence Script*******************************************/

//                                *******************************                                 //
//________________________________** MEMBERS LIST              **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
if(!class_exists('tern_members')) {
//
class tern_members {

	var $open = false;
	var $link_open = false;
	var $q = '';
	var $tq = '';

	function __construct() {
		global $getFIX,$getWP,$tern_wp_members_defaults,$post,$WP_ml_user_fields,$WP_ml_user_meta_fields;
		$this->wp = $getWP;
		$o = $this->wp->getOption('tern_wp_members',$tern_wp_members_defaults);
		if(!empty($o)) {
			$this->num = $o['limit'];
			$f = explode(',',$o['meta']);
			$f = $getFIX->removeEmptyValues($f);
			$a = array();
			foreach($f as $k => $v) {
				$a[$v] = $v;
			}
			$this->meta_fields = $a;
		}
		$this->o = $o;
		$u = get_permalink();
		$this->url = strpos($u,'?') !== false ? $u : $u.'?';

		$this->user_fields = $WP_ml_user_fields;
		$this->user_meta_fields = $WP_ml_user_meta_fields;
	}
	function members($a,$e=true) {

		$this->list = isset($a['list']) ? $a['list'] : (isset($a['id']) ? $a['id'] : false);
		if(!isset($this->o['lists'][$this->list])) {
			return false;
		}
		$this->list = $this->o['lists'][$this->list];
		$this->fields = $this->o['fields'];

		$this->scope();
		$this->query();

		$r = '<div id="tern_members">';
		if(isset($a['search']) and $a['search'] !== false and $a['search'] !== 'false') {
			$r .= $this->search();
		}
		if(isset($a['radius']) and $a['radius'] !== false and $a['radius'] !== 'false') {
			$r .= $this->radius();
		}
		if(isset($a['alpha']) and $a['alpha'] !== false and $a['alpha'] !== 'false') {
			$r .= $this->alpha();
		}
		$r .= $this->viewing($a);
		if(isset($a['sort']) and $a['sort'] !== false and $a['sort'] !== 'false') {
			$r .= $this->sortby();
		}

		$this->compile_list();
		$r .= '<div class="tern_wp_members_list">'.$this->ml.'</div>';
		/*
		$r .= '<ul class="tern_wp_members_list">';
		foreach($this->r as $u) {
			//get user info
			$u = new WP_User($u);
			//compile name to be displayed
			$n = $u->first_name . ' ' . $u->last_name;
			$n = empty($u->first_name) ? $u->display_name : $n;
			if(!empty($n)) {
				$r .= $this->markup($u);
			}
		}
		$r .= '</ul>';
		if($a['pagination2'] !== false and $a['pagination2'] !== 'false') {
			$r .= $this->pagination();
		}
		*/

		$r .= '</div>';
		if($e) { echo $r; }
		return $r;
	}
	function scope() {
		$this->p = get_query_var('page');
		$this->p = empty($this->p) ? 1 : $this->p;
		$this->n = isset($this->total) ? ceil($this->total/$this->num) : 0;
		$this->s = intval($this->p-1);
		if(empty($this->s)) {
			$this->s = 0;
		}
		elseif($this->n > 0 and $this->s >= $this->n) {
			$this->s = ($this->n-1);
		}
		if(isset($this->total)) {
			$this->e = $this->total > (($this->s*$this->num)+$this->num) ? (($this->s*$this->num)+$this->num) : $this->total;
		}
		else {
			$this->e = 0;
		}
	}
	function geo_code() {
		global $getMap;
		if(!empty($_GET['byradius']) and !empty($_GET['radius'])) {
			$r = $getMap->geoLocate(array('zip'=>$_GET['byradius']));
			$lat = $this->lat = $r->lat;
			$lng = $this->lng = $r->lng;
		}
	}
	function select() {
		global $wpdb,$tern_wp_user_fields,$getMap;

		$q = "select distinct a.ID";
		$q .= " from $wpdb->users as a ".$this->q;
		$this->q = $q;
		$this->tq = "select COUNT(distinct a.ID) from $wpdb->users as a ".$this->tq;
	}
	function join() {
		global $wpdb,$tern_wp_user_fields;

		//sort
		if(!empty($this->sort) and !in_array($this->sort,$tern_wp_user_fields)) {
			$this->q .= " ,$wpdb->usermeta as b ";
		}

		//by
		if(!empty($this->by) and !in_array($this->by,$tern_wp_user_fields) and !in_array($this->sort,$tern_wp_user_fields) and $this->type != 'radius') {
			$this->q .= " ,$wpdb->usermeta as c ";
		}

		//alpha
		elseif(isset($this->type) and $this->type == 'alpha' and !in_array($this->sort,$tern_wp_user_fields)) {
			$this->q .= " ,$wpdb->usermeta as c ";
		}

		//query
		elseif(!empty($this->query) and !in_array($this->by,$tern_wp_user_fields)) {
			$this->q .= " ,$wpdb->usermeta as c ";
		}

		//list
		if(!empty($this->list)) {
			$this->q .= " ,$wpdb->usermeta as d ";
		}

		//radius
		if(!empty($_GET['byradius']) and !empty($_GET['radius'])) {
			$this->q .= " ,$wpdb->usermeta as g ";
			$this->q .= " ,$wpdb->usermeta as h ";
		}

	}
	function where() {
		global $wpdb,$tern_wp_members_defaults,$tern_wp_user_fields,$tern_wp_meta_fields,$tern_wp_members_fields;
		$o = $this->wp->getOption('tern_wp_members',$tern_wp_members_defaults);

		//start where
		$this->q .= ' where 1=1 ';

		//sort
		if(!empty($this->sort) and !in_array($this->sort,$tern_wp_user_fields)) {
			$this->q .= " and b.user_id = a.ID ";
		}

		//by
		if(!empty($this->by) and !in_array($this->by,$tern_wp_user_fields) and !in_array($this->sort,$tern_wp_user_fields)) {
			$this->q .= " and c.user_id = a.ID ";
		}

		//alpha
		elseif(isset($this->type) and $this->type == 'alpha' and !in_array($this->sort,$tern_wp_user_fields)) {
			$this->q .= " and c.user_id = a.ID ";
		}

		//query
		elseif(!empty($this->query) and $this->query != 'search...' and !in_array($this->by,$tern_wp_user_fields)) {
			$this->q .= " and c.user_id = a.ID ";
		}

		//list
		if(!empty($this->list)) {
			$this->q .= " and d.user_id = a.ID ";
		}

		//radius
		if(!empty($_GET['byradius']) and !empty($_GET['radius'])) {
			$this->q .= " and g.user_id = a.ID ";
			$this->q .= " and h.user_id = a.ID ";
			$this->q .= " and g.meta_key='_lat' and h.meta_key='_lng' ";
		}

		//hide members
		$this->q .= !empty($o['hidden']) ? " and a.ID NOT IN (".implode(',',$o['hidden']).")" : '';

		//sort
		if(!empty($this->sort) and !in_array($this->sort,$tern_wp_user_fields)) {
			$this->q .= " and b.meta_key = '$this->sort' ";
		}

		//by
		if(!empty($this->by) and in_array($this->by,$tern_wp_user_fields)) {
			$this->q .= " and instr(a.$this->by,'$this->query') != 0 ";
		}
		elseif(!empty($this->by)) {
			$this->q .= " and c.meta_key = '$this->by' and instr(c.meta_value,'$this->query') != 0 ";
		}
		elseif(!empty($this->query) and $this->query != 'search...' and (!isset($this->type) or $this->type != 'alpha')) {
			$w = $x = '';
			foreach($this->o['searches'] as $v) {
				if(!in_array($v,$tern_wp_user_fields)) {
					$w .= empty($w) ? " c.meta_key = '$v'" : " or c.meta_key = '$v'";
				}
				else {
					$x .= empty($x) ? "a.$v" : ",a.$v";
				}
			}
			$this->q .= empty($x) ? ' and ' : 'and (';
			$this->q .= "(($w) and instr(c.meta_value,'$this->query') != 0) ";
			$this->q .= empty($x) ? '' : " or instr(concat_ws(' ',$x),'$this->query') != 0) ";
		}

		//alpha
		if(isset($this->type) and $this->type == 'alpha') {
			$this->q .= " and c.meta_key = 'last_name' and SUBSTRING(LOWER(c.meta_value),1,1) = '$this->query' ";
		}

		//list
		if(!empty($this->list)) {
			$this->q .= " and d.meta_key='_tern_wp_member_list' and d.meta_value='".$this->list['name']."' ";
		}

		$this->tq .= $this->q;

	}
	function order() {
		global $tern_wp_user_fields;
		if(!empty($_GET['byradius']) and !empty($_GET['radius'])) {
			$d = 1.609344*$_GET['radius'];
			$r = " and 6371 * 2 * ASIN( SQRT( POWER( SIN( RADIANS( $this->lat - g.meta_value ) / 2 ), 2 ) + COS( RADIANS( $this->lat ) ) * COS( RADIANS( g.meta_value ) ) * POWER( SIN( RADIANS( $this->lng - h.meta_value ) / 2 ), 2 ) ) ) < $d";
			$this->q .= $r;
			$this->tq .= $r;
		}
		if(!empty($this->sort) and in_array($this->sort,$tern_wp_user_fields)) {
			$this->q .= " order by $this->sort $this->order";
		}
		elseif(!empty($this->sort)) {
			$this->q .= " order by b.meta_value $this->order";
		}
	}
	function limit() {
		$this->q .= " limit $this->start,$this->end ";
	}
	function query($g=false) {
		global $wpdb,$tern_wp_user_fields,$tern_wp_members_fields,$tern_wp_meta_fields;

		foreach($_GET as $k => $v) {
			$this->$k = $$k = $this->sanitize($v);
		}
		$this->query = isset($_GET['query']) ? $_GET['query'] : false;
		$this->sort = isset($_GET['sort']) ? $_GET['sort'] : $this->o['sort'];
		$this->order = isset($_GET['order']) ? $_GET['order'] : $this->o['order'];
		$this->start = $s = strval($this->s*$this->num);
		$this->end = $e = strval($this->num);

		$this->geo_code();
		$this->join();
		$this->where();
		$this->order();
		$this->limit();
		$this->select();
		//echo $this->q;
		$this->r = $wpdb->get_col($this->q);
		$this->total = intval($wpdb->get_var($this->tq));
		return $this->r;
	}
	function pagination($z=false) {
		global $tern_wp_members_defaults;
		$o = $this->wp->getOption('tern_wp_members',$tern_wp_members_defaults);
		$q = isset($_GET['query']) ? $_GET['query'] : false;
		$b = isset($_GET['by']) ? $_GET['by'] : false;
		$t = isset($_GET['type']) ? $_GET['type'] : false;
		$this->scope();
		$r = '';
		if($this->n > 1) {
			$s = $this->p-2;
			$e = ($s+4)>$this->n ? $this->n : $s+4;
			if($s <= 0) {
				$s = 1;
				$e = ($s+4)>$this->n ? $this->n : $s+4;
			}
			elseif(($this->p+2) > $this->n) {
				$e = $this->n;
				$s = ($e-4)<=0 ? 1 : $e-4;
			}
			$sort = empty($_GET['sort']) ? $o['sort'] : $_GET['sort'];
			$order = empty($_GET['order']) ? $o['order'] : $_GET['order'];
			for($i=$s;$i<=$e;$i++) {
				$h = $this->get_query($i);
				$c = intval($this->s+1) == $i ? ' class="tern_members_pagination_current tern_pagination_current"' : '';
				$r .= '<li'.$c.'><a href="' . $h . '">' . $i . '</a></li>';
			}
			if($this->s > 0) {
				$r = '<li><a href="'.$this->get_query(intval($this->s)).'">Previous</a></li>'.$r;
			}
			if($this->total > (($this->s*$this->num)+$this->num)) {
				$r .= '<li><a href="'.$this->get_query(intval($this->s+2)).'">Next</a></li>';
				$r .= '<li><a href="'.$this->get_query($this->n).'">Last</a></li>';
			}
			$r = $this->s > 0 ? '<li><a href="'.$this->get_query(1).'">First</a></li>'.$r : $r;
			$r = '<ul class="tern_pagination">' . $r . '</ul>';
		}
		if($z) { echo $r; }
		return $r;
	}
	function get_query($p) {
		return $this->url.'page='.$p.'&query='.(isset($_GET['query']) ? $_GET['query'] : '').'&by='.(isset($_GET['by']) ? $_GET['by'] : '').'&type='.(isset($_GET['type']) ? $_GET['type'] : '').'&sort='.$this->sort.'&order='.$this->order.'&byradius='.(isset($_GET['byradius']) ? $_GET['byradius'] : '').'&radius='.(isset($_GET['radius']) ? $_GET['radius'] : '');
	}
	function search($e=false) {
		global $ternSel,$tern_wp_members_fields,$tern_wp_meta_fields;

		$a = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

		$v = empty($_REQUEST['query']) ? '' : $_REQUEST['query'];

		$r = '<div class="tern_members_search">
		<form method="get" action="'.$this->url.'">
			<h2>Search Our '.ucwords($this->o['noun']).':</h2>
			<input type="text" id="query" name="query" class="blur" value="'.$v.'" placeholder="Search..." />
			by '.$ternSel->create(array(
						'type'			=>	'paired',
						'data'			=>	$this->o['searches'],
						'id'			=>	'by',
						'name'			=>	'by',
						'select_value'	=>	'All Fields',
						'selected'		=>	isset($_REQUEST['by']) ? array($_REQUEST['by']) : array()
					)).'<input type="hidden" name="p" value="'.(isset($_REQUEST['p']) ? $_REQUEST['p'] : '').'" />
			<input type="hidden" name="page_id" value="'.(isset($_REQUEST['page_id']) ? $_REQUEST['page_id'] : '').'" />
			<input type="submit" value="Submit" />
		</form></div>';
		if($e) { echo $r; }
		return $r;
	}
	function radius($e=false) {
		global $ternSel,$tern_wp_members_fields,$tern_wp_meta_fields;
		$v = empty($_REQUEST['byradius']) ? '' : $_REQUEST['byradius'];
		$r = '<div class="tern_members_search"><form method="get" action="'.$this->url.'">
			<label>and search by zipcode:</label>
			<input type="text" id="byradius" name="byradius" class="blur" value="'.$v.'" placeholder="Zip / Postal Code..." />
			'.$ternSel->create(array(
						'type'			=>	'select',
						'data'			=>	array(5,10,25,50,100,250,500),
						'name'			=>	'radius',
						'select_value'	=>	'Radius',
						'selected'		=>	isset($_REQUEST['radius']) ? array((int)$_REQUEST['radius']) : array()
					)).'<input type="hidden" name="p" value="'.(isset($_REQUEST['p']) ? $_REQUEST['p'] : '').'" />
			<input type="submit" value="Submit" />
		</form></div>';
		if($e) { echo $r; }
		return $r;
	}
	function alpha($e=false) {
		$a = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
		$r = '<div class="tern_members_alpha">Search alphabetically <span>(by last name)</span>:<br /><ul>';
		foreach($a as $v) {
			unset($c);
			$c = '';
			if(isset($_GET['query']) and $v == $_GET['query']) {
				$c = 'class="tern_members_selected"';
			}
			$r .= '<li><a '.$c.' href="'.$this->url.'&page=1&query='.$v.'&type=alpha&sort=last_name">'.strtoupper($v).'</a></li>';
		}
		$r .= '</ul></div>';
		if($e) { echo $r; }
		return $r;
	}
	function sortby($e=false) {

		$r = '';
		foreach((array)$this->o['sorts'] as $k => $v) {
			unset($c,$o);

			$c = '';
			$o = 'asc';
			if($this->sort == $v) {
				if($this->order == 'asc') {
					$c =  ' class="tern_members_sorted_u" ';
					$o = 'desc';
				}
				else {
					$c = ' class="tern_members_sorted_d" ';
					$o = 'asc';
				}
			}

			$r .= '<li'.$c.'><a href="'.$this->url.'&query='.urldecode((isset($_GET['query']) ? $_GET['query'] : '')).'&by='.(isset($_GET['by']) ? $_GET['by'] : '').'&type='.(isset($_GET['type']) ? $_GET['type'] : '').'&sort='.$v.'&order='.$o.'&byradius='.(isset($_GET['byradius']) ? $_GET['byradius'] : '').'&radius='.(isset($_GET['radius']) ? $_GET['radius'] : '').'">'.$k.'</a></li>';
		}
		$r = '<div class="tern_members_sort"><label>Sort by:</label><ul>'.$r.'</ul></div>';
		if($e) { echo $r; }
		return $r;
	}
	function viewing($a,$e=false) {
		global $tern_wp_members_defaults;
		$o = $this->wp->getOption('tern_wp_members',$tern_wp_members_defaults);
		$this->scope();
		$v = $this->total > 0 ? (($this->s*$this->num)+1) : '0';
		$m = '.';
		if(isset($this->type) and $this->type == 'alpha') {
			$m = ' whose last names begin with the letter "'.strtoupper($q).'".';
		}
		$r = '<div class="tern_members_view">Now viewing <b>' . $v . '</b> through <b>' . $this->e . '</b> of <b>'.$this->total.'</b> '.$o['noun'].' found'.$m;
		if(isset($a['pagination']) and $a['pagination'] !== false and $a['pagination'] !== 'false') {
			$r .= $this->pagination();
		}
		$r .= '</div>';
		if($e) { echo $r; }
		return $r;
	}


	/*------------------------------------------------------------------------------------------------
	Mark-up
------------------------------------------------------------------------------------------------*/

	private function compile_list() {
		$this->list_start();
		$this->list_loop();
		$this->list_end();
	}
	private function list_start() {
		$this->ml = '<div class="WP-ml-members-list">';
	}
	private function list_end() {
		$this->ml .= '</div>';
	}
	private function list_loop() {
		foreach((array)$this->r as $this->member) {
			$this->member = new WP_User($this->member);
			$this->member = json_decode(json_encode($this->member->data),true);
			$this->list_loop_add();
		}
	}
	private function list_loop_add() {
		$this->list_loop_add_start();
		$this->list_loop_add_gravatar();
		$this->list_loop_add_markup();
		$this->list_loop_add_end();
	}
	private function list_loop_add_start() {
		$this->ml .= '<div class="WP-ml-member">';
	}
	private function list_loop_add_end() {
		$this->ml .= '<br style="clear:both;" />';
		$this->ml .= '</div>';
	}
	private function list_loop_add_gravatar($b=false) {
		if((isset($this->o['gravatars']) and $this->o['gravatars']) or $b) {
			$this->ml .= '<div class="WP-ml-field-img">';
			$this->ml .= '<a href="'.get_author_posts_url($this->member['ID']).'">';
			$this->ml .= get_avatar($this->member['ID'],60);
			$this->ml .= '</a>';
			$this->ml .= '</div>';
		}
	}
	private function list_loop_add_markup() {
		$this->ml .= '<div class="WP-ml-member-markup">';
		foreach((array)$this->fields as $this->field_id => $this->field) {

			$b = false;
			foreach((array)$this->fields as $k => $v) {
				if($b) {
					$this->field_next = $v;
					break;
				}
				if($k == $this->field_id) {
					$b = true;
				}
			}

			$this->list_loop_field_close();
			$this->list_loop_field_value_set();
			$this->list_loop_field_open();
			$this->list_loop_field_label();
			$this->list_loop_field_value();

			$this->field_last = $this->field;
		}
		$this->list_loop_field_close();
		//$this->list_loop_controls_add();
		$this->ml .= '<br style="clear:both;" />';
		$this->ml .= '</div>';
	}
	private function list_loop_controls_add() {
		if(current_user_can('administrator')) {
			$this->ml .= '<div class="WP-ml-member-admin-controls">';
			$this->ml .= '<a href="'.get_admin_url().'admin.php?page=ml-edit-users&action=remove&list='.$this->list_id.'&user[]='.$this->member['ID'].'&_wpnonce='.wp_create_nonce('WP_ml_nonce').'" target="_blank" class="WP-ml-button WP-ml-remove">&#x2212;</a>';
			$this->ml .= '<a href="'.get_admin_url().'user-edit.php?user_id='.$this->member['ID'].'" target="_blank" class="WP-ml-button WP-ml-edit">&#x270e;</a>';
			$this->ml .= '</div>';
		}
	}
	private function list_loop_field_open() {
		$this->open = false;
		if(empty($this->value)) {
			return;
		}
		$this->open = true;
		if($this->field == 'last_name' and $this->field_last == 'first_name') {
			return $this->ml .= ' ';
		}

		$this->ml .= '<div class="WP-ml-field WP-ml-field-'.$this->field;
		$this->ml .= $this->field_id == 0 ? ' WP-ml-field-first' : '';
		$this->ml .= '">';

		if(($this->field == 'last_name' or $this->field == 'first_name')) {
			//$this->ml .= '<a href="'.get_author_posts_url($this->member['ID']).'">';
			//$this->link_open = true;
		}
	}
	private function list_loop_field_close() {
		if(!$this->open) {
			return;
		}
		if($this->field == 'last_name' and $this->field_last == 'first_name') {
			return;
		}

		if($this->link_open) {
			$this->ml .= '</a>';
			$this->link_open = false;
		}
		$this->ml .= '</div>';
		$this->open = false;
	}
	private function list_loop_field_label() {
		if(empty($this->value)) {
			return;
		}
		if($this->field == 'first_name' and $this->field_next == 'last_name') {
			$this->ml .=  '<label class="WP-ml-label"><span>Name</span><span class="WP-ml-label-separator">:</span></label>';
		}
		elseif($this->field == 'last_name' and $this->field_last == 'first_name') {
			$this->ml .=  '';
		}
		else {
			$this->ml .=  '<label class="WP-ml-label"><span>'.$this->field_id.'</span><span class="WP-ml-label-separator">:</span></label>';
		}
	}
	private function list_loop_field_value() {
		if($this->field == 'first_name' and $this->field_next == 'last_name') {
			$this->ml .= !empty($this->value) ? $this->value : '';
		}
		elseif($this->field == 'last_name' and $this->field_last == 'first_name') {
			$this->ml .= !empty($this->value) ? $this->value : '';
		}
		else {
			$this->ml .= !empty($this->value) ? '<div class="WP-ml-field-value">'.$this->value.'</div>' : '';
		}
	}
	private function list_loop_field_value_set() {
		$this->value = in_array($this->field,$this->user_fields) ? $this->member[$this->field] : get_user_meta($this->member['ID'],$this->field,true);
		if($this->field == 'description' and !empty($this->value)) {
			$this->value = Html::trim($this->value,200);
			$this->value .= '<a href="'.get_author_posts_url($this->member['ID']).'" class="WP-ml-button">&rarr;</a>';
		}
	}
	private function list_loop_field_value_get($f='',$u=false) {
		$u = !$u ? $this->member : $u;
		return in_array($f,$this->user_fields) ? $u[$f] : get_user_meta($u['ID'],$f,true);
	}
	private function list_first_field_value($u) {
		$s = '';
		if(isset($this->list['fields'][0]['field'])) {
			$s = $this->list_loop_field_value_get($this->list['fields'][0]['field'],$u);
			if($this->list['fields'][0]['field'] == 'first_name' and isset($this->list['fields'][1]['field']) and $this->list['fields'][1]['field'] == 'last_name') {
				$s .= ' '.$this->list_loop_field_value_get($this->list['fields'][1]['field'],$u);
			}
		}
		return $s;
	}

/*
	function markup($u) {
		global $tern_wp_members_defaults,$getMap;
		$o = $this->wp->getOption('tern_wp_members',$tern_wp_members_defaults);
		$s = '<li>'."\n    ";
		if($o['gravatars']) {
			$s .= '<a class="tern_wp_member_gravatar" href="'.get_author_posts_url($u->ID).'">'."\n        ".get_avatar($u->ID,60)."\n    ".'</a>'."\n    ";
		}
		$s .= '<div class="tern_wp_member_info">';
		foreach($o['fields'] as $k => $v) {
			if($v['name'] == 'user_email' and $o['hide_email'] and !is_user_logged_in()) {
				continue;
			}
			elseif($v['name'] == 'user_email') {
				$s .= "\n        <a href='mailto:".$u->$v['name']."'>".str_replace('%value%',$u->$v['name'],$v['markup']).'</a>';
				continue;
			}
			if($v['name'] == 'distance' and !empty($_GET['byradius'])) {
				$r = $getMap->geoLocate(array('zip'=>$_GET['byradius']));
				$lat = $r['lat'];
				$lng = $r['lng'];
				$distance = (6371 * 2 * asin( sqrt( pow( sin( deg2rad( $lat - $u->_lat ) / 2 ), 2 ) + cos( deg2rad( $lat ) ) * cos( deg2rad( $u->_lat ) ) * pow( sin( deg2rad( $lng - $u->_lng ) / 2 ), 2 ) ) ))/1.609344;
				$s .= "\n        ".str_replace('%author_url%',get_author_posts_url($u->ID),str_replace('%value%',round($distance).' miles',$v['markup']));
			}
			if(!empty($u->$v['name'])) {
				$s .= "\n        ".str_replace('%author_url%',get_author_posts_url($u->ID),str_replace('%value%',$u->$v['name'],$v['markup']));
			}
		}
		return $s."\n    ".'</div>'."\n".'</li>';
	}

*/

	function sanitize($s) {
		if(extension_loaded('PDO')) {
			$p = new PDO('mysql:dbname='.DB_NAME.';host='.DB_HOST,DB_USER,DB_PASSWORD);
			return substr($p->quote($s),1,strlen($p->quote($s))-2);
		}
		elseif(function_exists('mysql_real_escape_string')) {
			return mysql_real_escape_string($s);
		}
		return $s;
	}


}
//
}

/****************************************Terminate Script******************************************/
?>
