<?php
/*
Plugin Name: Memphis Documents Library
Plugin URI: http://www.kingofnothing.net/memphis-documents-library/
Description: A documents repository for WordPress. 
Author: Ian Howatson
Version: 3.7.2.2
Text Domain: memphis-documents-library
Domain Path: /languages
Author URI: http://www.kingofnothing.net/
Date: 10/20/2017

Copyright 2017 Ian Howatson  (email : ian@howatson.net)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
// ********** MEMPHIS DOCUMENTS DEVELOPMENT *********************//
define('MDOCS_DEV', false);
define('MDOCS_SESSION_ID', md5('Memphis Documents Library Version 3.7.2.1'));
define('MDOC_PATH',plugin_dir_path(__FILE__));
define('MDOC_URL',plugin_dir_url(__FILE__));
define('MDOCS_INCLUDE_PATH', 'includes/');
if(MDOCS_DEV) error_reporting(E_ALL);
//*************************************************************************************//
include MDOCS_INCLUDE_PATH.'mdocs-allowed-file-types.php';
include MDOCS_INCLUDE_PATH.'mdocs-batch-file-methods.php';
include MDOCS_INCLUDE_PATH.'mdocs-batch-upload.php';
include MDOCS_INCLUDE_PATH.'mdocs-box-view.php';
include MDOCS_INCLUDE_PATH.'mdocs-categories.php';
include MDOCS_INCLUDE_PATH.'mdocs-dashboard.php';
include MDOCS_INCLUDE_PATH.'mdocs-doc-preview.php';
include MDOCS_INCLUDE_PATH.'mdocs-donate.php';
include MDOCS_INCLUDE_PATH.'mdocs-downloads.php';
include MDOCS_INCLUDE_PATH.'mdocs-export.php';
include MDOCS_INCLUDE_PATH.'mdocs-file-info-small.php';
include MDOCS_INCLUDE_PATH.'mdocs-filenames-to-latin.php';
include MDOCS_INCLUDE_PATH.'mdocs-filesystem-cleanup.php';
include MDOCS_INCLUDE_PATH.'mdocs-find-lost-files.php';
include MDOCS_INCLUDE_PATH.'mdocs-folder-editor.php';
include MDOCS_INCLUDE_PATH.'mdocs-functions.php';
include MDOCS_INCLUDE_PATH.'mdocs-import.php';
include MDOCS_INCLUDE_PATH.'mdocs-inline-styles.php';
include MDOCS_INCLUDE_PATH.'mdocs-localization.php';
include MDOCS_INCLUDE_PATH.'mdocs-modals.php';
include MDOCS_INCLUDE_PATH.'mdocs-options.php';
include MDOCS_INCLUDE_PATH.'mdocs-patches.php';
include MDOCS_INCLUDE_PATH.'mdocs-post-page.php';
include MDOCS_INCLUDE_PATH.'mdocs-ratings.php';
include MDOCS_INCLUDE_PATH.'mdocs-restore-defaults.php';
include MDOCS_INCLUDE_PATH.'mdocs-rights.php';
include MDOCS_INCLUDE_PATH.'mdocs-server-compatibility.php';
include MDOCS_INCLUDE_PATH.'mdocs-settings-page.php';
include MDOCS_INCLUDE_PATH.'mdocs-settings.php';
include MDOCS_INCLUDE_PATH.'mdocs-shortcodes.php';
include MDOCS_INCLUDE_PATH.'mdocs-social.php';
include MDOCS_INCLUDE_PATH.'mdocs-sort.php';
include MDOCS_INCLUDE_PATH.'mdocs-the-list.php';
include MDOCS_INCLUDE_PATH.'mdocs-update-mime.php';
include MDOCS_INCLUDE_PATH.'mdocs-upload.php';
include MDOCS_INCLUDE_PATH.'mdocs-versions.php';
include MDOCS_INCLUDE_PATH.'mdocs-widgets.php';
if(!headers_sent() && stripos($_SERVER['REQUEST_URI'], '/feed') === false) add_action('send_headers', 'mdocs_send_headers');
elseif (stripos($_SERVER['REQUEST_URI'], '/feed') === false) {
	//$file = '';
	//$line = '';
	//$message = sprintf('Premature output is preventing Memphis Documents Library from working properly. Outputs has started in %s on line %d.', $file, $line);
	//echo '<div style="border: 1em solid red; background: #fff; color: #f00; margin:2em; padding: 1em;">', htmlspecialchars($message), '</div>';
	//trigger_error($message);
	//die();	
}
/* MDOCS ACTION HOOKS */
if ( is_admin()) {
	add_action('admin_init', 'mdocs_send_headers_dashboard');
	add_action('admin_init','mdocs_register_settings');
	add_action('admin_enqueue_scripts', 'mdocs_admin_script');
	add_action('admin_menu', 'mdocs_dashboard_menu');
	add_action('admin_footer', 'mdocs_document_ready_admin');
}
add_action('init', 'mdocs_nonce', 1);
add_action( 'init', 'mdocs_init_post_pages' );
add_action('init', 'mdocs_localized_errors');
add_action( 'wp_enqueue_scripts', 'mdocs_script' );
add_action('wp_head', 'mdocs_document_ready_wp');
add_action( 'widgets_init', 'mdocs_widgets' );
add_action('plugins_loaded', 'mdocs_localization');
add_action( 'wp_ajax_nopriv_mdocs_ajax', 'mdocs_ajax_processing' );
add_action( 'wp_ajax_mdocs_ajax', 'mdocs_ajax_processing' );

function add_taxonomies_to_pages() {
 register_taxonomy_for_object_type( 'category', 'mdocs-posts' );
 }
add_action( 'init', 'add_taxonomies_to_pages' );


?>