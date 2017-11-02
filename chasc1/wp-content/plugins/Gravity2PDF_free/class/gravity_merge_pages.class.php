<?php
include_once(GM_PATH_CLASS.'/merges_table.class.php');
class Gravity_Merge_Pages 
{
	public $merge_obj;

	public function __construct(){
		add_filter( 'set-screen-option', [ __CLASS__, 'set_screen' ], 10, 3 );
		add_action('admin_menu', array( $this, 'admin_menus'), 10 );
	}

	public function admin_menus(){
		$hook = add_menu_page('Gravity 2 PDF', 'Gravity 2 PDF', 'gravity2pdf_manage', 'gravitymerge', array($this,'gravity_merges'), GM_URL . '/assets/images/gravity2pdf-icon.png');
		add_submenu_page ( 'gravitymerge' , 'New Merge' , 'New Merge' , 'gravity2pdf_create' , 'gravitymerge&action=new' , array( $this , 'gravity_merges' ));
		add_submenu_page ( 'gravitymerge' , 'Gravity Merge Status' , 'System Check' , 'gravity2pdf_status' , 'gravitymergestatus' , array( $this , 'gravity_merge_status' ));
		add_submenu_page ( 'gravitymerge' , 'Gravity Merge Settings' , 'Settings' , 'gravity2pdf_manage_settings' , 'gravitymergesettings' , array( $this , 'gravity_merge_settings' ));

		add_action( "load-$hook", [ $this, 'screen_option' ] );
	}

	public static function set_screen( $status, $option, $value ) {
		return $value;
	}

	public function screen_option() {
		$option = 'per_page';
		$args   = [
			'label'   => 'Merges',
			'default' => 10,
			'option'  => 'merges_per_page'
		];

		add_screen_option( $option, $args );

		$this->merge_obj = new Merge_List();
	}

	public function gravity_merges(){
		if( isset($_REQUEST['action']) && $_REQUEST['action'] == 'new' ) {
			include_once(GM_PATH_INCLUDES.'/gravity_merges_new.php');
		} 
		elseif( isset($_REQUEST['action']) && $_REQUEST['action'] == 'update' ) {
			include_once(GM_PATH_INCLUDES.'/gravity_merges_update.php');
		} 
		else {
			include_once(GM_PATH_INCLUDES.'/gravity_merges.php');
		}
	}

	public function gravity_merge_settings(){
		include_once(GM_PATH_INCLUDES.'/gravity_merge_settings.php');
	}

	public function gravity_merge_integrations(){
		include_once(GM_PATH_INCLUDES.'/gravity_merge_integrations.php');
	}

	public function gravity_merge_lincenses(){
		include_once(GM_PATH_INCLUDES.'/gravity_merge_lincenses.php');
	}

	public function gravity_merge_status(){
		include_once(GM_PATH_INCLUDES.'/gravity_merge_status.php');
	}
}