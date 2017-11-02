<?php
function mdocs_dashboard_menu() {
	$current_user = wp_get_current_user();
	$mdocs_allow_upload = get_option('mdocs-allow-upload');
	if(!is_array($mdocs_allow_upload)) $mdocs_allow_upload = array();
	$wp_roles = get_editable_roles();
	if(empty($current_user->roles)) $current_user->roles[0] = 'none';
	if($current_user->roles[0] == 'administrator') {
		$role_object = get_role('administrator');
		$role_object->add_cap( 'mdocs-dashboard');
	}
	foreach($mdocs_allow_upload as $index => $role) {
		if(empty($current_user->roles)) $current_user->roles[0] = 'none';
		if($current_user->roles[0] == $index) {
			$role_object = get_role($index);
			$role_object->add_cap( 'mdocs-dashboard');
		}
	}
	add_menu_page( __('Memphis Documents Library','memphis-documents-library'), __('Memphis Docs','memphis-documents-library'), 'mdocs-dashboard', 'memphis-documents.php', 'mdocs_dashboard', MDOC_URL.'/assets/imgs/kon.ico'  );
	if(get_option('mdocs-disable-bootstrap-admin')) add_submenu_page( 'memphis-documents.php', __('Settings', 'memphis-documents-library'), __('Settings', 'memphis-documents-library'), 'administrator', 'memphis-documents.php&mdocs-cat=settings', 'mdocs_settings' );
}

function mdocs_dashboard() {
	if(isset($_FILES['mdocs']) && $_FILES['mdocs']['name'] != '' && $_POST['mdocs-type'] == 'mdocs-add') mdocs_file_upload();
	elseif(isset($_FILES['mdocs']) && $_POST['mdocs-type'] == 'mdocs-update') mdocs_file_upload();
	elseif(isset($_GET['action']) && $_GET['action'] == 'delete-doc' && !isset($_POST['mdocs-type'])) mdocs_delete();
	elseif(isset($_GET['action']) && $_GET['action'] == 'delete-version') mdocs_delete_version();
	elseif(isset($_POST['action']) && $_POST['action'] == 'mdocs-import') {
		if(mdocs_file_upload_max_size() < $_FILES['mdocs-import-file']['size']) mdocs_errors(MDOCS_ERROR_7, 'error');
		else mdocs_import_zip();
	} elseif(isset($_POST['action']) && $_POST['action'] == 'mdocs-update-revision') mdocs_update_revision();
	elseif(isset($_GET['action']) && $_GET['action'] == 'mdocs-versions') mdocs_versions();
	elseif(isset($_POST['action']) && $_POST['action'] == 'mdocs-update-cats') mdocs_update_cats();
	mdocs_dashboard_view();
}

function mdocs_dashboard_view() {
	if(isset($_GET['mdocs-cat'])) $current_cat = mdocs_sanitize_string($_GET['mdocs-cat']);
	else $current_cat = null;
	if($current_cat == 'import') mdocs_import($current_cat);
	elseif($current_cat == 'export') mdocs_export($current_cat);
	elseif($current_cat == 'cats' && MDOCS_DEV == false) mdocs_edit_cats($current_cat);
	elseif($current_cat == 'cats' && MDOCS_DEV) mdocs_folder_editor($current_cat);
	elseif($current_cat == 'settings') mdocs_settings();
	elseif($current_cat == 'batch') mdocs_batch_upload($current_cat);
	elseif($current_cat == 'short-codes') mdocs_shortcodes($current_cat);
	elseif($current_cat == 'filesystem-cleanup') mdocs_filesystem_cleanup($current_cat);
	elseif($current_cat == 'restore') mdocs_restore_defaults($current_cat);
	elseif($current_cat == 'allowed-file-types') mdocs_allowed_file_types($current_cat);
	elseif($current_cat == 'find-lost-files') mdocs_find_lost_files($current_cat);
	elseif($current_cat == 'server-compatibility') mdocs_server_compatibility($current_cat);
	else echo mdocs_the_list();
}

