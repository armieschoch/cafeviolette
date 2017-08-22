<?php
class Gravity_Merge{
	
	private static $instance;

	public static function get_instance()
	{
		if( null == self::$instance ) {
            self::$instance = new Gravity_Merge();
        }

		return self::$instance;
    }

	function __construct(){
		add_action('init', array( $this, 'admin_menus') );
		add_action('admin_enqueue_scripts', array( $this, 'admin_scripts' ));
		add_action('wp_enqueue_scripts', array($this, 'public_scripts'));
		add_action('init', array( $this, 'shortcodes_callback' ));
		add_action('init', array( $this, 'load_settings'));
	}

	public function admin_scripts(){
		wp_register_style( 'admin-style-gravitymerge', GM_URL . '/assets/css/admin-style.css', '1.0', true );
		wp_enqueue_style( 'admin-style-gravitymerge' );

		wp_register_style( 'admin-style-select2', GM_URL . '/assets/css/select2.min.css', '1.0', true );
		wp_enqueue_style( 'admin-style-select2' );
		
		wp_register_script( 'gmerge-admin-script-select2', GM_URL . '/assets/js/select2.full.min.js', '1.0', true );
		wp_enqueue_script( 'gmerge-admin-script-select2' );

		wp_enqueue_media();
		wp_enqueue_script( 'media-upload' );
		wp_register_script( 'gmerge-admin-script', GM_URL . '/assets/js/gmerge-script.js', '1.0', true );
		$gemerge_info = array(
			'ajaxurl' 	=>	admin_url( 'admin-ajax.php' )
		);
		wp_localize_script( 'gmerge-admin-script', 'gmerge', $gemerge_info );
		wp_enqueue_script( 'gmerge-admin-script' );

		wp_register_script( 'integrations-script', GM_URL . '/assets/js/integrations-scripts.js', '1.0', true );
		wp_localize_script( 'integrations-script', 'gmerge', $gemerge_info );
		wp_enqueue_script( 'integrations-script' );
	}

	public function public_scripts(){
		wp_enqueue_script( 'jquery' );
		wp_register_script( 'gemerge-public-script', GM_URL . '/assets/js/gmerge-public-script.js', '1.0', true, true );
		wp_enqueue_script( 'gemerge-public-script' );
	}

	public function admin_menus(){
		new Gravity_Merge_Pages;
	}

	public function shortcodes_callback(){
		add_shortcode( 'gf2pdf_direct_download', array( $this, 'gf2pdf_direct_download' ) );
	}

	public function gf2pdf_direct_download(){
		$content = "<span>Download your file <a href='".get_site_url().'?gmergeaction=download'."'>here</a>.</span>";

		return $content;
	}

	public function load_settings(){
		$gmerge_settings_options = get_option('gmerge_settings_options');
		$gmerge_settings_options['use_own_pdfk'] = 1;
		update_option('gmerge_settings_options', $gmerge_settings_options);

		$gmerge_integrations_options = get_option('gmerge_integrations_options');
		$gmerge_integrations_options['dropbox_enable'] = 0;
		$gmerge_integrations_options['google_enable'] = 0;
		$gmerge_integrations_options['adobesign_enable'] = 0;
		$gmerge_integrations_options['onedrive_enable'] = 0;
		$gmerge_integrations_options['ftp_enable'] = 0;
		update_option('gmerge_integrations_options', $gmerge_integrations_options);
	}
}