<?php

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Merge_List extends WP_List_Table {
	
	public function __construct() {
		
		parent::__construct( [
			'singular' => __( 'Merge', 'gravity-merge' ), //singular name of the listed records
			'plural'   => __( 'Merges', 'gravity-merge' ), //plural name of the listed records
			'ajax'     => false //should this table support ajax?
		] );

	}

	public static function get_merges( $per_page = 10, $page_number = 1 ) {
		global $wpdb;

	  	$sql = "SELECT * FROM {$wpdb->prefix}gm_merges";

	  	if ( ! empty( $_REQUEST['orderby'] ) ) {
	    	$sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
	    	$sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
	  	}

	 	$sql .= " LIMIT $per_page";

	  	$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;


	  	$result = $wpdb->get_results( $sql );

	 	return $result;

	}

	public static function delete_merge( $id ) {
	 	global $wpdb;

	  	$wpdb->delete(
	    	"{$wpdb->prefix}gm_merges",
	    	[ 'ID' => $id ],
	    	[ '%d' ]
	  	);
	}

	public static function record_count() {
	  	global $wpdb;

	  	$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}gm_merges";

	  	return $wpdb->get_var( $sql );
	}

	/** Text displayed when no customer data is available */
	public function no_items() {
	  _e( 'No merges avaliable.', 'gravity-merge' );
	}

	public function column_name( $item ) {
	  	// create a nonce
	  	$delete_nonce = wp_create_nonce( 'sp_delete_merge' );

	  	$title = '<strong><a href="'.admin_url().'admin.php?page=gravitymerge&action=update&id='.$item->id.'">' . $item->name . '</a></strong>';

	  	$actions = [
	  		'edit' => '<a href="?page=gravitymerge&action=update&id='.$item->id.'">Edit</a>',
	    	'delete' => sprintf( '<a href="?page=%s&action=%s&merge=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item->id ), $delete_nonce )
	  	];

	  	return $title . $this->row_actions( $actions );
	}

	public function column_cb( $item ) {
	  	return sprintf(
	    	'<input type="checkbox" name="bulk-delete[]" value="%s" />', $item->id
	  	);
	}

	public function get_columns() {
	  	$columns = [
	    	'cb'      => '<input type="checkbox" />',
	    	'name'    => __( 'Name', 'gravity-merge' )
	  	];

	  return $columns;
	}

	public function get_sortable_columns() {
	  	$sortable_columns = array(
	    	'name' => array( 'name', true )
	  	);

	  	return $sortable_columns;
	}

	public function get_bulk_actions() {
	  	$actions = [
	    	'bulk-delete' => 'Delete'
	  	];

	  	return $actions;
	}

	/**
	 * Handles data query and filter, sorting, and pagination.
	 */
	public function prepare_items() {

	  	$this->_column_headers = $this->get_column_info();

	  	/** Process bulk action */
	  	$this->process_bulk_action();

	  	$per_page     = $this->get_items_per_page( 'merges_per_page', 5 );
	  	$current_page = $this->get_pagenum();
	  	$total_items  = self::record_count();

	  	$this->set_pagination_args( [
	    	'total_items' => $total_items, //WE have to calculate the total number of items
	    	'per_page'    => $per_page //WE have to determine how many items to show on a page
	  	] );


	  	$this->items = self::get_merges( $per_page, $current_page );
	}

	public function process_bulk_action() {

	  	//Detect when a bulk action is being triggered...
	  	if ( 'delete' === $this->current_action() ) {

	    	// In our file that handles the request, verify the nonce.
	    	$nonce = esc_attr( $_REQUEST['_wpnonce'] );

		    if ( ! wp_verify_nonce( $nonce, 'sp_delete_merge' ) ) {
		      die( 'Go get a life script kiddies' );
		    }
		    else {
		      self::delete_merge( absint( $_GET['merge'] ) );
		    }

	  	}

	  	// If the delete bulk action is triggered
	  	if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
	      	 || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
	  	) {

	    	$delete_ids = esc_sql( $_POST['bulk-delete'] );

	    	// loop over the array of record IDs and delete them
	    	foreach ( $delete_ids as $id ) {
	      		self::delete_merge( $id );
			}
	  }
	}
}