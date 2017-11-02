<?php
function mdocs_load_preview() {
	if(isset($_POST['type']) && isset($_POST['mdocs_file_id'])) {
		$the_mdoc = get_the_mdoc_by( $_POST['mdocs_file_id'], 'id');
		switch($_POST['show_type']) {
			case 'desc':
				mdocs_show_description($the_mdoc['id']);
				break;
			case 'preview':
				mdocs_show_preview($the_mdoc);
				break;
			case 'versions':
				mdocs_show_versions($the_mdoc['parent']);
				break;
		}
	} else echo 'An error has occured, trying to display this preview please contact the plugin author for assistance.';
}
// PREVIEW
function mdocs_show_preview($the_mdoc) {
	$upload_dir = wp_upload_dir();
	$is_allowed = mdocs_check_file_rights($the_mdoc, false);
	if($is_allowed) {
		$is_image = @getimagesize($upload_dir['basedir'].MDOCS_DIR.$the_mdoc['filename']);
	   ?>
		<div class="mdoc-desc">
			<?php
			if($is_image == false) mdocs_load_preview_iframe($the_mdoc);
			else mdocs_load_image_iframe($the_mdoc);
			?>
	   </div>
	   <?php
	} else {
		?>
	   <br><div class="alert alert-info text-center" role="alert"><?php _e('Preview is unavailable for this file.','memphis-documents-library'); ?></div class="alert alert-warning" role="alert">
	   <?php
	}
}
// PREVIEW - DOCUMENT
function mdocs_load_preview_iframe($file) {
	if(get_option('mdocs-preview-type') == 'google') {
		$link = site_url().'/?is-google='.$file['id'];
		?>
		<iframe id="mdocs-box-view-iframe" src="//docs.google.com/gview?url=<?php echo $link; ?>&embedded=true&hl=en&mdocs-session=<?php echo md5(microtime()); ?>" style="border: none; width: 100%;" seamless fullscreen></iframe>
		<script>
			var screenHeight = window.innerHeight-250;
			jQuery('#mdocs-box-view-iframe').css({'height': screenHeight});
		</script>
		<?php
	} elseif(get_option('mdocs-preview-type') == 'box' && get_option('mdocs-box-view-key') != '') {
		$boxview = new mdocs_box_view();
		$view_file = $boxview->downloadFile($file['box-view-id']);
		if(isset($view_file) && $view_file['type'] != 'error') { ?>
		<h4><?php echo $file['name']; ?></h4>
		<iframe id="mdocs-box-view-iframe" src="https://view-api.box.com/1/sessions/<?php echo $view_file['id']; ?>/view?theme=dark&mdocs-session=<?php echo md5(microtime()); ?>" seamless fullscreen style="width: 100%; "></iframe>
		<script>
			var screenHeight = window.innerHeight-275;
			jQuery('#mdocs-box-view-iframe').css({'height': screenHeight})
		</script>
		<?php } else { ?>
		<div class="alert alert-warning" role="alert"><?php echo $view_file['details'][0]['message']; ?></div>
		<?php
		}
	} else _e('No preview type has been selected','memphis-documents-library');
}
// PREVIEW - IMAGE
function mdocs_load_image_iframe($the_mdoc) {
	?>
	<div style="text-align: center;">
		<img class="img-thumbnail mdocs-img-preview" src="<?php echo site_url(); ?>/?mdocs-img-preview=<?php echo $the_mdoc['filename']; ?>" />
	</div>
	<?php
}
// DESCRIPTION
function mdocs_show_description($id) {
	$mdocs = get_option('mdocs-list');
	$the_mdoc = get_the_mdoc_by($id, 'id');
	$mdocs_desc = apply_filters('the_content', $the_mdoc['desc']);
	$mdocs_desc = str_replace('\\','',$mdocs_desc);
	if(get_option('mdocs-preview-type') == 'box' && get_option('mdocs-box-view-key') != '') {
		$boxview = new mdocs_box_view();
		$thumbnail = $boxview->getThumbnail($the_mdoc['box-view-id']);
		$json_thumbnail = json_decode($thumbnail,true);
	} else $json_thumbnail['type'] = 'error';
	$the_image_file = preg_replace('/ /', '%20', $the_mdoc['filename']);
	$image_size = @getimagesize(get_site_url().'/?mdocs-img-preview='.$the_image_file);
	$thumbnail_size = 256;
	?>
	<div class="mdoc-desc">
	<?php
	if($json_thumbnail['type'] != 'error') {
		if(function_exists('imagecreatefromjpeg')) {
			?>
			<div class="">
				<img class="mdocs-thumbnail pull-left img-thumbnail img-responsive" src="<?php $boxview->displayThumbnail($thumbnail); ?>" alt="<?php echo $the_mdoc['filename']; ?>" />
			</div>
			<?php
		}
	} elseif($the_mdoc['type'] == 'pdf' && class_exists('imagick')) {
		$upload_dir = wp_upload_dir();
		$file = $upload_dir['basedir']."/mdocs/".$the_mdoc['filename'].'[0]';
		$thumbnail = new Imagick($file);
		$thumbnail->setbackgroundcolor('rgb(64, 64, 64)');
		$thumbnail->thumbnailImage(450, 300, true);
		$thumbnail->setImageFormat('png');
		$uri = "data:image/png;base64," . base64_encode($thumbnail);
		?>
		<div class="" >
			<img class="mdocs-thumbnail pull-left img-thumbnail  img-responsive" src="<?php echo $uri; ?>" alt="<?php echo $the_mdoc['filename']; ?>" />
		</div>
		<?php
	} elseif( $image_size != false) {
		
		$width = $image_size[0];
		$height = $image_size[1];
		$aspect_ratio = round($width/$height,2);
		// Width is greater than height and width is greater than thumbnail size
		if($aspect_ratio > 1&&  $width > $thumbnail_size) {
			$thumbnail_width = $thumbnail_size;
			$thumbnail_height = $thumbnail_size/$aspect_ratio;
		// Heigth is greater than width and height is greater then thumbnail size
		} elseif($aspect_ratio < 1 && $height > $thumbnail_size) {
			$aspect_ratio = round($height/$width,2);
			$thumbnail_width = $thumbnail_size/$aspect_ratio;
			$thumbnail_height = $thumbnail_size;
		// Heigth is greater than width and height is less then thumbnail size
		} elseif($aspect_ratio < 1 && $height < $thumbnail_size) {
			$aspect_ratio = round($height/$width,2);
			$thumbnail_width = $thumbnail_size/$aspect_ratio;
			$thumbnail_height = $thumbnail_size;
		// Width and height are equal
		} elseif($aspect_ratio == 1 ) {
			$thumbnail_width = $thumbnail_size;
			$thumbnail_height = $thumbnail_size;
		// Width is greater than height and width is less than thumbnail size
		} elseif($aspect_ratio > 1 && $width < $thumbnail_size) {
			$thumbnail_width = $thumbnail_size;
			$thumbnail_height = $thumbnail_size/$aspect_ratio;
		// Hieght is greater than width and height is less than thumbnail size
		} elseif($aspect_ratio > 1 && $height < $thumbnail_size) {
			$thumbnail_width = $thumbnail_size/$aspect_ratio;
			$thumbnail_height = $thumbnail_size;
		} else {
			$thumbnail_width = $thumbnail_size;
			$thumbnail_height = $thumbnail_size;
		}
		if(function_exists('imagecreatefromjpeg')) {
			ob_start();
			$upload_dir = wp_upload_dir();
			$src_image = $upload_dir['basedir'].MDOCS_DIR.$the_mdoc['filename'];
		
			if($image_size['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($src_image);
			elseif($image_size['mime'] == 'image/png') $image = imagecreatefrompng($src_image);
			elseif($image_size['mime'] == 'image/gif') $image = imagecreatefromgif($src_image);
			$thumnail =imagecreatetruecolor($thumbnail_width,$thumbnail_height);
			$white = imagecolorallocate($thumnail, 255, 255, 255);
			imagefill($thumnail, 0, 0, $white);
			imagecopyresampled($thumnail,$image,0,0,0,0,$thumbnail_width,$thumbnail_height,$image_size[0],$image_size[1]);
			
			imagepng($thumnail);
			imagedestroy($image);
			imagedestroy($thumnail);
			$png = ob_get_clean();
			$uri = "data:image/png;base64," . base64_encode($png);
			
			?>
			<div class="">
				<img class="mdocs-thumbnail pull-left img-thumbnail  img-responsive" src="<?php echo $uri; ?>" alt="<?php echo $the_mdoc['filename']; ?>" />
			</div>
			<?php
		}
	}
	echo $mdocs_desc; ?>
	</div>
	<div class=clearfix"></div>
	<?php
}
// VERSIONS
function mdocs_show_versions($id=null) {
	global $current_user;
	if($id == null) $the_mdoc = get_the_mdoc_by($_POST['mdocs-id'], 'id');
	else $the_mdoc = get_the_mdoc_by($id, 'parent');
	$date_format = get_option('mdocs-date-format');
	$current_date = mdocs_format_unix_epoch($the_mdoc['modified'], true);
	$upload_dir = wp_upload_dir();
	$archive_download = false;
	$download_link = '';
	$the_mdoc_permalink = htmlspecialchars(get_permalink($the_mdoc['parent']));
	
	
	if(get_option('mdocs-hide-all-files') || $the_mdoc['file_status'] == 'hidden') {
		$download_link = '<span class="text-danger"><i class="fa fa-exclamation-circle"></i> '.__('Access Denied','memphis-documents-library').'</span>';
		$archive_download = false;
	}
	elseif($the_mdoc['non_members']   == '' && is_user_logged_in() == false || is_user_logged_in() == false && get_option('mdocs-hide-all-files-non-members')) {
		$download_link = '<a href="'.wp_login_url($the_mdoc_permalink).'"><i class="fa fa-exclamation-circle"></i> '.__('Please Login','memphis-documents-library').'</a>';
		$archive_download = false;
		
	} elseif($the_mdoc['non_members'] == 'on' || is_user_logged_in() ) {
		$download_link = '<a href="'.site_url().'/?mdocs-file='.$the_mdoc['id'].'"><i class="fa fa-cloud-download"></i> '.__('Download','memphis-documents-library').'</a>';
		$archive_download = true;	
	} else {
		$download_link = '<span class="text-danger"><i class="fa fa-exclamation-circle"></i> '.__('Access Denied','memphis-documents-library').'</span>';
		$archive_download = false;
	}
	?>
	<table class="table table-hover table-condensed">
		<tr>
			<th><?php _e('File', 'memphis-documents-library'); ?></th>
			<th><?php _e('Version', 'memphis-documents-library'); ?></th>
			<th><?php _e('Date Modified', 'memphis-documents-library'); ?></th>
			<th><?php _e('Download', 'memphis-documents-library'); ?></th>
			<th><?php _e('Current', 'memphis-documents-library'); ?></th>
		</tr>
		<tr>
			<td class="mdocs-orange"><?php echo $the_mdoc['name'].' -  <small class="text-muted"><i>'.$the_mdoc['filename'].'</i></small>'; ?></td>
			<td class="mdocs-blue"><?php echo $the_mdoc['version']; ?></td>
			<td class="mdocs-red"><?php echo $current_date['formated-date']; ?></td>
			<?php
			if($archive_download) { ?>
			<td><?php echo $download_link; ?></td>
			<?php
			} else { ?>
			<td><?php echo $download_link; ?></td>
			<?php } ?>
			
			<td><input type="radio" checked name="mdocs-current-version"></td>
		<?php
		foreach(array_reverse($the_mdoc['archived']) as $index => $archive) {
			$file = substr($archive, 0, strrpos($archive, '-'));
			$version = substr(strrchr($archive, '-'), 2 );
			if(file_exists($upload_dir['basedir'].'/mdocs/'.strtolower($archive))) $archive = strtolower($archive);
			if(file_exists($upload_dir['basedir'].'/mdocs/'.$archive)) {
				$archive_date = date($date_format, filemtime($upload_dir['basedir'].'/mdocs/'.$archive));
				?>
				<tr>
					<td class="mdocs-orange"><?php echo $the_mdoc['name'].' -  <small class="text-muted"><i>'.$file.'</i></small>'; ?></td>
					<td class="mdocs-blue"><?php echo $version; ?></td>
					<td class="mdocs-red"><?php echo $archive_date; ?></td>
					<?php if($archive_download) { ?>
					<td><a href="<?php echo site_url().'/?mdocs-version='.$archive.'&mdocs-file='.$the_mdoc['id'].'&mdocs-url=false'; ?>"><i class="fa fa-cloud-download"></i> <?php _e('Download','memphis-documents-library'); ?></a></td>
					<?php
					} else { ?>
					<td><?php echo $download_link; ?></a></td>
					<?php } ?>
					<td><input type="radio" name="mdocs-previous-version" disabled></td>
				</tr>
				<?php
			} 
		}?>
		</tr>
	</table>
	<?php
}