<?php
function mdocs_file_upload() {
	$current_user = wp_get_current_user();
	$mdocs = mdocs_array_sort();
	$mdocs_cats = get_option('mdocs-cats');
	foreach($mdocs as $index => $doc) {
		if($_POST['mdocs-index'] == $doc['id']) {
			$mdocs_index = $index; break;
		}
	}
	$_POST = mdocs_sanitize_array($_POST);
	$_FILES['mdocs'] = mdocs_sanitize_array($_FILES['mdocs']);
	if(get_option('mdocs-convert-to-latin')) $_FILES['mdocs']['name'] = mdocs_filenames_to_latin($_FILES['mdocs']['name']);
	$file_info = pathinfo($_FILES['mdocs']['name']);
	$mdocs_name = $_POST['mdocs-name'];
	if($_FILES['mdocs']['name'] != '')	$mdocs_fle_type = strtolower($file_info['extension']);
	else $mdocs_fle_type = '';
	$mdocs_fle_size = $_FILES["mdocs"]["size"];
	$mdocs_type = $_POST['mdocs-type'];
	$mdocs_cat = $_POST['mdocs-cat'];
	$mdocs_desc = wpautop($_POST['mdocs-desc']);
	$mdocs_version = $_POST['mdocs-version'];
	if(isset($_POST['mdocs-social'])) $mdocs_social = $_POST['mdocs-social'];
	else $mdocs_social = false;
	$mdocs_non_members = @$_POST['mdocs-non-members'];
	$mdocs_file_status = $_POST['mdocs-file-status'];
	$mdocs_doc_preview = @$_POST['mdocs-doc-preview'];
	if(!isset($_POST['mdocs-contributors']))  $_POST['mdocs-contributors'] = array();
	else $_POST['mdocs-contributors'] = array_values($_POST['mdocs-contributors']);
	if(isset($_POST['mdocs-post-status'])) $mdocs_post_status = $_POST['mdocs-post-status'];
	else $mdocs_post_status = $_POST['mdocs-post-status-sys'];
	if(!isset($_POST['mdocs-real-author'])) $_POST['mdocs-real-author'] = '';
	$upload_dir = wp_upload_dir();	
	$mdocs_user = $current_user->user_login;
	if($mdocs_file_status == 'hidden') $mdocs_post_status_sys = 'draft';
	else $mdocs_post_status_sys = $mdocs_post_status;
	$the_post_status = $mdocs_post_status_sys;
	$_FILES['mdocs']['post_status'] = $the_post_status;
	
	//MDOCS FILE TYPE VERIFICATION	
	$mimes = get_allowed_mime_types();
	$valid_mime_type = false;
	foreach ($mimes as $type => $mime) {
		$file_type = wp_check_filetype($_FILES['mdocs']['name']);
		$found_ext = stripos($type,$file_type['ext']);
		if($found_ext !== false) {
			$valid_mime_type = true;
			break;
		}
	}
	//MDOCS NONCE VERIFICATION
	if(mdocs_is_sessions_enabled() == false) mdocs_errors(__('Memphis Documents Library requires sessions to be enable.  Please configure your server to allow for sessions.','memphis-documents-library'), 'error');
	if($_FILES['mdocs']['size'] < mdocs_file_upload_max_size()) { 
		if ($_REQUEST['mdocs-nonce'] == MDOCS_NONCE || get_option('mdocs-disable-sessions') == true) {
			if(!empty($mdocs_cats)) {
				if($mdocs_type == 'mdocs-add') {
					if($valid_mime_type) {
						$_FILES['mdocs']['post-status'] = $mdocs_post_status;
						$upload = mdocs_process_file($_FILES['mdocs'], false);
						if($mdocs_version == '') $mdocs_version = '1.0';
						//elseif(!is_numeric($mdocs_version)) $mdocs_version = '1.0';
						if(!isset($upload['error'])) {
							if(get_option('mdocs-preview-type') == 'box' && get_option('mdocs-box-view-key') != '') {
								$boxview = new mdocs_box_view();
								$boxview_file = $boxview->uploadFile(get_site_url().'/?mdocs-file='.$upload['attachment_id'].'&mdocs-url=false&is-box-view=true', $upload['filename']);
								if(!isset($boxview_file['id'])) $boxview_file['id'] = 0;
							} else $boxview_file['id'] = 0;
							array_push($mdocs, array(
								'id'=>(string)$upload['attachment_id'],
								'parent'=>(string)$upload['parent_id'],
								'filename'=>$upload['filename'],
								'name'=>$upload['name'],
								'desc'=>$upload['desc'],
								'type'=>$mdocs_fle_type,
								'cat'=>$mdocs_cat,
								'owner'=>$mdocs_user,
								'contributors'=>$_POST['mdocs-contributors'],
								'author'=>$_POST['mdocs-real-author'],
								'size'=>intval($mdocs_fle_size),
								'modified'=>$upload['modified'],
								'version'=>(string)$mdocs_version,
								'show_social'=>(string)$mdocs_social,
								'non_members'=> (string)$mdocs_non_members,
								'file_status'=>(string)$mdocs_file_status,
								'post_status'=> (string)$mdocs_post_status,
								'post_status_sys'=> (string)$mdocs_post_status_sys,
								'doc_preview'=>(string)$mdocs_doc_preview,
								'downloads'=>intval(0),
								'archived'=>array(),
								'ratings'=>array(),
								'rating'=>intval(0),
								'box-view-id' => $boxview_file['id'],
							));
							$mdocs = mdocs_array_sort($mdocs);
							mdocs_save_list($mdocs);
						} else mdocs_errors($upload['error'],'error');
					} else mdocs_errors(MDOCS_ERROR_2 , 'error');
				} elseif($mdocs_type == 'mdocs-update') {
					if($_FILES['mdocs']['name'] != '') {
						if($valid_mime_type) {
							$old_doc = $mdocs[$mdocs_index];
							$old_doc_name = $old_doc['filename'].'-v'.preg_replace('/ /', '',$old_doc['version']);
							@rename($upload_dir['basedir'].'/mdocs/'.$old_doc['filename'],$upload_dir['basedir'].'/mdocs/'.$old_doc_name);
							$name = substr($old_doc['filename'], 0, strrpos($old_doc['filename'], '.') );
							$filename = $file_info['basename']; 	// old value $name.'.'.$mdocs_fle_type;
							$_FILES['mdocs']['name'] = $filename;
							$_FILES['mdocs']['parent'] = $old_doc['parent'];
							$_FILES['mdocs']['id'] = $old_doc['id'];
							$_FILES['mdocs']['post-status'] = $mdocs_post_status;
							$upload = mdocs_process_file($_FILES['mdocs']);
							if(!isset($upload['error'])) {
								if(get_option('mdocs-preview-type') == 'box' && get_option('mdocs-box-view-key') != '') {
									$boxview = new mdocs_box_view();
									$boxview_file = $boxview->uploadFile(get_site_url().'/?mdocs-file='.$old_doc['id'].'&mdocs-url=false&is-box-view=true', $filename);
								} else $boxview_file['id'] = 0;
								if($mdocs_version == '') $mdocs_version = '1.0';
								elseif($mdocs_version == $mdocs[$mdocs_index]['version']) $mdocs_version = mdocs_increase_minor_version($mdocs[$mdocs_index]['version']);
								
								
								
								
								$mdocs[$mdocs_index]['filename'] = $upload['filename'];
								$mdocs[$mdocs_index]['name'] = $upload['name'];
								$mdocs[$mdocs_index]['desc'] = $upload['desc'];
								$mdocs[$mdocs_index]['version'] = (string)$mdocs_version;
								$mdocs[$mdocs_index]['type'] = (string)$mdocs_fle_type;
								$mdocs[$mdocs_index]['cat'] = $mdocs_cat;
								$mdocs[$mdocs_index]['owner'] = $mdocs[$mdocs_index]['owner'];
								$mdocs[$mdocs_index]['contributors'] = $_POST['mdocs-contributors'];
								$mdocs[$mdocs_index]['author'] = $_POST['mdocs-real-author'];
								$mdocs[$mdocs_index]['size'] = intval($mdocs_fle_size);
								$mdocs[$mdocs_index]['modified'] = $upload['modified'];
								$mdocs[$mdocs_index]['show_social'] =(string)$mdocs_social;
								$mdocs[$mdocs_index]['non_members'] =(string)$mdocs_non_members;
								$mdocs[$mdocs_index]['file_status'] =(string)$mdocs_file_status;
								$mdocs[$mdocs_index]['post_status'] =(string)$mdocs_post_status;
								$mdocs[$mdocs_index]['post_status_sys'] =(string)$mdocs_post_status_sys;
								$mdocs[$mdocs_index]['doc_preview'] =(string)$mdocs_doc_preview;
								$mdocs[$mdocs_index]['box-view-id'] = $boxview_file['id'];
								array_push($mdocs[$mdocs_index]['archived'], $old_doc_name);
								$mdocs = mdocs_array_sort($mdocs);
								mdocs_save_list($mdocs);
							} else mdocs_errors($upload['error'],'error');
						} else mdocs_errors(MDOCS_ERROR_2 , 'error');
					} else {
						$desc = $mdocs_desc;
						if($mdocs_name == '') $mdocs[$mdocs_index]['name'] = $_POST['mdocs-pname'];
						else $mdocs[$mdocs_index]['name'] = $mdocs_name;
						if($mdocs_version == '') $mdocs_version = $mdocs[$mdocs_index]['version'];
						$mdocs[$mdocs_index]['desc'] = $desc;
						$mdocs[$mdocs_index]['version'] = (string)$mdocs_version;
						$mdocs[$mdocs_index]['cat'] = $mdocs_cat;
						$mdocs[$mdocs_index]['owner'] = $mdocs[$mdocs_index]['owner'];
						$mdocs[$mdocs_index]['contributors'] = $_POST['mdocs-contributors'];
						$mdocs[$mdocs_index]['author'] = $_POST['mdocs-real-author'];
			
						$date = mdocs_format_date($_POST['mdocs-last-modified']);
						if($mdocs[$mdocs_index]['modified'] != $date['gmdate']) $mdocs[$mdocs_index]['modified'] = floatval($date['gmdate']);
						
						$mdocs[$mdocs_index]['show_social'] =(string)$mdocs_social;
						$mdocs[$mdocs_index]['non_members'] =(string)$mdocs_non_members;
						$mdocs[$mdocs_index]['file_status'] =(string)$mdocs_file_status;
						$mdocs[$mdocs_index]['post_status'] =(string)$mdocs_post_status;
						$mdocs[$mdocs_index]['post_status_sys'] =(string)$mdocs_post_status_sys;
						$mdocs[$mdocs_index]['doc_preview'] =(string)$mdocs_doc_preview;
						//if($upload['modified'] > time() && $mdocs_post_status === 'publish') $post_status = 'future';
						//else $post_status = (string)$mdocs_post_status;
						$post_status = (string)$mdocs_post_status;
						$mdocs_post = array(
							'ID' => $mdocs[$mdocs_index]['parent'],
							'post_title' => $mdocs[$mdocs_index]['name'],
							//'post_content' => '[mdocs_post_page]',
							'post_status' => $post_status,
							'post_excerpt' => $desc,
							'post_date' => $date['wp-date'],
							'post_date_gmt' => $date['wp-gmdate'],
						);
						$mdocs_post_id = wp_update_post( $mdocs_post );
						if(isset($_POST['mdocs-categories'])) {
							$category_as_id = array();
							foreach($_POST['mdocs-categories'] as $category) array_push($category_as_id, get_cat_ID($category));
							wp_set_post_categories( $mdocs_post_id, $category_as_id );
						}
						wp_set_post_tags($mdocs_post_id, $_POST['mdocs-tags']);
						$mdocs_attachment = array(
							'ID' => $mdocs[$mdocs_index]['id'],
							'post_title' => $mdocs_name
						);
						wp_update_post( $mdocs_attachment );
						$attachment = array(
							'ID' => $mdocs[$mdocs_index]['id'],
							'post_date' => $date['wp-date'],
							'post_date_gmt' => $date['wp-gmdate'],
						);
						$mdocs_attach_id = wp_update_post( $attachment );
						$mdocs = mdocs_array_sort($mdocs);
						mdocs_save_list($mdocs);
					}
				}
			} else mdocs_errors(MDOCS_ERROR_3,'error');
		} else mdocs_errors(MDOCS_ERROR_4,'error');
	} else mdocs_errors(__('The file you are trying to upload is bigger than your php.ini files upload_max_filesize.  You will have to increase that value enable to upload this file.','memphis-documents-library'), 'error');
}

function mdocs_create_document($valid_mime_type) {
	
}
?>