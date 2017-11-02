<?php
use mikehaertl\pdftk\Pdf;

class Gravity_Merges{

	public function __construct(){
		add_action('init', array($this, 'save_new_merge'));
		add_action('init', array($this, 'update_merge'));
		add_action( 'wp_ajax_getPdfFields' , array( $this , 'getPdfFields' ) );
		add_action( 'wp_ajax_getGravityFormFields' , array( $this , 'getGravityFormFields' ) );
	}

	public function save_new_merge(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['action']) && $_REQUEST['action'] == 'new' ) {

			$detais = array(
					'file_name'				=> isset($_POST['file_name']) ? $_POST['file_name'] : '',
					'file_name_timestamps'	=> isset($_POST['file_name_timestamps']) ? $_POST['file_name_timestamps'] : '',
					'pdf_file'				=> isset($_POST['pdf_file']) ? $_POST['pdf_file'] : '',
					'mapped_fields'			=> isset($_POST['mapped_fields']) ? $_POST['mapped_fields'] : '',
					'flatten_pdf'			=> isset($_POST['flatten_pdf']) ? $_POST['flatten_pdf'] : '',
					'pdf_password'			=> isset($_POST['pdf_password']) ? $_POST['pdf_password'] : '',
					'pdf_password_input'	=> isset($_POST['pdf_password_input']) ? $_POST['pdf_password_input'] : ''
				);

			$mapping = array();
			if(isset($_POST['merge_fields'])):
				foreach( $_POST['merge_fields'] as $key => $map ){
					$mapping[] = array(
							'merge_field'	=> $_POST['merge_fields'][$key],
							'merge_value'	=> $_POST['merge_values'][$key]
						);
				}
			endif;

			$gmerge_db = new Gravity_Merge_Db();
			$data = array(
					'name'		=> isset($_POST['name']) ? $_POST['name'] : '',
					'form_id'	=> isset($_POST['gravity_form']) ? $_POST['gravity_form'] : '',
					'details'	=> json_encode($detais),
					'mapping'	=> json_encode($mapping),
					'integrations'	=> json_encode( isset($_POST['integrations']) ? $_POST['integrations'] : '' )
				);
			$merge_id = $gmerge_db->insert_merge($data);
			wp_redirect( admin_url() . "admin.php?page=gravitymerge&action=update&id=$merge_id" );
		}
	}

	public function update_merge(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['action']) && $_REQUEST['action'] == 'update' && isset($_GET['id']) && $_GET['id'] != '' ) {

			$detais = array(
					'file_name'				=> isset($_POST['file_name']) ? $_POST['file_name'] : '',
					'file_name_timestamps'	=> isset($_POST['file_name_timestamps']) ? $_POST['file_name_timestamps'] : '',
					'pdf_file'				=> isset($_POST['pdf_file']) ? $_POST['pdf_file'] : '',
					'mapped_fields'			=> isset($_POST['mapped_fields']) ? $_POST['mapped_fields'] : '',
					'flatten_pdf'			=> isset($_POST['flatten_pdf']) ? $_POST['flatten_pdf'] : '',
					'pdf_password'			=> isset($_POST['pdf_password']) ? $_POST['pdf_password'] : '',
					'pdf_password_input'	=> isset($_POST['pdf_password_input']) ? $_POST['pdf_password_input'] : ''
				);

			$mapping = array();
			if(isset($_POST['merge_fields'])):
				foreach( $_POST['merge_fields'] as $key => $map ){
					$mapping[] = array(
							'merge_field'	=> $_POST['merge_fields'][$key],
							'merge_value'	=> $_POST['merge_values'][$key]
						);
				}
			endif;

			$gmerge_db = new Gravity_Merge_Db();
			$data = array(
					'name'		=> isset($_POST['name']) ? $_POST['name'] : '',
					'form_id'	=> isset($_POST['gravity_form']) ? $_POST['gravity_form'] : '',
					'details'	=> json_encode($detais),
					'mapping'	=> json_encode($mapping),
					'integrations'	=> json_encode( isset($_POST['integrations']) ? $_POST['integrations'] : '' )
				);
			$gmerge_db->update_merge($_POST['merge_id'], $data);
		}
	}

	function getGravityFormFields(){
		if( isset( $_POST['data'] ) ):
			$fields_array = $this->getGravityFormFieldsGenerator($_POST['data']['form_id']);
			if( count($fields_array) ){
				echo json_encode(array(
						'result' => 'success',
						'fields' => $fields_array
					)
				);
			} else {
				echo json_encode(array(
						'result' => 'fail'
					)
				);

			}
			die();
		endif;
	}

	public function getPdfFields(){

		if( isset( $_POST['data'] ) ):
			$attachment_id = $_POST['data']['attachment_id'];
			
			$parsed_pdf_fields = $this->getPdfFieldsGenerator($attachment_id);

			if( count($parsed_pdf_fields) && $parsed_pdf_fields[0] != 'No Field Present' ){
				echo json_encode(array(
						'result' => 'success',
						'fields' => $parsed_pdf_fields
					)
				);
			} else {
				echo json_encode(array(
						'result' => 'fail',
					)
				);
			}

			die();
		endif;
	}

	public function getGravityFormFieldsGenerator($form_id){
		$form = GFAPI::get_form( $form_id );
		$fields_array = array();
		foreach ( $form['fields'] as $key => $field) {
			if( $field['type'] == 'radio' ){
				foreach ( $field['choices'] as $key => $choice) {
					$fields_array[] = array(
						'field_id'		=> $field['id'].'.'.($key+1).'-'.$choice['value'],
						'type'			=> $field['type'],
						'label'			=> $field['label'].'-'.$choice['value'],
						'orig_field_id'	=> $field['id']
					);
				}
			}
			elseif( $field['type'] == 'checkbox' ){
				foreach ( $field['choices'] as $key => $choice) {
					$mapkey = ($key >= 9) ? ($key+2) : ($key+1);
					$fields_array[] = array(
						'field_id'		=> $field['id'].'.'. $mapkey.'-'.$choice['value'],
						'type'			=> $field['type'],
						'label'			=> $field['label'].'-'.$choice['value'],
						'orig_field_id'	=> $field['id']
					);
				}
			}
			else {
				$fields_array[] = array(
						'field_id'	=> $field['id'].'-@',
						'type'		=> $field['type'],
						'label'		=> $field['label']
					);
			}
		}

		return $fields_array;
	}

	public function getPdfFieldsGenerator($attachment_id){
		$fullsize_path = get_attached_file( $attachment_id );
		$filename_only = basename( get_attached_file( $attachment_id ) );

		$gmerge_settings_options = get_option('gmerge_settings_options');
		$use_own_pdfk = isset($gmerge_settings_options['use_own_pdfk']) ? $gmerge_settings_options['use_own_pdfk'] : '';

		$parsed_pdf_fields = array();
		$result = getPdfFields( $fullsize_path , $filename_only , 'pdf' );
		$result_array = json_decode( $result );

		$parsed_pdf_fields = (array)$result_array->fields ;

		return $parsed_pdf_fields;
	}

	public function parsePDFFieldString($data){
		$group_data = explode('---', $data);
		$field_props_array = array();
		foreach($group_data as $value){
			$isbutton = false;
			$trimmed_value = trim( $value );
			$field_props = explode( "\n" , $trimmed_value );

			if( strpos( $value , "FieldType: Button" ) != false ){
				$isbutton = true;
			}

			if( $field_props[0] != "" ){
				if( $isbutton ){
					$FieldStateOption = array();

					foreach( $field_props as $fieldindex => $field_prop_string ){
						$field_prop_array = explode( ":" , $field_prop_string );
						if( $field_prop_array[0] == "FieldStateOption" ){
							$FieldStateOption[] = $field_prop_array[1];
						} else {
							$field_array[$field_prop_array[0]] =  $field_prop_array[1];
						}
					}

					$FieldName = $field_array['FieldName'];
					foreach( $FieldStateOption as $FieldStateOption_index => $FieldStateOption_value ){
						if( trim($FieldStateOption_value) != "Off" ){
							$field_array['FieldName'] = $FieldName."||".$FieldStateOption_value; 
							$field_array['FieldValue'] = $FieldStateOption_value;
							$field_props_array[] = $field_array;
						}
					}
				} else {
					foreach( $field_props as $fieldindex => $field_prop_string ){
						$field_prop_array = explode( ":" , $field_prop_string );
						$field_array[$field_prop_array[0]] =  $field_prop_array[1];
					}
					$field_props_array[] = $field_array;
				}
				$field_array = array();
			}
		}
		return $field_props_array;
	}
}
new Gravity_Merges;