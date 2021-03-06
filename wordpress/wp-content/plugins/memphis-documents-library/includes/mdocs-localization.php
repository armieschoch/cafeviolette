<?php
// LOCALIZATION INIT
function mdocs_localization() {
	//FOR TESTING LANG FILES
	//global $locale; $locale = 'pt_BR';
	$loaded = load_plugin_textdomain('mdocs', false, 'memphis-documents-library/languages/' );
}
//PASS VARIABLES TO JAVASCRIPT
function mdocs_js_handle($script) {
	wp_localize_script( $script, 'mdocs_js', array(
		'version_file' => __("You are about to delete this file.  Once deleted you will lose this file!\n\n'Cancel' to stop, 'OK' to delete.",'memphis-documents-library'),
		'version_delete' => __("You are about to delete this version.  Once deleted you will lose this version of the file!\n\n'Cancel' to stop, 'OK' to delete.",'memphis-documents-library'),
		'category_delete' => __("You are about to delete this folder.  Any file in this folder will be lost!\n\n'Cancel' to stop, 'OK' to delete.",'memphis-documents-library'),
		'remove' => __('Remove','memphis-documents-library'),
		'new_category' => __('New Folder','memphis-documents-library'),
		'leave_page' => __('Are you sure you want to navigate away from this page?','memphis-documents-library'),
		'category_support' => __('Currently Memphis Documents Library only supports two sub categories.','memphis-documents-library'),
		'restore_warning' => __('Are you sure you want continue.  All you files, posts and directories will be delete.','memphis-documents-library'),
		'add_folder' => __('Add Folder', 'memphis-documents-library'),
		'update_doc' => __('Updating Document', 'memphis-documents-library'),
		'update_doc_btn' => __('Update Document' , 'memphis-documents-library'),
		'add_doc' => __('Adding Document', 'memphis-documents-library'),
		'add_doc_btn' => __('Add Document', 'memphis-documents-library'),
		'current_file' => __('Current File','memphis-documents-library'),
		'patch_text_3_0_1' => __('UPDATE HAS STARTER, DO NOT LEAVE THIS PAGE!', 'memphis-documents-library'),
		'patch_text_3_0_2' => __('Go grab a coffee this my take awhile.', 'memphis-documents-library'),
		'create_export_file' => __('Creating the export file, please be patient.', 'memphis-documents-library'),
		'export_creation_complete_starting_download' => __('Export file creation complete, staring download of zip file.', 'memphis-documents-library'),
		'sharing' => __('Sharing', 'memphis-documents-library'),
		'download_page' => __('Download Page', 'memphis-documents-library'),
		'direct_download' => __('Direct Download', 'memphis-documents-library'),
		'levels'=> 2,
		'blog_id' => get_current_blog_id(),
		'plugin_url' => plugins_url().'/memphis-documents-library/',
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'dropdown_toggle_fix' => get_option('mdocs-dropdown-toggle-fix'),
		'mdocs_debug' => MDOCS_DEV,
		'mdocs_debug_text' => __('MDOCS DEVELOPMENT VERSION', 'memphis-documents-library').'<br>'.__('[ ALL ERRORS ARE BEING REPORTED ]', 'memphis-documents-library'),
		'mdocs_ajax_nonce' => wp_create_nonce('mdocs-ajax-nonce'),
	));
}
// PROCESS AJAX REQUESTS
function mdocs_ajax_processing() {
	if(check_ajax_referer( 'mdocs-ajax-nonce', '_mdocs_ajax_nonce',false)) {
		if(isset($_POST['type']) && $_POST['type'] != 'batch-edit-save' && $_POST['type'] != 'batch-move-save' && $_POST['type'] != 'batch-delete-save') $_POST = mdocs_sanitize_array($_POST);
		switch($_POST['type']) {
			case 'update-date':
				if(current_user_can('mdocs-dashboard')) echo json_encode(mdocs_format_unix_epoch());
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'preview':
				mdocs_load_preview();
				break;
			case 'show':
				mdocs_load_preview();
				break;
			case 'desc':
				mdocs_load_preview();
				break;
			case 'add-mime':
				if(current_user_can('manage_options')) mdocs_update_mime();
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'remove-mime':
				if(current_user_can('manage_options')) mdocs_update_mime();
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'restore-mime':
				if(current_user_can('manage_options')) mdocs_update_mime();
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'restore':
				if(current_user_can('manage_options')) mdocs_restore_default();
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'sort':
				mdocs_sort();
				break;
			case 'rating':
				mdocs_ratings();
				break;
			case 'versions':
				mdocs_show_versions();
				break;
			case 'rating-submit':
				if(current_user_can('manage_options')) mdocs_set_rating(intval($_POST['mdocs_file_id']));
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'add-doc':
				if(current_user_can('mdocs-dashboard')) mdocs_add_update_ajax('Add Document');
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'update-doc':
				if(current_user_can('mdocs-dashboard')) mdocs_add_update_ajax('Update Document');
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'mdocs-v3-0-patch':
				if(current_user_can('manage_options')) mdocs_box_view_update_v3_0();
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'mdocs-v3-0-patch-run-updater':
				if(current_user_can('manage_options')) mdocs_v3_0_patch_run_updater();
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'mdocs-v3-0-patch-cancel-updater':
				if(current_user_can('manage_options')) mdocs_v3_0_patch_cancel_updater();
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'search-users':
				if(current_user_can('manage_options')) mdocs_search_users($_POST['user-search-string'], $_POST['owner'], $_POST['contributors']);
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'show-social':
				echo mdocs_social(intval($_POST['doc-id']));
				break;
			case 'box-view-refresh':
				if(current_user_can('manage_options')) {
					$mdocs = mdocs_array_sort();
					$file = get_site_url().'/?mdocs-file='.$mdocs[$_POST['index']]['id'].'&mdocs-url=false&is-box-view=true';
					$boxview = new mdocs_box_view();
					$results = $boxview->uploadFile($file);
					$mdocs[$_POST['index']]['box-view-id'] = $results['id'];
					update_option('mdocs-list', $mdocs);
					echo '<div class="alert alert-success" role="alert" id="box-view-updated">'.$mdocs[$_POST['index']]['filename'].' '.__('preview has been updated.', 'memphis-documents-library').'</div>';
				} else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'lost-file-search-start':
				if(current_user_can('manage_options')) find_lost_files();
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'lost-file-save':
				if(current_user_can('manage_options')) save_lost_files();
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'mdocs-export':
				if(current_user_can('manage_options')) {
					mdocs_export_zip();
					mdocs_download_export_file($_POST['zip-file']);
				} else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'mdocs-export-cleanup':
				if(current_user_can('manage_options')) {
					if($_POST['mdocs-export-donot-delete'] == '') unlink(sys_get_temp_dir().'/mdocs-export.zip');
				} else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'mdocs-cat-index':
				$check_index = intval($_POST['check-index']);
				do {
					$found = mdocs_find_cat('mdocs-cat-'.$check_index);
					$empty_index = $check_index;
					$check_index++;
				} while ($found == true);
				update_option('mdocs-num-cats', $empty_index);
				echo $empty_index;
				break;
			case 'batch-edit':
				if(current_user_can('mdocs-dashboard')) mdocs_batch_edit();
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'batch-edit-save':
				if(current_user_can('mdocs-dashboard')) mdocs_batch_edit_save();
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'batch-move':
				if(current_user_can('mdocs-dashboard')) mdocs_batch_move();
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'batch-move-save':
				if(current_user_can('mdocs-dashboard')) mdocs_batch_move_save();
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'batch-delete':
				if(current_user_can('mdocs-dashboard')) mdocs_batch_delete();
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
			case 'batch-delete-save':
				if(current_user_can('mdocs-dashboard')) mdocs_batch_delete_save();
				else die(__('You are unauthorized to do this.', 'memphis-documents-library'));
				break;
		}
	} else {
		wp_die(__("\n\nmDocs Error: Memphis has terminated due to a faulty nonce check.  This check is needed to deter Cross-site scripting security vulnerabilities.\n\n", 'memphis-documents-library'));
	}
	exit;
}
function mdocs_localized_errors() {
	//ERRORS
	define('MDOCS_ERROR_1',__('No file was uploaded, please try again.','memphis-documents-library'));
	define('MDOCS_ERROR_2',__('Sorry, this file type is not permitted for security reasons.  If you want to add this file type please goto the setting page of Memphis Documents Library and add it to the Allowed File Type menu.','memphis-documents-library'));
	define('MDOCS_ERROR_3',__('No folders found.  The upload process can not proceed.','memphis-documents-library'));
	define('MDOCS_ERROR_4',__('Your submission failed, either you tried to resubmit a form or you are having issue with sessions.<br>If the problem persists contact your administrator and tell them to disable sessions from the Memphis Documents Library setting menu.','memphis-documents-library'));
	define('MDOCS_ERROR_5', __('File Upload Error.  Please try again.','memphis-documents-library'));
	define('MDOCS_ERROR_6', __('You are already at the most recent version of this document.','memphis-documents-library'));
	define('MDOCS_ERROR_7', __('The import file is too large, please update your php.ini files upload_max_filesize.','memphis-documents-library'));
	define('MDOCS_ERROR_8', __('An error occurred when creating a folder, please try again.','memphis-documents-library'));
	define('MDOCS_ERROR_9', __('You have reached the maxium number of input variable allowed for your servers configuration, this means you can not edit folders anymore.  To be able to edit folders again, please increase the variable max_input_vars in your php.ini file.','memphis-documents-library'));
}
?>