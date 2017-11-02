<?php
function mdocs_display_file_info($the_mdoc, $index=0, $current_cat) {
	$the_mdoc_permalink = mdocs_get_permalink($the_mdoc['parent'], true);
	$the_post = get_post($the_mdoc['parent']);
	if($the_post != null) $is_new = preg_match('/new=true/',$the_post->post_content);
	else $is_new = false;
	$mdocs_show_new_banners = get_option('mdocs-show-new-banners');
	$mdocs_time_to_display_banners = get_option('mdocs-time-to-display-banners');
	$new_or_updated = '';
	
	$the_date = mdocs_format_unix_epoch($the_mdoc['modified']);
	if($the_date['gmdate'] > time()) $scheduled = '<small class="text-muted"><b>'.__('Scheduled').'</b></small>';
	else $scheduled = '';
	
	if($mdocs_show_new_banners) {
		$modified = floor($the_mdoc['modified']/86400)*86400;
		$today = floor(time()/86400)*86400;
		$days = (($today-$modified)/86400);
		if($mdocs_time_to_display_banners > $days) {
			if($is_new == true) {
				$status_class = 'mdocs-success';
				$new_or_updated = '<small><small class="label label-success">'.__('New', 'memphis-documents-library').'</small></small>';
			} else {
				$status_class = 'mdocs-info';
				$new_or_updated = '<small><small class="label label-info">'.__('Updated', 'memphis-documents-library').'</small></small>';
			}
		} else  $status_class = '';
	} else $status_class = ''; 
	
	if(get_option('mdocs-hide-new-update-label')) $new_or_updated = '';
	
	
	
	if($the_mdoc['file_status'] == 'hidden' || get_option('mdocs-hide-all-files') == true ) $file_status = '<i class="fa fa-eye-slash" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="'.__('File is Hidden', 'memphis-documents-library').'"></i>';
	else $file_status = '';
	if($the_mdoc['post_status'] != 'publish' || get_option('mdocs-hide-all-post') == true ) $post_status = '&nbsp<i class="fa fa-lock" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="'.__('Post is ', 'memphis-documents-library').ucfirst($the_mdoc['post_status']).'"></i>';
	else $post_status = '';
	
	?>
		<tr class="<?php echo $status_class; ?>">
			<?php
			$title_colspan = 0;
			if(is_admin()) {
				if(mdocs_check_file_rights($the_mdoc)) {
					?>
					<td><input type="checkbox" name="mdocs-batch-checkbox" data-id="<?php echo $the_mdoc['id']; ?>"/></td>
					<?php
				} else $title_colspan = 2;
				$dropdown_class = 'mdocs-dropdown-menu';
			} else $dropdown_class = 'mdocs-dropdown-menu';
			if(get_option('mdocs-dropdown-toggle-fix')  && !is_admin() ) $data_toogle = '';
			else $data_toogle = 'dropdown';
			?>
			<td id="title" class="mdocs-tooltip" colspan="<?php echo $title_colspan; ?>">
					<div class="mdocs-btn-group btn-group">
						<?php
						if(get_option('mdocs-hide-name')) $name_string = $new_or_updated.$file_status.$post_status.mdocs_get_file_type_icon($the_mdoc).' '.$the_mdoc['filename'].'<br>'.$scheduled;
						elseif(get_option('mdocs-hide-filename')) $name_string = $new_or_updated.$file_status.$post_status.mdocs_get_file_type_icon($the_mdoc).' '.str_replace('\\','',$the_mdoc['name']).'<br>'.$scheduled;
						else $name_string = $new_or_updated.$file_status.$post_status.mdocs_get_file_type_icon($the_mdoc).' '.str_replace('\\','',$the_mdoc['name']).' - <small class="text-muted">'.$the_mdoc['filename'].'</small><br>'.$scheduled;
						
						
						?>
						<a class="mdocs-title-href" data-mdocs-id="<?php echo $index; ?>" data-toggle="<?php echo $data_toogle; ?>" href="#" ><?php echo $name_string; ?></a>
						
						<ul class="<?php echo $dropdown_class; ?>" role="menu" aria-labelledby="dropdownMenu1">
							<li role="presentation" class="dropdown-header"><i class="fa fa-medium"></i> &#187; <?php echo $the_mdoc['filename']; ?></li>
							<li role="presentation" class="divider"></li>
							<li role="presentation" class="dropdown-header"><?php _e('File Options'); ?></li>
							<?php
								mdocs_download_rights($the_mdoc);
								mdocs_desciption_rights($the_mdoc);
								mdocs_preview_rights($the_mdoc);
								mdocs_versions_rights($the_mdoc);
								mdocs_rating_rights($the_mdoc);
								mdocs_goto_post_rights($the_mdoc, $the_mdoc_permalink);
								mdocs_share_rights($the_mdoc, $the_mdoc_permalink);
								if(is_admin()) { ?>
							<li role="presentation" class="divider"></li>
							<li role="presentation" class="dropdown-header"><?php _e('Admin Options'); ?></li>
							<?php
								mdocs_add_update_rights($the_mdoc, $current_cat);
								mdocs_manage_versions_rights($the_mdoc, $index, $current_cat);
								mdocs_delete_file_rights($the_mdoc, $index, $current_cat);
								if(get_option('mdocs-preview-type') == 'box' && get_option('mdocs-box-view-key') != '') {
									mdocs_refresh_box_view($the_mdoc, $index);
								}
							?>
							<li role="presentation" class="divider"></li>
							<li role="presentation" class="dropdown-header"><i class="fa fa-laptop"></i> <?php _e('File Status', 'memphis-documents-libaray'); echo ':'.' '.ucfirst($the_mdoc['file_status']); ?></li>
							<li role="presentation" class="dropdown-header"><i class="fa fa-bullhorn"></i> <?php _e('Post Status', 'memphis-documents-libaray'); echo ':'.' '.ucfirst($the_mdoc['post_status']); ?></li>
							<?php } ?>
						  </ul>
					</div>
			</td>
			<?php
			
			
			foreach(get_option('mdocs-displayed-file-info') as $key => $option) {
				if(isset($option['show']) && $option['show']) {
					$the_function = $option['function'];
					?><td id="<?php echo $option['slug']; ?>"><i class="<?php echo $option['icon']; ?>"></i> <b class="<?php echo $option['color']; ?>"><?php if(function_exists($the_function)) $the_function($the_mdoc); else echo '"'.$the_function. '" function does not exist.'; ?></b></td><?php
				}
			}
			?>
		</tr>
		<tr>
<?php
}
function mdocs_display_downloads($the_mdoc) {
	echo $the_mdoc['downloads'].' <small>'.__('downloads','memphis-documents-library').'</small>';
}
function mdocs_display_version($the_mdoc) {
	echo $the_mdoc['version'];
}
function mdocs_display_owner($the_mdoc) {
	echo get_user_by('login', $the_mdoc['owner'])->display_name;
}
function mdocs_display_updated($the_mdoc) {
	$the_date = mdocs_format_unix_epoch($the_mdoc['modified']);
	if($the_date['gmdate'] > time()) $scheduled = '<small class="text-muted"><b>'.__('Scheduled').'</b></small>';
	else $scheduled = '';
	echo $the_date['formated-date'];
}
function mdocs_display_rating($the_mdoc) {
	$the_rating = mdocs_get_rating($the_mdoc);
	for($i=1;$i<=5;$i++) {
		if($the_rating['average'] >= $i) echo '<i class="fa fa-star mdocs-gold" id="'.$i.'"></i>';
		elseif(ceil($the_rating['average']) == $i ) echo '<i class="fa fa-star-half-full mdocs-gold" id="'.$i.'"></i>';
		else echo '<i class="fa fa-star-o" id="'.$i.'"></i>';
	}
}
function mdocs_display_download_btn($the_mdoc) {
	if($the_mdoc['non_members'] == 'on' || is_user_logged_in()) {
		?><a href="<?php echo site_url().'/?mdocs-file='.$the_mdoc['id']; ?>"><?php echo __('Download','memphis-documents-library'); ?></a><?php
	} else {
		?><a href="<?php echo wp_login_url(htmlspecialchars(get_permalink($the_mdoc['parent']))); ?>"><?php echo __('Login','memphis-documents-library'); ?></a><?php
	}
}
function mdocs_display_description($the_mdoc) {
	echo $the_mdoc['desc'];
}
function mdocs_display_real_author($the_mdoc) {
	if(isset($the_mdoc['author']))	echo $the_mdoc['author'];
}
?>