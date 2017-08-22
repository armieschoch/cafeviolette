<?php
class Gravity_Merge_Settings{

	public function __construct(){
		add_action('admin_init', array( $this, 'settings_options_init' ));
		add_action('init', array($this, 'define_settings'));
	}

	public function settings_options_init() {
		register_setting( 'gmerge_settings_options', 'gmerge_settings_options', '' );
	}

	public function define_settings(){
		$gmerge_settings_options = get_option('gmerge_settings_options');

		$pdftk_location = ( isset($gmerge_settings_options['pdftk_location']) && $gmerge_settings_options['pdftk_location'] != '') ? $gmerge_settings_options['pdftk_location'] : '';
		$temp_path = ( isset($gmerge_settings_options['temp_path']) && $gmerge_settings_options['temp_path'] != '') ? $gmerge_settings_options['temp_path'] : '';
		$upload_dir = wp_upload_dir();

		define( 'PDFTK_LIBRARY_LOCATION', $pdftk_location );
		define( 'GRAVITY_MERGE_PLUGIN_TMP_UPLOAD_DIR', $upload_dir['basedir'].'/'.ltrim(rtrim($temp_path, '/'), '/').'/' );
	}

	public static function pdftk_location_check(){
		return true;
	}

	public static function temp_path_check(){
		if( file_exists( GRAVITY_MERGE_PLUGIN_TMP_UPLOAD_DIR ) && is_writable( GRAVITY_MERGE_PLUGIN_TMP_UPLOAD_DIR ) )
			return true;

		return false;
		// return true;
	}

	public static function check_php_version(){
		if (version_compare(phpversion(), "5.6", "<"))
			return false;

		return true;
	}

	public static function full_status_check(){
		if(self::pdftk_location_check() && self::temp_path_check() && self::check_php_version())
			return true;

		return false;
	}
}

new Gravity_Merge_Settings;