function mdocs_delete() {
	if ( $_REQUEST['mdocs-nonce'] == MDOCS_NONCE || get_option('mdocs-disable-sessions') == true) {
		$mdocs = get_option('mdocs-list');
		//$mdocs = mdocs_sort_by($mdocs, 0, 'dashboard', false);
		$mdocs = mdocs_array_sort();
		$index = mdocs_sanitize_string($_GET['mdocs-index']);
		$upload_dir = wp_upload_dir();
		$mdocs_file = $mdocs[$index];
		if(is_array($mdocs[$index]['archived'])) foreach($mdocs[$index]['archived'] as $key => $value) @unlink($upload_dir['basedir'].'/mdocs/'.$value);
		wp_delete_attachment( intval($mdocs_file['id']), true );
		wp_delete_post( intval($mdocs_file['parent']), true );
		if(file_exists($upload_dir['basedir'].'/mdocs/'.$mdocs_file['filename'])) @unlink($upload_dir['basedir'].'/mdocs/'.$mdocs_file['filename']);
		unset($mdocs[$index]);
		$mdocs = array_values($mdocs);
		mdocs_save_list($mdocs);
	} else mdocs_errors(MDOCS_ERROR_4,'error');
}

function mdocs_add_update_ajax($edit_type='Add Document') {
	$cats = get_option('mdocs-cats');
	$mdocs = mdocs_array_sort();
	$mdocs_index = '';
	
	if(isset($_POST['mdocs-id'])) {	
		foreach($mdocs as $index => $the_mdoc) {
			if($_POST['mdocs-id'] == $the_mdoc['id']) {
				$mdocs_index = $index; break;
			}
		}
	}
	
	if(!is_string($mdocs_index) && $edit_type == 'Update Document' || $edit_type == 'Add Document') {
		if(mdocs_check_file_rights($mdocs[$mdocs_index]) || $edit_type == 'Add Document') {
			if($edit_type == 'Update Document') $mdoc_type = 'mdocs-update';
			else $mdoc_type = 'mdocs-add';
			// POST CATEGORIES
			$post_categories = wp_get_post_categories($mdocs[$mdocs_index]['parent']);
			if(count($post_categories) > 0) {
				$mdocs[$mdocs_index]['mdocs-categories'] = array();
				foreach($post_categories as $post_cat) {
					$the_category_name = get_the_category_by_ID($post_cat);
					array_push($mdocs[$mdocs_index]['mdocs-categories'], $the_category_name);
				}
			} else $mdocs[$mdocs_index]['mdocs-categories'] = null;
			// POST TAGS
			$post_tags = wp_get_post_tags($mdocs[$mdocs_index]['parent']);
			foreach($post_tags as $post_tag) $the_tags .= $post_tag->name.', ';
			$the_tags = rtrim($the_tags, ', ');
			$mdocs[$mdocs_index]['post-tags'] = $the_tags;
			$date_format = get_option('mdocs-date-format');
			if($edit_type == 'Update Document') {
				$the_date = mdocs_format_unix_epoch($mdocs[$mdocs_index]['modified']);
				$mdocs[$mdocs_index]['gmdate'] = date($date_format, $the_date['date']);
			} else {
				$the_date = mdocs_format_unix_epoch();
				$mdocs[$mdocs_index]['gmdate'] = date($date_format, $the_date['date']);
			}
			echo json_encode($mdocs[$mdocs_index]);
		} else {
			$error['error'] = __('The permission of this file have changed and you no longer have acces to it, please contact the ower of the file.', 'memphis-documents-library')."\n\r";
			$error['error'] .= __('[ File Owner ]', 'memphis-documents-library').' => '.$mdocs[$mdocs_index]['owner']."\n\r";
			echo json_encode($error);
		}
	} else {
		$error['error'] = __('Index value not found, something has gone wrong.', 'memphis-documents-library')."\n\r";
		$error['error'] .= __('[ Index Value ]', 'memphis-documents-library').' => '.$mdocs_index."\n\r";
		$error['error'] .= __('[ Edit Type ]', 'memphis-documents-library').' => '.$edit_type;
		echo json_encode($error);
	}
}

