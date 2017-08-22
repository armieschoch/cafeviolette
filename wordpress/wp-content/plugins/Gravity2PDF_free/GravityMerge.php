<?php
/**
 * Plugin Name: Gravity 2 PDF - Free
 * Plugin URI:  https://www.gravity2pdf.com
 * Description: Convert Gravity Form data to Pdf Form Data
 * Version:     2.1.10
 * Author:      gravity2pdf
 * Author URI:  https://github.com/raphcadiz
 * Text Domain: gravity-merge
 */

define( 'GM_PATH', dirname( __FILE__ ) );
define( 'GM_PATH_INCLUDES', dirname( __FILE__ ) . '/includes' );
define( 'GM_PATH_LIBRARY', dirname( __FILE__ ) . '/lib' );
define( 'GM_PATH_CLASS', dirname( __FILE__ ) . '/class' );
define( 'GM_FOLDER', basename( GM_PATH ) );
define( 'GM_URL', plugins_url() . '/' . GM_FOLDER );
define( 'GM_URL_INCLUDES', GM_URL . '/includes' );
define( 'GM_URL_LIB', GM_URL . '/lib' );
define( 'GM_URL_CLASS', GM_URL . '/class' );
define( 'GM_VERSION', '2.1.10' );

if(!class_exists('Gravity_Merge')):

	register_activation_hook( __FILE__, 'activation' );
	function activation(){
		if ( ! class_exists('GFForms') ) {
	        deactivate_plugins( plugin_basename( __FILE__ ) );
	        wp_die('Sorry, but this plugin requires the Gravity Forms to be installed and active.');
	    }

		$gmerge_db = new Gravity_Merge_Db;
		$gmerge_db->install();
	}

	function deactivation(){
		// deactivation actions
	}

	add_action( 'admin_init', 'add_plugin_caps');
	function add_plugin_caps() {
	    $role = get_role( 'administrator' );

	    $role->add_cap( 'gravity2pdf_create' );
	    $role->add_cap( 'gravity2pdf_manage' );
	    $role->add_cap( 'gravity2pdf_status' );
	    $role->add_cap( 'gravity2pdf_manage_settings' );
	}

	add_action( 'admin_init', 'plugin_activate' );
	function plugin_activate(){
	    if ( ! class_exists('GFForms') ) {
	        deactivate_plugins( plugin_basename( __FILE__ ) );
	    }
	}

	// require library autoload
	require_once(GM_PATH_LIBRARY.'/vendor/autoload.php');

	// include classes
	include_once(GM_PATH_CLASS.'/gravity_merge_main.class.php');
	include_once(GM_PATH_CLASS.'/gravity_merge_pages.class.php');
	include_once(GM_PATH_CLASS.'/gravity_merge_settings.class.php');
	include_once(GM_PATH_CLASS.'/gravity_merge_integrations.class.php');
	include_once(GM_PATH_CLASS.'/gravity_merge_db.class.php');
	include_once(GM_PATH_CLASS.'/pdftk-live-api-library.php');
	include_once(GM_PATH_CLASS.'/gravity_merges.class.php');
	include_once(GM_PATH_CLASS.'/gravity_merge_send.class.php');

	add_action( 'plugins_loaded', array( 'Gravity_Merge', 'get_instance' ) );
endif;

/*
 * https://github.com/raphcadiz
 */