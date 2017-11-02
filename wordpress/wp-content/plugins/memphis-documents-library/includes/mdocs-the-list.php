<?php
add_shortcode( 'mdocs', 'mdocs_shortcode' );
function mdocs_shortcode($att, $content=null) { return mdocs_the_list($att); }
function mdocs_the_list($att=null) {
	global $post;
	ob_start();
	if(mdocs_check_read_write() == false) mdocs_errors(__('Unable to create the directory "mdocs" which is needed by Memphis Documents Library. Its parent directory is not writable by the server?','memphis-documents-library'),'error');
	$mdocs = get_option('mdocs-list');
	$mdocs = mdocs_array_sort();
	if(isset($att['cat'])) $current_cat_array = mdocs_get_the_folder($att, $att['cat']);
	else $current_cat_array = mdocs_get_the_folder($att);
	$current_cat = $current_cat_array['slug'];
	if(isset($att['cat']) && $att['cat'] == 'All Files' || isset($att['single-file'])) { $current_cat = 'all'; mdocs_list_header(false); }
	else if(!isset($att['cat'])) mdocs_list_header(true);
	else mdocs_list_header(false);
	$permalink = mdocs_get_permalink($post);
	if(isset($_GET['mdocs-att'])) $the_folder = mdocs_sanitize_string($_GET['mdocs-att']);
	else $the_folder = 'none';
	$permalink = $permalink.$current_cat_array['slug'].'&mdocs-att='.$the_folder;
	$mdocs_sort_type = get_option('mdocs-sort-type');
	$mdocs_sort_style = get_option('mdocs-sort-style');
	$disable_user_sort = get_option('mdocs-disable-user-sort');
	if(isset($_COOKIE['mdocs-sort-type']) && $disable_user_sort == false && get_option('mdocs-hide-sortbar') == false) $mdocs_sort_type = $_COOKIE['mdocs-sort-type'];
	if(isset($_COOKIE['mdocs-sort-range']) && $disable_user_sort == false && get_option('mdocs-hide-sortbar') == false) $mdocs_sort_style = $_COOKIE['mdocs-sort-range'];
	if($mdocs_sort_style == 'desc') $mdocs_sort_style_icon = ' <i class="fa fa-chevron-down"></i>';		
	else $mdocs_sort_style_icon = ' <i class="fa fa-chevron-up"></i>';
?><div class="mdocs-container"><?php
	if(isset($att['header'])) echo '<p>'.__($att['header']).'</p>';
		$num_tds = 1;
	?>
	<table class="table table-hover table-condensed" id="mdocs-list-table">
	<?php
	if(get_option('mdocs-hide-sortbar') == false && !isset($att['single-file'])) { ?>
	<thead>
	<tr class="hidden-sm hidden-xs">
		<?php if(is_admin()) { ?> <th id="batch"><input type="checkbox" name="mdocs-batch-select-all" id="mdocs-batch-select-all"/></th> <?php  $num_tds++; } ?>
		<th class="mdocs-sort-option" data-disable-user-sort="<?php echo $disable_user_sort; ?>" data-sort-type="name" data-current-cat="<?php echo $current_cat; ?>" data-permalink="<?php echo $permalink; ?>"><?php _e('Name','memphis-documents-library'); ?><?php if($mdocs_sort_type == 'name') echo $mdocs_sort_style_icon; ?></th>
		<?php
		foreach(get_option('mdocs-displayed-file-info') as $key => $option) {
			if(isset($option['show']) && $option['show']) {
				$num_tds++; ?>
				<th class="mdocs-sort-option" data-disable-user-sort="<?php echo $disable_user_sort; ?>" data-sort-type="<?php echo $option['slug']; ?>" data-current-cat="<?php echo $current_cat; ?>" data-permalink="<?php echo $permalink; ?>"><?php echo $option['text']; ?><?php if($mdocs_sort_type ==$option['slug']) echo $mdocs_sort_style_icon; ?></th>
			<?php } 
		}
		?>
	</tr>
	</thead>
	
	<tfoot>
	<tr class="hidden-sm hidden-xs">
		<?php if(is_admin()) { ?> <th id="batch"><input type="checkbox" name="mdocs-batch-select-all" id="mdocs-batch-select-all"/></th> <?php } ?>
		<th class="mdocs-sort-option" data-disable-user-sort="<?php echo $disable_user_sort; ?>" data-sort-type="name" data-current-cat="<?php echo $current_cat; ?>" data-permalink="<?php echo $permalink; ?>"><?php _e('Name','memphis-documents-library'); ?><?php if($mdocs_sort_type == 'name') echo $mdocs_sort_style_icon; ?></th>
		<?php
		foreach(get_option('mdocs-displayed-file-info') as $key => $option) {
			if(isset($option['show']) && $option['show']) {
				$num_tds++; ?>
				<th class="mdocs-sort-option" data-disable-user-sort="<?php echo $disable_user_sort; ?>" data-sort-type="<?php echo $option['slug']; ?>" data-current-cat="<?php echo $current_cat; ?>" data-permalink="<?php echo $permalink; ?>"><?php echo $option['text']; ?><?php if($mdocs_sort_type ==$option['slug']) echo $mdocs_sort_style_icon; ?></th>
			<?php } 
		}?>
	</tr>
	</tfoot>
	<?php
	}
	// SUB CATEGORIES
	if(!isset($att['single-file'])) {
		$hide_sub_folders = get_option('mdocs-hide-subfolders');
		$hide_all_sub_folder = get_option('mdocs-hide-all-subfolders');
		if(!isset($att['cat']) && $hide_all_sub_folder == false) mdocs_display_sub_folders($current_cat_array, 'null'); 
		elseif(isset($current_cat_array['children']) && $hide_sub_folders == false && isset($att['cat'])) mdocs_display_sub_folders($current_cat_array, $att['cat']);
	}
	// LOAD FILES
	$has_one_file = false;
	if(isset($att['single-file'])) {
		$the_mdoc = get_the_mdoc_by($att['single-file'], 'filename');
		if(mdocs_check_file_rights($the_mdoc, false)) {
			$has_one_file = true;
			$mdocs_post = get_post($the_mdoc['parent']);
			mdocs_display_file_info($the_mdoc, 0, $current_cat);
		}
	} else {	
		foreach($mdocs as $index => $the_mdoc) {
			if($the_mdoc['cat'] == $current_cat || $current_cat == 'all') {
				if(mdocs_check_file_rights($the_mdoc, false)) {
					$has_one_file = true;
					$mdocs_post = get_post($the_mdoc['parent']);
					mdocs_display_file_info($the_mdoc, $index, $current_cat);
				}
			} 
		}
	}
	if($has_one_file == false && get_option('mdocs-show-no-file-found')) {
		?><tr><td colspan="<?php echo $num_tds; ?>"><p class="mdocs-nofiles" ><?php _e('No files found in this folder.','memphis-documents-library'); ?></p></td></tr><?php
	}
	
	?></table></div><?php
	$the_list = ob_get_clean();
	return $the_list;
}
?>