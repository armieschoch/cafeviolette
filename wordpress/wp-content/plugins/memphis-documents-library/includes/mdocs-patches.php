<?php
function mdocs_patches() {
	//PATCHES
	if(!isset($_GET['restore-default'])) {
		$patches = get_option('mdocs-patches');
		// PATCHES
		// 3.7.1 patch 1
		register_setting('mdocs-patch-vars', 'mdocs-v3-7-1-patch-var-1');
		add_option('mdocs-v3-7-1-patch-var-1',false);
		if(get_option('mdocs-v3-7-1-patch-var-1') == false && is_array(get_option('mdocs-list'))) {
			$show_options = get_option('mdocs-displayed-file-info');
			foreach(get_option('mdocs-displayed-file-info') as $key => $option) {
				if(get_option('mdocs-'.$key) != null && $key != 'show-description') {
					$old_option_value = get_option('mdocs-'.$key);
					if($old_option_value == '1') $show_options[$key]['show'] = true;
					else $show_options[$key]['show'] = false;
				}
			}
			update_option('mdocs-displayed-file-info', $show_options);
			update_option('mdocs-v3-7-1-patch-var-1', true);
		}
		// PATCHES
		// 3.6.13 patch 1
		register_setting('mdocs-patch-vars', 'mdocs-v3-6-13-patch-var-1');
		add_option('mdocs-v3-6-13-patch-var-1',false);
		if(get_option('mdocs-v3-6-13-patch-var-1') == false && is_array(get_option('mdocs-list'))) {
			$mdocs = mdocs_array_sort();
			foreach($mdocs as $index  => $the_mdoc) {	
				$mdocs_post = array(
					'ID' => $the_mdoc['parent'],
					'post_excerpt' => '',
				);
				wp_update_post( $mdocs_post );
				$mdocs_file = array(
					'ID' => $the_mdoc['id'],
					'post_excerpt' => '',
				);
				wp_update_post( $mdocs_file );
			}
			update_option('mdocs-v3-6-13-patch-var-1', true);
		}
		// PATCHES
		// 3.6 patch 1
		register_setting('mdocs-patch-vars', 'mdocs-v3-6-patch-var-1');
		add_option('mdocs-v3-6-patch-var-1',false);
		if(get_option('mdocs-v3-6-patch-var-1') == false && is_array(get_option('mdocs-list'))) {
			update_option('mdocs-hide-file-type-icon', true);
			update_option('mdocs-v3-6-patch-var-1', true);
		}
		// PATCHES
		// 3.4.1 patch 1
		register_setting('mdocs-patch-vars', 'mdocs-v3-4-patch-var-1');
		add_option('mdocs-v3-4-patch-var-1',false);
		if(get_option('mdocs-v3-4-patch-var-1') == false && is_array(get_option('mdocs-list'))) {
			$mdocs = get_option('mdocs-list');
			foreach($mdocs as $index => $the_mdoc) {
				$mdocs_media = get_post($the_mdoc['id']);
				$mdocs_media->post_content = '[mdocs_media_attachment]';
				wp_update_post($mdocs_media);
			}
			update_option('mdocs-v3-4-patch-var-1', true);
		}
		// 3.0 patch 3
		register_setting('mdocs-patch-vars', 'mdocs-v3-0-patch-var-3');
		add_option('mdocs-v3-0-patch-var-3',false);
		if(get_option('mdocs-v3-0-patch-var-3') == false && is_array(get_option('mdocs-list'))) {
			$list = get_option('mdocs-list');
			$cats = get_option('mdocs-cats');
			delete_option('mdocs-list');
			delete_option('mdocs-cats');
			add_option('mdocs-list', $list, '','no');
			add_option('mdocs-cats', $cats, '', 'no');
			update_option('mdocs-v3-0-patch-var-3', true);
		}
		// 3.0 patch 2
		register_setting('mdocs-patch-vars', 'mdocs-v3-0-patch-var-2');
		add_option('mdocs-v3-0-patch-var-2',false);
		if(get_option('mdocs-v3-0-patch-var-2') == false && is_array(get_option('mdocs-list'))) {
			$mdocs = get_option('mdocs-list');
			global $current_user;
			foreach($mdocs as $index => $the_mdoc) {
				$mdocs[$index]['owner'] = $current_user->user_login;
				$mdocs[$index]['contributors'] = array();
			}
			update_option('mdocs-list', $mdocs, '' , 'no');
			update_option('mdocs-v3-0-patch-var-2',true);
		}
		// 3.0 patch 1
		//delete_option('mdocs-v3-0-patch-var-1');
		//delete_option('mdocs-box-view-updated');
		register_setting('mdocs-patch-vars', 'mdocs-v3-0-patch-var-1');
		add_option('mdocs-v3-0-patch-var-1',false);
		register_setting('mdocs-patch-vars', 'mdocs-box-view-updated');
		add_option('mdocs-box-view-updated',false);
		if(get_option('mdocs-v3-0-patch-var-1') == false && is_array(get_option('mdocs-list')) && count(get_option('mdocs-list')) > 0) {
			add_action( 'admin_head', 'mdocs_v3_0_patch' );
			function mdocs_v3_0_patch() {
				$mdocs = get_option('mdocs-list');
				//MEMPHIS DOCS
				wp_register_script( 'mdocs-script-patch', MDOC_URL.'memphis-documents.js');
				wp_enqueue_script('mdocs-script-patch');
				wp_register_style( 'mdocs-font-awesome2-style-patch', '//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css');
				wp_enqueue_style( 'mdocs-font-awesome2-style-patch' );
				wp_localize_script( 'mdocs-script-patch', 'mdocs_patch_js', array('ajaxurl' => admin_url( 'admin-ajax.php' ), 'patch_text_3_0_1' => __('UPDATE HAS STARTER, DO NOT LEAVE THIS PAGE!'),'patch_text_3_0_2' => __('Go grab a coffee this may take awhile.'),));
				?>
				<script type="application/x-javascript">
					jQuery(document).ready(function() {
						mdocs_v3_0_patch(<?php echo count($mdocs); ?>);
					});
				</script>
				<?php
			}
			wp_deregister_script('mdocs-script-patch');
			wp_deregister_style('mdocs-font-awesome2-style-patch');
		} else {
			update_option('mdocs-v3-0-patch-var-1',true);
			update_option('mdocs-box-view-updated',true);
		}
		// 2.6.6
		register_setting('mdocs-patch-vars', 'mdocs-v2-6-6-patch-var-1');
		add_action('mdocs-v2-6-6-patch-var-1',false);
		if(get_option('mdocs-v2-6-6-patch-var-1') == false && is_array(get_option('mdocs-list'))) {
			$this_query = new WP_Query('category_name=mdocs-media&posts_per_page=-1');	
			foreach($this_query->posts as $index => $post) set_post_type($post->ID,'mdocs-posts');
			update_option('mdocs-v2-6-6-patch-var-1',true);
		}
		// 2.6.7
		register_setting('mdocs-patch-vars', 'mdocs-v2-6-7-patch-var-1');
		add_action('mdocs-v2-6-7-patch-var-1',false);
		if(get_option('mdocs-v2-6-7-patch-var-1') == false && is_array(get_option('mdocs-list'))) {
			$mdocs_cat = get_category_by_slug('mdocs-media');
			wp_delete_category($mdocs_cat->cat_ID);
			update_option('mdocs-v2-6-7-patch-var-1',true);
		} 
		// 2.5
		register_setting('mdocs-patch-vars', 'mdocs-v2-5-patch-var-1');
		add_action('mdocs-v2-5-patch-var-1',false);
		if(get_option('mdocs-v2-5-patch-var-1') == false && is_array(get_option('mdocs-list'))) {
			$num_cats = 1;
			foreach( get_option('mdocs-cats') as $index => $cat ){ $num_cats++;}
			update_option('mdocs-num-cats',$num_cats);
			add_action( 'admin_notices', 'mdocs_v2_5_admin_notice_v1' );
			update_option('mdocs-v2-5-patch-var-1',true);
		} else update_option('mdocs-v2-5-patch-var-1',true);
		// 2.4
		register_setting('mdocs-patch-vars', 'mdocs-v2-4-patch-var-1');
		add_option('mdocs-v2-4-patch-var-1',false);
		if(get_option('mdocs-v2-4-patch-var-1') == false  && is_array(get_option('mdocs-list'))) {
			$mdocs_cats = get_option('mdocs-cats');
			$new_mdocs_cats = array();
			foreach($mdocs_cats as $index => $cat) array_push($new_mdocs_cats, array('slug' => $index,'name' => $cat, 'parent' => '', 'children' => array(), 'depth' => 0));
			update_option('mdocs-cats', $new_mdocs_cats, '' , 'no');
			update_option('mdocs-v2-4-patch-var-1', true);
			add_action( 'admin_notices', 'mdocs_v2_4_admin_notice_v1' );
		} else update_option('mdocs-v2-4-patch-var-1', true);
		// 2.3
		register_setting('mdocs-patch-vars', 'mdocs-v2-3-1-patch-var-1');
		add_option('mdocs-v2-3-1-patch-var-1',false);
		if(get_option('mdocs-v2-3-1-patch-var-1') == false  && is_array(get_option('mdocs-list'))) {
			$htaccess = $upload_dir['basedir'].'/mdocs/.htaccess';
			$fh = fopen($htaccess, 'w');
			update_option('mdocs-htaccess', "Deny from all\nOptions +Indexes\nAllow from .google.com");
			$mdocs_htaccess = get_option('mdocs-htaccess');
			fwrite($fh, $mdocs_htaccess);
			fclose($fh);
			chmod($htaccess, 0660);
			update_option('mdocs-v2-3-1-patch-var-1', true);
			add_action( 'admin_notices', 'mdocs_v2_2_1_admin_notice_v1' );
		} else update_option('mdocs-v2-3-1-patch-var-1', true);
		//2.1 
		register_setting('mdocs-settings', 'mdocs-2-1-patch-1');
		add_option('mdocs-2-1-patch-1',false);
		if(get_option('mdocs-2-1-patch-1') == false  && is_array(get_option('mdocs-list'))) {
			$mdocs = get_option('mdocs-list');
			foreach(get_option('mdocs-list') as $index => $the_mdoc) {
				if(!is_array($the_mdoc['ratings'])) {
					$the_mdoc['ratings'] = array();
					$the_mdoc['rating'] = 0;
					$mdocs[$index] = $the_mdoc;
				}
				if(!key_exists('rating', $mdocs)) {
					$the_mdoc['rating'] = 0;
					$mdocs[$index] = $the_mdoc;
				}
			}
			mdocs_save_list($mdocs);
			update_option('mdocs-2-1-patch-1', true);
		} else update_option('mdocs-2-1-patch-1', true);
	} else {
		update_option('mdocs-v2-6-6-patch-var-1',true);
		update_option('mdocs-v2-6-7-patch-var-1',true);
		update_option('mdocs-v2-5-patch-var-1',true);
		update_option('mdocs-v2-4-patch-var-1', true);
		update_option('mdocs-v2-3-1-patch-var-1', true);
		update_option('mdocs-2-1-patch-1', true);
		@unlink($upload_dir['basedir'].MDOCS_DIR.'mdocs-files.bak');
	}
}
function mdocs_v2_2_1_admin_notice_v1() {
    ?>
    <div class="update-nag">
        <p><?php _e('Your Memphis <b>.htaccess</b> file has been updated to allow google.com access to the system.   This step is necessary to allow documents to be previewed.','memphis-documents-library'); ?></p>
    </div>
    <?php
}
function mdocs_v2_4_admin_notice_v1() {
    ?>
    <div class="update-nag">
        <p><?php _e('Your Memphis <b>Categories</b> have been updated to handle subcategories this should not effect your current file system in anyway.  If there is any issues please post a comment in the support forum of this plugin.  It is recommended to re-export your files again due to the new way categories are structured.','memphis-documents-library'); ?></p>
    </div
    <?php
}
function mdocs_v2_5_admin_notice_v1() {
    ?>
    <div class="update-nag">
        <p><?php _e('Your Memphis <b>Categories</b> have been counted to handle subcategories this should not effect your current file system in anyway.  If there is any issues please post a comment in the support forum of this plugin.  It is recommended to re-export your files again due to the new way categories are structured.','memphis-documents-library'); ?></p>
    </div
    <?php
}
function mdocs_v3_0_patch_run_updater() {
	$mdocs = get_option('mdocs-list');
	$boxview = new mdocs_box_view();
	foreach($mdocs as $index => $the_mdoc) {
		//if(!isset($the_mdoc['box-view-id'])) {
			$upload_file = $boxview->uploadFile(get_site_url().'/?mdocs-file='.$the_mdoc['id'].'&mdocs-url=false&is-box-view=true', $the_mdoc['filename']);
			$the_mdoc['box-view-id'] = $upload_file['id'];
			$mdocs[$index] = $the_mdoc;
			update_option('mdocs-list', $mdocs, '' , 'no');
		//}
	}
	update_option('mdocs-v3-0-patch-var-1',true);
	update_option('mdocs-box-view-updated',true);
}
function mdocs_v3_0_patch_cancel_updater() {
	update_option('mdocs-v3-0-patch-var-1',true);
	update_option('mdocs-box-view-updated',false);
}
?>