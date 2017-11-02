<?php
//add_filter( 'wp_default_editor', create_function('', 'return "tinymce";') );
define('MDOCS_CATS', 'mdocs-cats.txt');
define('MDOCS_LIST', 'mdocs-list.txt');
define('MDOCS_DIR','/mdocs/');
//if(get_option('mdocs-override-time-offset') == true) define('MDOCS_TIME_OFFSET', floatval(get_option('mdocs-override-time-offset-value'))*60*60);
//else define('MDOCS_TIME_OFFSET', get_option('gmt_offset')*60*60);
define('MDOCS_TIME_OFFSET', get_option('gmt_offset')*60*60);
define('MDOCS_ROBOTS','http://www.kingofnothing.net/memphis/robots/memphis-robots.txt');

$mdocs_img_types = array('jpeg','jpg','jif','jfif','png','gif', 'tif', 'tiff');
$mdocs_input_text_bg_colors = array('#f1f1f1','#e5eaff','#efffe7','#ffecdc','#ffe9fe','#ff5000','#00ff20');


function mdocs_register_settings() {
	//CREATE REPOSITORY DIRECTORY
	$upload_dir = wp_upload_dir();
	if(mdocs_check_read_write()) {
		//BACKUP FILE CREATE
		$backup_list = json_encode(get_option('mdocs-list'));
		$current_list = get_option('mdocs-list');
		if($current_list != null || is_array($current_list)) file_put_contents($upload_dir['basedir'].MDOCS_DIR.'mdocs-files.bak', $backup_list);
		elseif(file_exists($upload_dir['basedir'].MDOCS_DIR.'mdocs-files.bak') && !isset($_GET['restore-default'])) {
			$backup_list = json_decode(file_get_contents($upload_dir['basedir'].MDOCS_DIR.'mdocs-files.bak'),true);
			update_option('mdocs-list', $backup_list, '' , 'no');
		}
		// RUN PATCHES
		mdocs_patches();
		// Creating File Structure
		if(!is_dir($upload_dir['basedir'].'/mdocs/') && $upload_dir['error'] === false) mkdir($upload_dir['basedir'].'/mdocs/');
		elseif(!is_dir($upload_dir['basedir'].'/mdocs/') && $upload_dir['error'] !== false) mdocs_errors(__('Unable to create the directory "mdocs" which is needed by Memphis Documents Library. Is its parent directory writable by the server?','memphis-documents-library'),'error');
		//CREATE MDOCS PAGE
		$query = new WP_Query('pagename=mdocuments-library');	
		if(empty($query->posts) && empty($query->queried_object) ) {
			$mdocs_page = array(
				'post_title' => __('Documents','memphis-documents-library'),
				'post_name' => 'mdocuments-library',
				'post_content' => '[mdocs]',
				'post_status' => 'publish',
				'post_author' => 1,
				'post_type' => 'page',
				'comment_status' => 'closed'
			);
			$mdocs_post_id = wp_insert_post( $mdocs_page );	
		}
		if(!is_dir($upload_dir['basedir'].'/mdocs-ftp/') && $upload_dir['error'] === false) mkdir($upload_dir['basedir'].'/mdocs-ftp/');
		//REGISTER SAVED VARIABLES
		mdocs_init_settings();
		$upload_dir = wp_upload_dir();
		if(!file_exists($upload_dir['basedir'].'/mdocs/.htaccess')) {
			if(!file_exists($upload_dir['basedir'].'/mdocs/')) mkdir($upload_dir['basedir'].'/mdocs/');
			$htaccess = $upload_dir['basedir'].'/mdocs/.htaccess';
			$fh = fopen($htaccess, 'w');
			$mdocs_htaccess = get_option('mdocs-htaccess');
			fwrite($fh, $mdocs_htaccess);
			fclose($fh);
			chmod($htaccess, 0660);
		}
	}
	
}
function mdocs_update_view_private_users() {
	$mdocs_roles = get_option('mdocs-view-private');
	$wp_roles = get_editable_roles();
	foreach($wp_roles as $index => $wp_role) {
		if(isset($mdocs_roles[$index])) {
			if($mdocs_roles[$index] == true || $index == 'administrator') {
				$add_role = get_role( $index );
				$add_role->add_cap( 'read_private_pages' );
				$add_role->add_cap( 'read_private_posts' );
				$mdocs_roles[$index] = true;
			} else {
				$add_role = get_role( $index );
				$add_role->remove_cap( 'read_private_pages' );
				$add_role->remove_cap( 'read_private_posts' );
				$mdocs_roles[$index] = false;
			}
		} else $mdocs_roles[$index] = false;
	}
	update_option('mdocs-view-private', $mdocs_roles);
	return $mdocs_roles;
}
function mdocs_init_view_private() {
	$roles = get_editable_roles();
	$view_private = array();
	foreach($roles as $index => $role) {
		if(isset($role['capabilities']['read_private_pages']) || isset($role['capabilities']['read_private_posts']) || $index == 'administrator') $view_private[$index] = true;
		else $view_private[$index] = false;
	}
	return $view_private;
}
//MODIFY TINYMCE
function mdocs_wptiny($initArray){
    $initArray['height'] = '600px';
	//$initArray['remove_linebreaks'] = true;
	//$initArray['forced_root_block'] = false;
	//$initArray['plugins'] = 'wplink,wordpress';
    return $initArray;
}
function mdocs_admin_script() {
	if(isset($_GET['page']) && $_GET['page'] == 'memphis-documents.php' ) {
		if(MDOCS_DEV) {
			$bootstrap_css_file = 'bootstrap/bootstrap.css';
			$mdocs_css = 'memphis-documents.css';
			$mdocs_js = 'memphis-documents.js';
			$mdocs_rtl = 'memphis-documents-rtl.css';
		} else {
			$bootstrap_css_file = 'bootstrap/bootstrap.min.css';
			$mdocs_css = 'memphis-documents.min.css';
			$mdocs_js = 'memphis-documents.min.js';
			$mdocs_rtl = 'memphis-documents-rtl.min.css';
		}
		// MODIFIES THE TINY MCE EDITOR FOR MDOCS
		add_filter('tiny_mce_before_init', 'mdocs_wptiny');
		//JQUERY
		wp_enqueue_script("jquery");
		//BOOTSTRAP
		//wp_register_style( 'bootstrap.min.css', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
		//wp_enqueue_style( 'bootstrap.min.css' );
		wp_register_style( 'bootstrap.site.min.css', MDOC_URL.$bootstrap_css_file);
		wp_enqueue_style( 'bootstrap.site.min.css' );
		if(get_option('mdocs-disable-bootstrap-admin') == false) wp_enqueue_script( 'bootstrap.min.js', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' );
		
		//FONT-AWESOME STYLE
		if(get_option('mdocs-disable-fontawesome') == false) wp_register_style( 'font-awesome.min.css', '//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css');
		wp_enqueue_style( 'font-awesome.min.css' );
		//WORDPRESS IRIS COLOR PICKER
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker', plugins_url('wp-color-picker.js', MDOC_PATH.'memphis-documents.php' ), array( 'wp-color-picker' ), false, true );
		//MEMPHIS DOCS
		wp_register_style( 'memphis-documents.css', MDOC_URL.$mdocs_css);
		wp_enqueue_style( 'memphis-documents.css' );
		wp_register_script( 'memphis-documents.js', MDOC_URL.$mdocs_js);
		wp_enqueue_script('memphis-documents.js');
		if(is_rtl() ) {
			wp_register_style( 'memphis-documents-rtl.css', MDOC_URL.'/'.$mdocs_rtl);
			wp_enqueue_style( 'memphis-documents-rtl.css' );
		}
		//INLINE STYLE
		mdocs_inline_admin_css('memphis-documents.css');
		mdocs_js_handle('memphis-documents.js');
		mdocs_load_modals();
	}
}

function mdocs_script() {
	global $post;
	if(isset($post)) {
		// USED TO MAKE THE FUNCTION is_plugin_active() work in the frontend.
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if(has_shortcode( $post->post_content, 'mdocs_post_page' ) || get_post_type($post) == 'mdocs-posts' || has_shortcode( $post->post_content, 'mdocs' ) || is_home() || is_plugin_active('so-widgets-bundle/so-widgets-bundle.php')  || is_plugin_active('wp_roksprocket/roksprocket.php') || is_plugin_active('woocommerce/woocommerce.php' )) {
			if(MDOCS_DEV) {
				$bootstrap_css_file = 'bootstrap/bootstrap.css';
				$mdocs_css = 'memphis-documents.css';
				$mdocs_js = 'memphis-documents.js';
				$mdocs_rtl = 'memphis-documents-rtl.css';
			} else {
				$bootstrap_css_file = 'bootstrap/bootstrap.min.css';
				$mdocs_css = 'memphis-documents.min.css';
				$mdocs_js = 'memphis-documents.min.js';
				$mdocs_rtl = 'memphis-documents-rtl.min.css';
			}
			//JQUERY
			if(get_option('mdocs-disable-jquery') == false) {
				wp_enqueue_script("jquery");
			}
			//BOOTSTRAP
			wp_register_style( 'memphis-bootstrap.min.css', MDOC_URL.$bootstrap_css_file);
			wp_enqueue_style( 'memphis-bootstrap.min.css' );
			if(get_option('mdocs-disable-bootstrap') == false && has_shortcode( $post->post_content, 'mdocs' )  || is_plugin_active('so-widgets-bundle/so-widgets-bundle.php') || is_plugin_active('wp_roksprocket/roksprocket.php') || is_plugin_active('woocommerce/woocommerce.php' ) || get_option('mdocs-disable-bootstrap') == false && has_shortcode( $post->post_content, 'mdocs_post_page' )  ) {
				$handle = 'bootstrap.min.js';
				$list = 'enqueued';
				if (wp_script_is( $handle, $list )) { return; }
				else {
					//wp_register_script( 'bootstrap.min.js', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
					wp_enqueue_script( 'bootstrap.min.js', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', false, true);
				}
			}
			//FONT-AWESOME STYLE
			if(get_option('mdocs-disable-fontawesome') == false) {
				wp_register_style( 'font-awesome.min.css', '//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css');
				wp_enqueue_style( 'font-awesome.min.css' );
			}
			//MEMPHIS DOCS
			wp_register_style( 'memphis-documents.css', MDOC_URL.'/'.$mdocs_css);
			wp_enqueue_style( 'memphis-documents.css' );
			wp_register_script( 'memphis-documents.js', MDOC_URL.'/'.$mdocs_js);
			wp_enqueue_script('memphis-documents.js');
			if(is_rtl() ) {
				wp_register_style( 'memphis-documents-rtl.css', MDOC_URL.'/'.$mdocs_rtl);
				wp_enqueue_style( 'memphis-documents-rtl.css' );
			}
			mdocs_inline_css('memphis-documents.css');
			mdocs_js_handle('memphis-documents.js');
			//wp_enqueue_style( 'wp-color-picker' );
			//wp_enqueue_script( 'mdocs-color-picker', plugins_url('mdocs-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
		}
	}
}

function mdocs_inline_css($style_name) {
	$set_inline_style = mdocs_get_inline_css();
	wp_add_inline_style( $style_name, $set_inline_style );
}
function mdocs_inline_admin_css($style_name) {
	$set_inline_style = mdocs_get_inline_css();
	wp_add_inline_style( $style_name, $set_inline_style );
}

function mdocs_document_ready_wp() {
	global $post;
	if(isset($post)) {
		if(has_shortcode( $post->post_content, 'mdocs_post_page' ) || get_post_type($post) == 'mdocs-posts' || has_shortcode( $post->post_content, 'mdocs' ) || is_plugin_active('so-widgets-bundle/so-widgets-bundle.php')  || is_plugin_active('wp_roksprocket/roksprocket.php') || is_plugin_active('woocommerce/woocommerce.php' )) {
	?>
	<script type="application/x-javascript">
			jQuery( document ).ready(function() {
				mdocs_wp('<?php echo MDOC_URL; ?>', '<?php echo ABSPATH; ?>');
			});	
		</script>
	<?php
			mdocs_load_modals();
		}
	}
	
}
function mdocs_document_ready_admin() {
	if(!is_network_admin() && isset($_GET['page']) && $_GET['page'] == 'memphis-documents.php') {
?>
<script type="text/javascript">
	jQuery( document ).ready(function() {
		mdocs_admin('<?php echo MDOC_URL; ?>', '<?php echo ABSPATH; ?>');
	});	
</script>
<?php
	}
}
function mdocs_send_headers() {
	//SET SORT VALUES SITE
	if(isset($_POST['sort_type'])) setcookie('mdocs-sort-type-site', $_POST['mdocs-sort-type']); 
	if(isset($_POST['sort_range'])) setcookie('mdocs-sort-range-site', $_POST['mdocs-sort-range']);
}
function mdocs_send_headers_dashboard() {
	//SET SORT VALUES DASHBOARD
	if(isset($_POST['sort_type'])) setcookie('mdocs-sort-type-dashboard', $_POST['mdocs-sort-type']); 
	if(isset($_POST['sort_range'])) setcookie('mdocs-sort-range-dashboard', $_POST['mdocs-sort-range']);
}


?>