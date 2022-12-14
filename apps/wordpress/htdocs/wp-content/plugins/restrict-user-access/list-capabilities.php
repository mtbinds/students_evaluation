<?php
/**
 * @package Restrict User Access
 * @author Joachim Jensen <jv@intox.dk>
 * @license GPLv3
 * @copyright 2019 by Joachim Jensen
 */

defined('ABSPATH') || exit;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

final class RUA_Capabilities_List extends WP_List_Table {

	/**
	 * Constructor
	 *
	 * @since 0.8
	 */
	public function __construct() {
		parent::__construct(array(
			'singular' => __( 'Capability', 'restrict-user-access' ),
			'plural'   => __( 'Capabilities', 'restrict-user-access' ), 
			'ajax'     => false,
			'screen'   => RUA_App::TYPE_RESTRICT.'_caps'
		));
	}

	/**
	 * Text for no caps
	 *
	 * @since  0.8
	 * @return void
	 */
	public function no_items() {
		_e( 'No capabilities found.', 'restrict-user-access' );
	}

	/**
	 * Table columns with titles
	 *
	 * @since  0.8
	 * @return array
	 */
	public function get_columns() {
		return array(
			'name'       => __('Capability'),
			'permit'     => __('Permit').$this->get_sum_label(1),
			'deny'       => __('Deny').$this->get_sum_label(0)
		);
	}

	private function get_sum_label($type) {
		return ' <span class="hide-if-no-js">(<span class="sum-'.$type.'">0</span>)</span>';
	}

	/**
	 * Columns to make sortable.
	 *
	 * @since  0.8
	 * @return array
	 */
	public function get_sortable_columns() {
		return array();
	}

	/**
	 * Primary column used for responsive view
	 *
	 * @since  0.8
	 * @return string
	 */
	protected function get_default_primary_column_name() {
		return 'name';
	}

	/**
	 * Default fallback for column render
	 *
	 * @since  0.8
	 * @param  WP_User  $item
	 * @param  string  $column_name
	 * @return mixed
	 */
	protected function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			default:
				return print_r( $item, true );
		}
	}

	/**
	 * Render name column
	 *
	 * @since  0.8
	 * @param  string  $name
	 * @return string
	 */
	protected function column_name( $name ) {
		return '<strong>'.$name.'</strong>';
	}


	/**
	 * Render permit column
	 *
	 * @since  0.8
	 * @param  string  $user
	 * @return string
	 */
	protected function column_permit( $name ) {
		return $this->_column_cap($name,1);
	}

	/**
	 * Render deny column
	 *
	 * @since  0.8
	 * @param  string  $name
	 * @return string
	 */
	protected function column_deny( $name ) {
		return $this->_column_cap($name,0);
	}

	/**
	 * Helper function for cap checkbox
	 *
	 * @since  0.8
	 * @param  string  $name
	 * @param  int     $value
	 * @return string
	 */
	protected function _column_cap($name,$value) {
		$metadata = RUA_App::instance()->level_manager->metadata()->get('caps')->get_data(get_the_ID());
		return sprintf(
			'<input class="rua-cb" type="checkbox" id="cap-%1$s-%2$d" name="caps[%1$s]" value="%2$d" %3$s/><label class="rua-cb-label rua-cb-label-%2$d" for="cap-%1$s-%2$d"></label>',
			$name,
			$value,
			checked( isset($metadata[$name]) ? $metadata[$name] : null, $value, false )
		);
	}

	/**
	 * Bulk actions
	 *
	 * @since  0.8
	 * @return array
	 */
	public function get_bulk_actions() {
		return array();
	}

	/**
	 * Generate the table navigation above or below the table
	 *
	 * @since 0.8
	 * @param string $which
	 */
	public function display_tablenav( $which ) {
		?>
	<div class="tablenav <?php echo esc_attr( $which ); ?>">

		<?php if ( $this->has_items() ): ?>
		<div class="alignleft actions bulkactions">
			<?php $this->bulk_actions( $which ); ?>
		</div>
		<?php endif;
		$this->extra_tablenav( $which );
		$this->pagination( $which );
?>

		<br class="clear" />
	</div>
<?php
	}

	/**
	 * Render column headers
	 *
	 * @since  0.8
	 * @param  boolean $with_id
	 * @return void
	 */
	public function print_column_headers( $with_id = true ) {
		parent::print_column_headers($with_id);
		if($with_id) {
			$sep = '</tr><tr>';

			$sum_columns = array(
				'deny' => 0,
				'permit' => 1
			);

			//backwards compat
			if(method_exists(get_parent_class($this), 'get_default_primary_column_name')) {
				list( $columns, $hidden, $sortable, $primary ) = $this->get_column_info();
			} else {
				list( $columns, $hidden, $sortable ) = $this->get_column_info();
				$primary = '';
			}

			echo $sep;
			foreach ($columns as $column_key => $column_display) {
				
				$class = array( 'manage-column', "column-$column_key" );

				if ( in_array( $column_key, $hidden ) ) {
					$class[] = 'hidden';
				}

				if(isset($sum_columns[$column_key])) {
					$sum = '<input class="rua-cb js-rua-cb-all" type="checkbox" value="'.$sum_columns[$column_key].'"/>';
				}

				if ( $column_key === $primary ) {
					$class[] = 'column-primary';
				}

				$tag = 'th';
				$scope = 'scope="col"';

				if($column_key == 'name') {
					$sum = __('Select All');
				}

				if ( !empty( $class ) )
					$class = "class='" . implode( ' ', $class ) . "'";

				echo "<$tag $scope $class>$sum</$tag>";
			}
		}
	}

	/**
	 * Get data and set pagination
	 *
	 * @since  0.8
	 * @return void
	 */
	public function prepare_items() {

		$this->_column_headers = $this->get_column_info();

		$capabilities = $this->get_capabilities();
		$per_page     = $this->get_items_per_page( 'caps_per_page', count($capabilities) );
		$current_page = $this->get_pagenum();
		$total_items  = $per_page;

		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'total_pages' => 1,
			'per_page'    => $per_page
		) );
		$this->items = $capabilities;
	}

	public function get_capabilities() {
		global $wp_roles;

		$capabilities = array();
		foreach ( $wp_roles->role_objects as $role ) {
			if ( is_array( $role->capabilities ) ) {
				foreach ( $role->capabilities as $cap => $v ) {
					$capabilities[$cap] = $cap;
				}
			}
		}

		/**
		 * There seems to be consensus among plugin authors
		 * to use this filter
		 *
		 * @see {@link https://wordpress.org/plugins/members/}
		 */
		$capabilities = apply_filters( 'members_get_capabilities', array_values($capabilities) );

		//$capabilities[] = RUA_App::CAPABILITY;
		$capabilities = array_flip($capabilities);

		foreach ($this->get_hidden_capabilities() as $cap) {
			unset($capabilities[$cap]);
		}

		return array_keys( $capabilities );
	}

	public function get_hidden_capabilities() {
		return array(
			'level_0',
			'level_1',
			'level_2',
			'level_3',
			'level_4',
			'level_5',
			'level_6',
			'level_7',
			'level_8',
			'level_9',
			'level_10'
		);
	}
}

//eol