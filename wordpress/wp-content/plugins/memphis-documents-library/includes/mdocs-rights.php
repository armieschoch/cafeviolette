<?php
function mdocs_check_file_rights($the_mdoc=null, $is_manage=true) {
	$is_allowed = false;
	if($the_mdoc != null || isset($_GET['mdocs-export-file'])) {
		$current_user = wp_get_current_user();
		if(empty($current_user->roles)) $current_user->roles[0] = 'none';
		// ADMINS GET FULL RIGHTS FOR EVERY FILE
		if(current_user_can( 'manage_options' )) $is_allowed = true;
		// OWNER RIGHTS
		if($current_user->user_login == $the_mdoc['owner']) $is_allowed = true;
		// CONTRIBUTOR RIGHTS
		if(is_array($the_mdoc['contributors'])) {
			foreach($the_mdoc['contributors'] as $index => $role) {
				if($current_user->user_login == $role) { $is_allowed = true; break; }
				if(in_array($role, $current_user->roles)) { $is_allowed = true; break; }
			}
		}
		// IF IS NOT A MANAGEMENT PAGE
		if($is_manage == false) {
			if($is_allowed === false) {
				// MEMBER RIGHTS
				if(is_user_logged_in()) {
					if($the_mdoc['file_status'] != 'hidden' && get_option( 'mdocs-hide-all-files' ) == false) $is_allowed = true;
					if(floatval($the_mdoc['modified']) > time()) $is_allowed = false;
				// NON-MEMBER RIGHTS
				} else {
					if(get_option( 'mdocs-hide-all-files-non-members' ) == false && get_option( 'mdocs-hide-all-files' ) == false) $is_allowed = true;
					if($the_mdoc['file_status'] == 'hidden') $is_allowed = false;
					if(floatval($the_mdoc['modified']) > time()) $is_allowed = false;
				}
				if(isset($_GET['mdocs-export-file']) && current_user_can( 'manage_options' )) $is_allowed = true;
				if(isset($_GET['mdocs-export-file']) && !current_user_can( 'manage_options' )) $is_allowed = false;
			}
		}
		return $is_allowed;
	} else return $is_allowed;
}
function mdocs_check_post_rights($the_mdoc) {
	global $current_user;
	if(empty($current_user->roles)) $current_user->roles[0] = 'none';
	$hide_all_post = get_option('mdocs-hide-all-posts');
	$hide_all_post_non_members = get_option('mdocs-hide-all-posts-non-members');
	$mdocs_view_private = get_option('mdocs-view-private');
	$post_status = get_post_status($the_mdoc['parent']);
	$is_allow = false;
	// ADMINS GET FULL RIGHTS FOR EVERY FILE
	if(current_user_can( 'manage_options' )) $is_allowed = true;
	// OWNER RIGHTS
	if($current_user->user_login == $the_mdoc['owner']) $is_allowed = true;
	// VIEW PRIVATE POSTS
	foreach($current_user->roles as $index => $role) {
		if(array_key_exists($role, $mdocs_view_private)) {
			if($mdocs_view_private[$role]) $is_allow = true;
		}
	}
	// PUBLIC POST ONLY
	if($post_status == 'publish') {
		// HIDE ALL POSTS
		if($hide_all_post == false && $hide_all_post_non_members == false) $is_allow = true;
		// HIDE ALL POST NON MEMBERS
		if(is_user_logged_in() == true && $hide_all_post_non_members == true) $is_allow = true;
	}
	if(get_post($the_mdoc['parent']) == null) $is_allow = false;
	return $is_allow;
}
function mdocs_contributors_check($contrib) {
	if(!is_array($contrib))  {
		return array();
	} else return $contrib;
}
function mdocs_add_update_rights($the_mdoc, $current_cat) {
	if(mdocs_check_file_rights($the_mdoc)) {
	?>
	<li role="presentation">
		<a role="menuitem" tabindex="-1" data-toggle="mdocs-modal" data-target="#mdocs-add-update" data-mdocs-id="<?php echo $the_mdoc['id']; ?>" data-is-admin="<?php echo is_admin(); ?>" data-action-type="update-doc"  data-current-cat="<?php echo $current_cat; ?>" href=""  class="add-update-btn" >
			<i class="fa fa-file-o" ></i> <?php _e('Manage File','memphis-documents-library'); ?>
		</a>
	</li>
	<?php
	}
}
function mdocs_goto_post_rights($the_mdoc, $the_mdoc_permalink) {
	if(mdocs_check_post_rights($the_mdoc)) {
		?>
		<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo str_replace('?mdocs-cat=','', $the_mdoc_permalink); ?>" target="<?php echo get_option('mdocs-post-target-type'); ?>"><i class="fa fa-arrow-circle-o-right"></i> <?php _e('Goto Post','memphis-documents-library'); ?></a></li>
		<?php
	}
}
function mdocs_manage_versions_rights($the_mdoc, $index, $current_cat) {
	if(mdocs_check_file_rights($the_mdoc)) {
		?>
		<li role="presentation">
			<a role="menuitem" tabindex="-1" href="?page=memphis-documents.php&mdocs-cat=<?php echo $current_cat; ?>&action=mdocs-versions&mdocs-index=<?php echo $index; ?>"><i class="fa fa-road"></i> <?php _e('Manage Versions','memphis-documents-library'); ?></a>
		</li>
		<?php
	}
}
function mdocs_download_rights($the_mdoc) {
	if(mdocs_check_file_rights($the_mdoc, false) && $the_mdoc['non_members'] == 'on' || is_user_logged_in()) { ?>
		<li role="presentation">
			<a role="menuitem" tabindex="-1" href="<?php echo site_url().'/?mdocs-file='.$the_mdoc['id']; ?>"><i class="fa fa-cloud-download"></i> <?php _e('Download','memphis-documents-library'); ?></a>
		</li>
		<?php
	} else { ?>
		<li role="presentation">
			<a role="menuitem" tabindex="-1" href="<?php echo wp_login_url(mdocs_sanitize_string(get_permalink($the_mdoc['parent']))); ?>"><i class="fa fa-cloud-download"></i> <?php _e('Login to Download','memphis-documents-library'); ?></a>
		</li>
		<?php
	}
}
function mdocs_preview_rights($the_mdoc) {
	global $mdocs_img_types;
	$preview_type = 'file-preview';
	if(!in_array($the_mdoc['type'], $mdocs_img_types) ) $preview_type = 'file-preview';
	else $preview_type = 'img-preview';
	if(mdocs_check_file_rights($the_mdoc, false) && get_option('mdocs-show-preview')) {
		?> 
		<li role="presentation">
			<a class="<?php echo $preview_type; ?>" role="menuitem" tabindex="-1" data-toggle="mdocs-modal" data-target="#mdocs-file-preview" data-mdocs-id="<?php echo $the_mdoc['id']; ?>" data-is-admin="<?php echo is_admin(); ?>" href=""><i class="fa fa-search mdocs-preview-icon" ></i> <?php _e('Preview','memphis-documents-library'); ?></a>
		</li>
		<?php
	}
}
function mdocs_desciption_rights($the_mdocs) {
	if(get_option('mdocs-show-description')) {
	?>
	<li role="presentation"><a class="description-preview" role="menuitem" tabindex="-1" href="#" data-toggle="mdocs-modal" data-target="#mdocs-description-preview" data-mdocs-id="<?php echo $the_mdocs['id']; ?>" data-is-admin="<?php echo is_admin(); ?>" ><i class="fa fa-leaf"></i> <?php _e('Description','memphis-documents-library'); ?></a></li>
	<?php
	}
}
function mdocs_share_rights($the_mdoc, $permalink) {
	$permalink = str_replace('?mdocs-cat=', '', $permalink);
	if(get_option('mdocs-show-share')) {
	?>
	<li role="presentation"><a class="sharing-button" role="menuitem" tabindex="-1" href="#" data-toggle="mdocs-modal" data-doc-id="<?php echo $the_mdoc['id']; ?>" data-target="#mdocs-share" data-permalink="<?php echo $permalink;?>" data-download="<?php echo get_site_url().'/?mdocs-file='.$the_mdoc['id']; ?>" ><i class="fa fa-share"></i> <?php _e('Share','memphis-documents-library'); ?></a></li>
	<?php
	}
}
function mdocs_rating_rights($the_mdoc) {
	$sa = mdocs_get_table_atts();
	if($sa['show-ratings']['show'] && is_user_logged_in()) {
	?>
	<li role="presentation"><a class="ratings-button" role="menuitem" tabindex="-1" href="" data-toggle="mdocs-modal" data-target="#mdocs-rating" data-mdocs-id="<?php echo $the_mdoc['id']; ?>" data-is-admin="<?php echo is_admin(); ?>"><i class="fa fa-star"></i> <?php _e('Rate','memphis-documents-library'); ?></a></li>
	<?php
	}
}
function mdocs_delete_file_rights($the_mdoc, $index, $current_cat) {
	if(mdocs_check_file_rights($the_mdoc)) {
		?>
		<li role="presentation">
			<a onclick="mdocs_delete_file('<?php echo $index; ?>','<?php echo $current_cat; ?>','<?php echo $_SESSION['mdocs-nonce']; ?>');" role="menuitem" tabindex="-1" href="#"><i class="fa fa-times-circle"></i> <?php _e('Delete File','memphis-documents-library'); ?></a>
		</li>
		<?php
	}
}
function mdocs_refresh_box_view($the_mdoc, $index) {
	if(mdocs_check_file_rights($the_mdoc)) {
		?>
		<li role="presentation"><a class="box-view-refresh-button" role="menuitem" tabindex="-1" href="#" data-toggle="mdocs-modal" data-index="<?php echo $index; ?>" data-filename="<?php echo $the_mdoc['filename']; ?>" ><i class="fa fa-refresh"></i> <?php _e('Refresh Preview and Thumbnail','memphis-documents-library'); ?></a></li>
		<?php
	}
}
function mdocs_versions_rights($the_mdoc) {
	if(get_option('mdocs-show-versions') && !is_admin()) {
		?>
		<li role="presentation"><a class="versions-button" role="menuitem" tabindex="-1" href="#" data-toggle="mdocs-modal" data-target="#mdocs-versions" data-mdocs-id="<?php echo $the_mdoc['id']; ?>" ><i class="fa fa-code-fork"></i> <?php _e('Other Versions','memphis-documents-library'); ?></a></li>
		<?php
	}
}
?>