<?php
class Gravity_Merge_Send{

	public function __construct(){
		add_action('gform_after_submission', array($this, 'sendGravityPdfMerge'));
		add_action('init', array($this, 'downloadFileFromDirectDownload'));
	}

	public function sendGravityPdfMerge($entry){
		$gmerge_db = new Gravity_Merge_Db;
		$merges = $gmerge_db->get_merge_by_form_id($entry['form_id']);
		
		foreach ($merges as $key => $merge) {
			$details = json_decode($merge->details);
			$mapping = json_decode($merge->mapping);

			$pdf_fields_mapping = array();
			$temp_type = '';
			foreach ($mapping as $key => $map) {
				$pdf_field		= explode('||', $map->merge_value);
				$gform_field	= explode('-', $map->merge_field);
				if( count($pdf_field) == 2 ){
					if(rgar( $entry, $gform_field[0]) != ''){
						$pdf_fields_mapping[trim($pdf_field[0])] = trim($pdf_field[1]);
					}
					elseif( rgar( $entry, explode(".", $gform_field[0] )[0]) != '' ){
						if( rgar( $entry, explode(".", $gform_field[0] )[0]) == $gform_field[1] ){
							$pdf_fields_mapping[trim($pdf_field[0])] = trim($pdf_field[1]);
						}
					}
				}
				else{
					$pdf_fields_mapping[trim($pdf_field[0])] = rgar( $entry, explode(".", $gform_field[0] )[0]);
				}
			}

			// get the original PDF form
			$fullsize_path = get_attached_file( $details->pdf_file );

			/**** file name ****/
			$file_name = $details->file_name;
			if($details->file_name_timestamps == 1){
				$file_name .= '-'.time();
			}
			$final_file = GRAVITY_MERGE_PLUGIN_TMP_UPLOAD_DIR."$file_name.pdf";
			/**** end file name ****/

			$file_generated = false;
			$flatten = false;
			if($details->flatten_pdf == 'yes'){
				$flatten = true;
			}

			$passwordthepdf = false;
			$pdfpassword 	= '';
			if($details->pdf_password == 'yes'){
				$passwordthepdf = true;
				$pdfpassword 	= $details->pdf_password_input;
			}

			$generated_pdf_result = generateEndPdf( $fullsize_path , $file_name.'.pdf' , json_encode($pdf_fields_mapping) , $flatten , $passwordthepdf , $pdfpassword );
			$generated_pdf = (array)json_decode( $generated_pdf_result );

			if( isset($generated_pdf['result']) && $generated_pdf['result'] == 'success' ) {
				$file_url = str_replace("\\", "", $generated_pdf['fileurl']);
				if( $this->downloadFile( $file_url , $final_file ) )
				{
					
				}
				else{
					// $gravity_merge['total'] = $total_attempts + 1;
					// $gravity_merge['successful'] = $success_attempts;
					// $gravity_merge['failure'] = $gravity_merge['total'] - $gravity_merge['successful'];
				}
				$file_generated = true;
			}

			if($file_generated):
				$gmerge_integrations_options = get_option('gmerge_integrations_options');
				$merge_integrations = json_decode($merge->integrations);
				$direct_download_check = false;
				if($merge_integrations):
					foreach ($merge_integrations as $merge_integration){
						foreach ($merge_integration as $key => $value){
							if($key == 'email'){
								$this->emailDelivery($value, $final_file, $entry);
							}
							elseif($key == 'directdownload'){
								$direct_download_check = 1;
								$this->directDownload($final_file);
							}
							// end
						}
					}
				endif;

				//supposed unlink

			endif;
		} // end loop merges
	}

	private function emailDelivery($value, $final_file, $entry){
		if( $value->integration_email_email == 'other' )
			$to =  $value->integration_email_recepient;
		else
			$to = rgar( $entry, $value->integration_email_email );
		
		$subject 	 = $value->integration_email_subject;
		$body 		 = $value->integration_email_body;
		$headers 	 = array('Content-Type: text/html; charset=UTF-8');
		$attachments = array( $final_file );
		 
		wp_mail( $to, $subject, $body, $headers, $attachments );
	}

	private function directDownload($final_file){
		update_option( 'direct_download_file', $final_file );
	}

	public function downloadFileFromDirectDownload(){
		if (isset($_REQUEST['gmergeaction']) && $_REQUEST['gmergeaction'] == 'download' ):
			$direct_download_file = get_option('direct_download_file');
			if(!empty($direct_download_file)){
				$final_file = $direct_download_file;
				if (file_exists($final_file)) {
					delete_option('direct_download_file');
				    header('Content-Description: File Transfer');
				    header('Content-Type: application/octet-stream');
				    header('Content-Disposition: attachment; filename="'.basename($final_file).'"');
				    header('Expires: 0');
				    header('Cache-Control: must-revalidate');
				    header('Pragma: public');
				    header('Content-Length: ' . filesize($final_file));
				    readfile($final_file);
				    unlink($final_file);
				}
			}
		endif;
	}

	public function downloadFile($url, $path){
		$url = str_replace(' ', '%20', $url);
		file_put_contents($path, fopen($url, 'rb'));
	}

}

new Gravity_Merge_Send;