function mdocs_uploader() {
	global $current_user;
	$cats = get_option('mdocs-cats');
	if(is_admin()) {
?>
<div class="row">
	<div class="col-md-12" id="mdocs-add-update-container">
		<div class="page-header">
			<h1 id="mdocs-add-update-header"><?php _e('loading', 'memphis-documents-library'); ?>...</h1>
		</div>
		<div class="">
			<form class="form-horizontal" enctype="multipart/form-data" action="#" method="POST" id="mdocs-add-update-form">
				<input type="hidden" name="mdocs-current-user" value="<?php echo $current_user->user_login; ?>" />
				<input type="hidden" name="mdocs-type" value="" />
				<input type="hidden" name="mdocs-index" value="" />
				<input type="hidden" name="mdocs-cat" value="" />
				<input type="hidden" name="mdocs-pname" value="" />
				<input type="hidden" name="mdocs-nonce" value="<?php echo $_SESSION['mdocs-nonce']; ?>" />
				<input type="hidden" name="mdocs-post-status-sys" value="" />
				
				<div class="well well-lg">
					<div class="page-header">
						<h2><?php _e('File Properties','memphis-documents-library'); ?></h2>
					</div>
					<div class="form-group form-group-lg has-success">
						<label class="col-sm-2 control-label" for="mdocs-name"><?php _e('File Name','memphis-documents-library'); ?></label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="mdocs-name" id="mdocs-name" />
						</div>
					</div>
					<?php
					if(get_option('mdocs-show-upload-folder')) { ?>
					<div class="form-group form-group-lg has-warning">
						<label class="col-sm-2 control-label" for="mdocs-cat"><?php _e('Folder','memphis-documents-library'); ?></label>
						<div class="col-sm-10">
							<select class="form-control" name="mdocs-cat">
							<?php mdocs_display_folder_options_menu($cats); ?>
							</select>
						</div>
					</div>
					<?php
					} else {
						$current_folder = mdocs_get_the_folder();
						echo '<input type=hidden name="mdocs-cat" value="'.$current_folder['slug'].'" >'; 
					}
					if(get_option('mdocs-show-upload-version')) { ?>
					<div class="form-group form-group-lg has-error">
						<label class="col-sm-2 control-label" for="mdocs-version"><?php _e('Version','memphis-documents-library'); ?></label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="mdocs-version" value="1.0" />
						</div>
					</div>
					<?php
					} else {
						echo '<input type=hidden name="mdocs-version" value="1.0" >'; 
					}
					if(get_option('mdocs-show-upload-date')) { ?>
					<div class="form-group form-group-lg" >
						<label class="col-sm-2 control-label" for="mdocs-last-modified"><?php _e('Date','memphis-documents-library'); ?></label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="mdocs-last-modified" value="" />
						</div>
					</div>
					<?php
					} else {
						echo '<input type=hidden name="mdocs-last-modified" value="" >'; 
					}?>
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label" for="mdocs"><?php _e('File Uploader','memphis-documents-library'); ?></label>
						<div class="col-sm-10">
							<input class="form-control" type="file" name="mdocs" />
							<p class="help-block" id="mdocs-current-doc"></p>
						</div>
					</div>
					<?php
					if(get_option('mdocs-show-upload-file-status')) { ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="mdocs-file-status"><?php _e('File Status','memphis-documents-library'); ?></label>
						<div class="col-sm-10">
							<select class="form-control input-lg" name="mdocs-file-status" id="mdocs-file-status" >
								<option value="public" ><?php _e('Public','memphis-documents-library'); ?></option>
								<option value="hidden" ><?php _e('Hidden','memphis-documents-library'); ?></option>
							</select>
						</div>
					</div>
					<?php
					} else {
						echo '<input type=hidden name="mdocs-file-status" value="public" >'; 
					}
					if(get_option('mdocs-show-upload-post-status')) { ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="mdocs-post-status"><?php _e('Post Status','memphis-documents-library'); ?></label>
						<div class="col-sm-10">
							<select class="form-control input-lg" name="mdocs-post-status" id="mdocs-post-status" >
								<option value="publish" ><?php _e('Published','memphis-documents-library'); ?></option>
								<option value="private" ><?php _e('Private','memphis-documents-library');  ?></option>
								<option value="pending"  ><?php _e('Pending Review','memphis-documents-library');  ?></option>
								<option value="draft" ><?php _e('Draft','memphis-documents-library');  ?></option>
							</select>
						</div>
					</div>
					<?php
					} else {
						echo '<input type=hidden name="mdocs-post-status" value="publish" >'; 
					} ?>
					<div class="form-group">
						<?php
						if(get_option('mdocs-show-upload-social')) { ?>
						<label class="col-sm-2 control-label" for="mdocs-social"><?php _e('Show Social Apps','memphis-documents-library'); ?></label>
						<div class="col-sm-1">
							<input class="form-control" type="checkbox" name="mdocs-social" checked />
						</div>
						<?php
						} else {
							echo '<input type="hidden" name="mdocs-social" value="on" />';
						}
						if(get_option('mdocs-show-non-members')) { ?>
						<label class="col-sm-3 control-label" for="mdocs-non-members"><?php _e('Downloadable by Non Members','memphis-documents-library'); ?></label>
						<div class="col-sm-1">
							<input class="form-control" type="checkbox" name="mdocs-non-members" checked />
						</div>
						<?php
						} else {
							echo '<input type="hidden" name="mdocs-non-members" value="on" />';
						} ?>
					</div>
					<?php
					
					if(get_option('mdocs-show-upload-contributors')) { ?>
					<div class="form-group form-group-lg" >
						<label class="col-sm-2 control-label" for="mdocs-social"><?php _e('Contributors','memphis-documents-library'); ?></label>
						<div class="col-sm-10">
							<div class="mdocs-add-contributor-container" data-contributor-type="add-update">
								<div class="mdocs-contributors-container">
									<button type="button" class="btn btn-primary" id="mdocs-current-owner"></button>
								</div>
							
								<input autocomplete="off" class="form-control mdocs-add-contributors" type="text" name="mdocs-add-contributors" id="" placeholder="<?php _e('Add contributor, users and roles types are allowed.', 'memphis-documents-library'); ?>"/>
								<div class="mdocs-user-search-list hidden" ></div>
							</div>
						</div>
					</div>
					<?php
					}
					if(get_option('mdocs-show-upload-real-author')) { ?>
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label" for="mdocs-real-author"><?php _e('Author','memphis-documents-library'); ?></label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="mdocs-real-author" id="mdocs-real-author" placeholder="<?php _e('Type the name of the author.', 'memphis-documents-library'); ?>" />
						</div>
					</div>
					<?php
					} else {
						echo '<input type=hidden name="mdocs-tags" value="" >';
					}
					if(get_option('mdocs-show-upload-tags')) { ?>
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label" for="mdocs-tags"><?php _e('Tags','memphis-documents-library'); ?></label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="mdocs-tags" id="mdocs-tags" placeholder="<?php _e('Comma Separated List', 'memphis-documents-library'); ?>" />
						</div>
					</div>
					<?php
					} else {
						echo '<input type=hidden name="mdocs-tags" value="" >';
					}
					if(get_option('mdocs-show-upload-categories')) {
						$args = array("hide_empty" => 0, "type" => "post", "orderby" => "name", "order" => "ASC" );
						$categories = get_categories($args);
					?>
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label" for="mdocs-categories"><?php _e('Categories','memphis-documents-library'); ?></label>
						<div class="col-sm-10">
							<select multiple class="form-control" name="mdocs-categories[]" id="mdocs-post-categories">
								<?php
									foreach($categories as $cat_index => $category) {
										echo '<option value="'.$category->name.'">'.$category->name.'</option>';
									}
								?>
							</select>
						</div>
					</div>
					<?php
					} else {
						echo '<input type=hidden name="mdocs-categories" value="" >';
					}
					if(get_option('mdocs-show-upload-description')) { ?>
					<div class="form-group">
						<div class="page-header">
							<h2><?php _e('Description','memphis-documents-library'); ?></h2>
							<br>
							<?php
							$editor_settings = array('media_buttons' => false,);
							wp_editor('', "mdocs-desc", $editor_settings);
							?>
						</div>
					</div>
					<?php
					} else {
						echo '<input type=hidden name="mdocs-desc" value="" >';
					}
					
					?>
				</div>
				
				<input type="submit" class="btn btn-primary" id="mdocs-save-doc-btn" value="" />
				
			</form>
		</div>
	</div>
</div>
	
<?php
	}
}
?>