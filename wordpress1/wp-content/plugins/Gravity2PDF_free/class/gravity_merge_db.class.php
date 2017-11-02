<?php
class Gravity_Merge_Db {

	public function install(){
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'gm_merges';

		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name):
			$sql = "CREATE TABLE $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				name VARCHAR(50),
				form_id integer(11),
				details TEXT,
				mapping TEXT,
				integrations TEXT,
				UNIQUE KEY id (id)
			) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			@dbDelta( $sql );
		endif;
	}

	public function insert_merge($data){
		global $wpdb;
		$wpdb->insert( $wpdb->prefix.'gm_merges', $data, array( '%s', '%d', '%s', '%s', '%s' ) );
		
		return $wpdb->insert_id;
	}

	public function update_merge($id, $data){
		global $wpdb;
		$wpdb->update( $wpdb->prefix.'gm_merges', $data, array( 'ID' => $id ), array( '%s', '%d', '%s', '%s', '%s' ), array( '%d' )  );
	}

	public function get_merge($id){
		global $wpdb;
		$table = $wpdb->prefix.'gm_merges';
		$merge = $wpdb->get_row( "SELECT * FROM $table WHERE `id` = $id" );

		return $merge;
	}

	public function get_merge_by_form_id($id){
		global $wpdb;
		$table = $wpdb->prefix.'gm_merges';
		$merges = $wpdb->get_results( "SELECT * FROM $table WHERE `form_id` = $id" );

		return $merges;
	}
}