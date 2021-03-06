<?php
if(isset($_GET['mdocs-file']) || isset($_GET['is-google']) || isset($_GET['mdocs-version']) || isset($_GET['mdocs-export-file'])) mdocs_download_file();
if(isset($_GET['mdocs-img-preview']) ) { mdocs_preview_image(); }
function mdocs_preview_image() { add_action( 'plugins_loaded', 'mdocs_load_plugins_for_image_preview' ); }
function mdocs_download_file() { add_action( 'plugins_loaded', 'mdocs_load_plugins_for_download' ); }
function mdocs_load_plugins_for_download() {
	$mdocs = get_option('mdocs-list');
	$upload_dir = wp_upload_dir();
	$is_allowed = false;
	// IS GOOGLE PREVIEW
	if(isset($_GET['is-google'])) {
		$is_google = true;
		$the_mdoc = get_the_mdoc_by(mdocs_sanitize_string(basename($_GET['is-google'])), 'id');
		$filename = $the_mdoc['filename'];
		$file = $upload_dir['basedir'].'/mdocs/'.$filename;
	} else $is_google = false;
	// IS BOXVIEW PREVIEW
	if(isset($_GET['is-box-view'])) $is_box_view = true;
	else $is_box_view = false;
	// CHECK TYPE OF DOWNLOAD
	if(isset($_GET['mdocs-export-file']) ) {
		$is_allowed = mdocs_check_file_rights(null, false);
		$filename = basename(mdocs_sanitize_string($_GET['mdocs-export-file']));
		$file = sys_get_temp_dir().'/'.$filename;
		$the_mdoc = array();
		$the_mdoc['non_members'] = '';
	} elseif(isset($_GET['mdocs-version']) ) {
		$the_mdoc = get_the_mdoc_by(basename(mdocs_sanitize_string($_GET['mdocs-file-id'])), 'id');
		$is_allowed = mdocs_check_file_rights($the_mdoc, false);
		$file = $upload_dir['basedir'].'/mdocs/'.basename(mdocs_sanitize_string($_GET['mdocs-version']));
		$filename = substr(basename(mdocs_sanitize_string($_GET['mdocs-version'])), 0, strrpos(basename(mdocs_sanitize_string($_GET['mdocs-version'])), '-'));
	} elseif(isset($_GET["mdocs-file"])) {
		$the_mdoc = get_the_mdoc_by(mdocs_sanitize_string($_GET["mdocs-file"]), 'id');
		$is_allowed = mdocs_check_file_rights($the_mdoc, false);
		$filename = $the_mdoc['filename'];
		$file = $upload_dir['basedir'].'/mdocs/'.$filename;
	} elseif($is_google == false || $is_box_view == false) {
		//mdocs_errors(__('Something when wrong, and your download has failed.'), 'error');
	}
	// COUNT THE DOWNLOAD
	if($is_allowed && !isset($_GET['mdocs-export-file']) && !isset($_GET['mdocs-version']) && $is_box_view === false && $is_google === false) {
		$mdocs[$the_mdoc['index']]['downloads'] = intval($mdocs[$the_mdoc['index']]['downloads'])+1;
		mdocs_save_list($mdocs);
	}
	$filetype = wp_check_filetype($file);
	
	//mdocs_check_file_rights($the_mdoc, false) && $the_mdoc['non_members'] == 'on' || is_user_logged_in()
	if($is_allowed && $the_mdoc['non_members'] == 'on' || is_user_logged_in()  || $is_box_view || $is_google) {
		if (file_exists($file)  ) {
			header('Content-Description: File Transfer');
			header('Content-Type: '.$filetype['type']);
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false); 
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
			exit;
		} else if(!file_exists($file) && $is_box_view == true) die(__('Memphis Documents Error','memphis-documents-library').': '.basename($file).' '.__('was not found, no preview created for this file.', 'memphis-documents-library'));
		else {
			die(__('Memphis Documents Error','memphis-documents-library').': <b>'.basename($file).'</b> '.__('was not found, please contact the owner for assistance.', 'memphis-documents-library'));
		}
	} else {
		$direct_download = get_site_url().'/?mdocs-file='.$the_mdoc['id'];
		$page_redirect = @mdocs_get_permalink($the_mdoc['parent']);
		?>
		<style>
			#outer { width: 100%; margin: 0 auto; font-family: sans-serif;  -webkit-font-smoothing: antialiased; text-shadow: rgba(0,0,0,.01) 0 0 1px;}
			#inner { width: 40%; margin: 200px auto; border: solid 1px #888;}
			h2 { background: #337ab7; color: #fff;  margin: 0; padding: 5px; font-weight: normal;}
			h3 { margin: 0; padding: 5px; font-weight: normal;}
			ul { margin: 0; }
			li { margin: 5px 20px;  padding: 0;}
		</style>
		<div id="outer">
			<div id="inner">
				<h2><?php _e('Sorry you are unauthorized to download this file.','memphis-documents-library'); ?></h1>
				<h3><?php _e('If you have an account with this site, you can try the following links to download the file', 'memphis-documents-library'); ?>:</h3>
				<ul>
					<li>
						<a href="<?php echo wp_login_url($direct_download); ?>" title="<?php _e('Direct Download', 'memphis-documents-library'); ?>"><?php _e('Direct Download','memphis-documents-library'); ?>: </a>
						<?php _e('This link is a direct download of the file, enter you username and password and the download will start.','memphis-documents-library'); ?>
					</li>
					<li>
						<a href="<?php echo wp_login_url($page_redirect); ?>" title="<?php _e('Redirect to Page', 'memphis-documents-library'); ?>"><?php _e('Redirect to Page','memphis-documents-library'); ?>: </a>
						<?php _e('This link will redirect you to a download page, enter your username and password to be redirect to that page.','memphis-documents-library'); ?>
					</li>
				</ul>
			</div>
		</div>
		<?php
		die();
	}
	
}
// IMAGE PREVIEW
function mdocs_load_plugins_for_image_preview() {
	$image_file = sanitize_text_field($_GET['mdocs-img-preview']);
	//$image_file = sanitize_file_name( $image_file );
	$upload_dir = wp_upload_dir();
	$image = $upload_dir['basedir'].MDOCS_DIR.basename($image_file); 
	$content = file_get_contents($image);
	header('Content-Type: image/jpeg');
	echo $content; exit();
}
// EXPORT DOWNLOAD
function mdocs_download_export_file($file) {
	$file = sys_get_temp_dir()."/mdocs-export.zip";
	if (file_exists($file)) {		
			header('Content-Description: File Transfer');
			header('Content-Type: application/zip');
			header('Content-Disposition: attachment; filename="mdocs-export.zip"');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false); 
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
			exit;
	} else mdocs_errors(__('Memphis Documents Error','memphis-documents-library').': '.basename($file).' '.__('was not found, file not exported.', 'memphis-documents-library'), 'error');
}
?>