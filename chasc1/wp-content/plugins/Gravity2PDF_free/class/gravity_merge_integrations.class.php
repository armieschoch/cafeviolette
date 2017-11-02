<?php
use Dropbox\Client;
use KevinEm\AdobeSign\AdobeSign;
use Stevenmaguire\OAuth2\Client\Provider\Microsoft;

class Gravity_Merge_Integrations{

	public function __construct(){
		add_action( 'admin_init', array( $this, 'settings_options_init') );
		add_action( 'wp_ajax_emailIntegrationTemplate' , array( $this , 'emailIntegrationTemplate' ) );
		add_action( 'wp_ajax_directDownloadIntegrationTemplate' , array( $this , 'directDownloadIntegrationTemplate' ) );
	}

	public function settings_options_init() {
		register_setting( 'gmerge_integrations_options', 'gmerge_integrations_options', '' );
		register_setting( 'direct_download_file', 'direct_download_file', '' );
	}

	public function emailIntegrationTemplate(){

		$email_options = array();
		if( isset( $_POST['data'] ) ):
			$form_id = isset($_POST['data']['form_id']) ? $_POST['data']['form_id'] : '';
			$form = GFAPI::get_form( $form_id );
			foreach ( $form['fields'] as $key => $field) {
				if( $field['type'] == 'email' ){
					$email_options[] = array(
						'field_id'	=> $field['id'],
						'type'		=> $field['type'],
						'label'		=> $field['label']
					);
				}
			}
		endif;
		$email_select  = '<select name="integrations[%key%][email][integration_email_email]" class="select-2 email-other">';
			$email_select .= '<option value="">---</option>';
			foreach($email_options as $email_option){
				$email_select .= '<option value="'.$email_option['field_id'].'">'.$email_option['label'].'</option>';
			}
			$email_select .= '<option value="other">Other</option>';
		$email_select .= '</select>';

		$template = '';
		$template ='
		<div class="integration-wrapper">
			<a href="javascript:;" class="integration-remove"><span class="dashicons dashicons-minus"></span></a>
			<label><strong>Email</strong></label><br /><br />
			<label>Recepient</label><br />
			'. $email_select .'
			<div class="email-other-wrapper" style="display:none">
				<br /><br />
				<label>Recepients</label><br />
				<input type="text" name="integrations[%key%][email][integration_email_recepient]" />
			</div>
			<br /><br />
			<label>Subject</label><br />
			<input type="text" name="integrations[%key%][email][integration_email_subject]" />
			<br /><br />
			<label>Body</label><br />
			<textarea name="integrations[%key%][email][integration_email_body]" rows="4"></textarea>
		</div>';

		echo $template;
		die();
	}

	public function directDownloadIntegrationTemplate(){
		$template = '';
		$template ='
		<div class="integration-wrapper">
			<a href="javascript:;" class="integration-remove"><span class="dashicons dashicons-minus"></span></a>
			<label><strong>Confirmation Page Download</strong></label><br /><br />
			<input type="hidden" name="integrations[%key%][directdownload][integration_directdownload]" value="1" />
			<span>Use <strong style="color: #ca6535">[gf2pdf_direct_download]</strong> on the success page.</span>
		</div>';

		echo $template;
		die();
	}
}

new Gravity_Merge_Integrations;