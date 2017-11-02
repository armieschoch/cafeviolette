<div class="wrap" id="gravity-merge-wrap">
	<?php
		include_once(GM_PATH_INCLUDES.'/gravity_merge_tab_menus.php');
	?>
	<div class="content-wrap">
		<br />
		<?php
		if(!Gravity_Merge_Settings::full_status_check()):
			?>	
			<div id="gmerge-system-error">
				<strong>System didn't passed minimum requirements.</strong>
				<a href="<?= admin_url( 'admin.php?page=gravitymergestatus' ) ?>">View Status</a>
			</div>
			<?php
		else:
			$forms = GFAPI::get_forms();
			$gmerge_db = new Gravity_Merge_Db;
			$merge = $gmerge_db->get_merge($_GET['id']);

			if($merge):
				$details = json_decode($merge->details);
				$mapping = json_decode($merge->mapping);
				?>
				<h2>Gravity Merge Items</h2>
				<a href="<?= admin_url( 'admin.php?page=gravitymerge' ); ?>">&#8592; Back to Merges</a>
				<br /><br />
				<form method="POST" action="">
					<input type="hidden" name="merge_id" value="<?= $merge->id ?>">
					<table class="form-table merge-table">
						<tbody>
							<tr class="form-field form-required term-name-wrap">
								<th scope="row">
									<label for="name">Name</label>
								</th>
								<td>
									<input type="text" name="name" size="40" width="40" value="<?= $merge->name ?>" placeholder="" required>
									<i>Name your merge template.</i>
								</td>
							</tr>
							<tr class="form-field form-required term-name-wrap">
								<th scope="row">
									<label for="file_name">File Name</label>
								</th>
								<td>
									<input type="text" name="file_name" size="40" width="40" value="<?= $details->file_name ?>" placeholder="" required>
									<i>File name for the merged file.</i>
								</td>
							</tr>
							<tr class="form-field form-required term-name-wrap">
								<th scope="row">
									<label for="file_name_timestamps"></label>
								</th>
								<td>
									<input type="checkbox" name="file_name_timestamps" value="1" <?= $details->file_name_timestamps == 1 ? 'checked' : '' ?>>
									<i>Include timestamps to the file name.</i>
								</td>
							</tr>
							<tr class="form-field form-required term-name-wrap">
								<th scope="row">
									<label for="pdf_file">Upload PDF File</label>
								</th>
								<td>
									<input type="hidden" name="pdf_file" id="pdf-file-id" value="<?= $details->pdf_file ?>">
									<textarea style="display:none" id="mapped-fields" name="mapped_fields"><?= str_replace('\\', "", $details->mapped_fields) ?></textarea>
									<a href="javascript:;" class="button button-default" id="upload-pdf">Browse File</a>
									<span class="loading-fields" style="display:none"><img src="<?=  GM_URL . '/assets/images/loading.gif' ?>" width="28" /> Fetching fields...</span>
									<br />
									<br />
									<span id="response-message">
										<strong style="color:green"><?= basename( get_attached_file( $details->pdf_file ) ) ?></strong>
										
									</span>
								</td>
							</tr>
							<tr class="form-field form-required term-name-wrap section-wrap">
								<th scope="row">
									<label for="form">Forms</label>
								</th>
								<td>
									<select name="gravity_form" class="select-2" style="min-width:150px;">
										<option>---</option>
										<?php											
											foreach ($forms as $key => $form) {
												echo '<option value="'.$form['id'].'" '. selected( $merge->form_id, $form['id'], false ) .'>'.$form['title'].'</option>';
											}
										?>
									</select>
								</td>
							</tr>
							<tr class="form-field form-required term-name-wrap section-wrap">
								<th scope="row">
									<label for="flatten_pdf">Map Fields</label>
								</th>
								<td>
									<div class="map-field-item-wrap">
										<div class="label-title">
											<div class="two-cols">
												<label><strong>Gravity Form Fields</strong></label>
											</div>
											<div class="two-cols">
												<label><strong>PDF Fields</strong></label>
											</div>
										</div>
										<div class="clear"></div>
										<br />
										<?php
										$gravity_merge = new Gravity_Merges;
										$gravity_options = $gravity_merge->getGravityFormFieldsGenerator($merge->form_id);
										$pdffields_options = $gravity_merge->getPdfFieldsGenerator($details->pdf_file);
										?>
										<div id="clonable-field">
											<div class="two-cols" id="merge-fields-wrap">
												<select class="merge-fields-select">
												<?php
													foreach ($gravity_options as $gravity_option ) {
														echo '<option value="'.$gravity_option['field_id'].'">'.$gravity_option['label'].'</option>';
													}
												?>
												</select>
											</div>
											<div class="two-cols" id="pdf-fields-wrap">
												<select class="merge-values-select">
												<?php
													foreach ($pdffields_options as $pdffields_option) {
														$pdffields_option = (array)$pdffields_option;
														echo '<option value="'.$pdffields_option['label'].'">'.$pdffields_option['label'].'</option>';
													}
												?>
												</select>
											</div>
										</div>
										<div class="added-fields">
											<!-- populate new fields here -->
											<?php
												foreach ($mapping as $key => $map) {
													?>
													<div class="add-field">
														<div class="two-cols" id="merge-fields-wrap">
															<select class="merge-fields-select select-2" name="merge_fields[]">
																<?php
																foreach ($gravity_options as $gravity_option ) {
																	echo '<option value="'.$gravity_option['field_id'].'" '. selected( explode('-', $map->merge_field)[0], explode('-', $gravity_option['field_id'])[0], false ) .'>'.$gravity_option['label'].'</option>';
																}
																?>
															</select>
														</div>
														<div class="two-cols" id="pdf-fields-wrap">
															<select class="merge-values-select select-2" name="merge_values[]">
																<?php
																foreach ($pdffields_options as $pdffields_option) {
																	$pdffields_option = (array)$pdffields_option;
																	echo '<option value="'.$pdffields_option['label'].'" '. selected( $map->merge_value, $pdffields_option['label'], false ) .'>'.$pdffields_option['label'].'</option>';
																}
																?>
															</select>
														</div>
														<a href="javascript:;" class="remove-toggle"><span class="dashicons dashicons-minus"></span></a>
													</div>
													<?php
												}
											?>
										</div>
										<div class="clear"></div>
										<div style="float:left;padding:12px 4px;" class="add-column-wrap">
											<a class="button button-default" id="add-column">Add Column</a>
										</div>
									</div>
								</td>
							</tr>
							<tr class="form-field form-required term-name-wrap section-wrap">
								<th scope="row">
									<label for="delivery_type">Delivery Type</label>
								</th>
								<td>
									<div id="integrations-container">
										<?php
											$count = 0;
											$merge_integrations = json_decode($merge->integrations); 
											$form = GFAPI::get_form( $merge->form_id );
											$email_options = array();
											foreach ( $form['fields'] as $key => $field) {
												if( $field['type'] == 'email' ){
													$email_options[] = array(
														'field_id'	=> $field['id'],
														'type'		=> $field['type'],
														'label'		=> $field['label']
													);
												}
											}
											if($merge_integrations):
												foreach ($merge_integrations as $merge_integration) {
													foreach ($merge_integration as $key => $value) {
														if( $key == 'email' ){
															?>
															<div class="integration-wrapper">
																<a href="javascript:;" class="integration-remove"><span class="dashicons dashicons-minus"></span></a>
																<label><strong>Email</strong></label><br /><br />
																<label>Recepient</label><br />
																<select name="integrations[<?= $count ?>][email][integration_email_email]" class="select-2 email-other">
																	<option value="">---</option>
																	<?php
																	foreach($email_options as $email_option){
																		echo '<option value="'.$email_option['field_id'].'" '. selected( $value->integration_email_email, $email_option['field_id'], false ) .'>'.$email_option['label'].'</option>';
																	}
																	?>
																	<option value="other" <?= selected( $value->integration_email_email, 'other' ) ?>>Other</option>
																</select><br><br>
																<div class="email-other-wrapper" style="<?= $value->integration_email_email == 'other' ? '' : 'display:none'?>">
																	<label>Recepients</label><br>
																	<input type="text" name="integrations[<?= $count ?>][email][integration_email_recepient]" value="<?= $value->integration_email_recepient ?>">
																	<br><br>
																</div>
																<label>Subject</label><br />
																<input type="text" name="integrations[<?= $count ?>][email][integration_email_subject]" value="<?= $value->integration_email_subject ?>" />
																<br /><br />
																<label>Body</label><br />
																<textarea name="integrations[<?= $count ?>][email][integration_email_body]" rows="4"><?= $value->integration_email_body ?></textarea>
															</div>
															<?php
														}
														elseif ( $key == 'dropbox' ) {
															?>
															<div class="integration-wrapper">
																<a href="javascript:;" class="integration-remove"><span class="dashicons dashicons-minus"></span></a>
																<label><strong>Dropbox</strong></label><br /><br />
																<label>Dropbox Delivery</label><br />
																<input type="text" name="integrations[<?= $count ?>][dropbox][integration_dropbox]" value="<?= $value->integration_dropbox ?>" />
																<span><i>Specified Folder name where the pdf must be uploaded. You can use the following user variables also %date% , %user_email% , %user_firstname% , %user_lastname% for logged in user. You can use gravity form , form entry ids also %form_id% , %form_entry_id%</i></span>
															</div>
															<?php
														}
														elseif ( $key == 'googledrive' ) {
															?>
															<div class="integration-wrapper">
																<a href="javascript:;" class="integration-remove"><span class="dashicons dashicons-minus"></span></a>
																<label><strong>Google Drive</strong></label><br /><br />
																<label>Google Drive Delivery</label><br />
																<input type="text" name="integrations[<?= $count ?>][googledrive][integration_googledrive]" value="<?= $value->integration_googledrive ?>" />
																<span><i>Specified Folder name where the pdf must be uploaded. You can use the following user variables also %date% , %user_email% , %user_firstname% , %user_lastname% for logged in user. You can use gravity form , form entry ids also %form_id% , %form_entry_id%</i></span>
															</div>
															<?php
														}
														elseif ( $key == 'adobesign' ) {
															?>
															<div class="integration-wrapper">
																<a href="javascript:;" class="integration-remove"><span class="dashicons dashicons-minus"></span></a>
																<label><strong>Adobe Sign</strong></label><br /><br />
																<label>Agreement Name</label><br />
																<input type="text" name="integrations[<?= $count ?>][adobesign][agreement_name]" value="<?= $value->agreement_name ?>" required/>
																<br /><br />
																<label>How do you want to have the users sign the document?</label><br />
																<select name="integrations[<?= $count ?>][adobesign][sign_method]"  class="adobe-sign-method">
																	<option value="embedded" <?= selected( $value->sign_method, 'embedded' ) ?>>Embedded</option>
																	<option value="direct-link" <?= selected( $value->sign_method, 'direct-link' ) ?>>Direct Link</option>
																</select>
																<br /><br />
																<div class="adobe-embedded-recepient" <?= $value->sign_method == 'embedded' ? '' : 'style="display:none"' ?>>
																	<label>Send Embedded link to email.</label><br />
																		<select name="integrations[<?= $count ?>][adobesign][embedded_signer_select]" class="select-2 adobe-signer" <?= $value->sign_method == 'embedded' ? 'required="required"' : '' ?>>
																			<option value="">---</option>
																			<?php
																			foreach($email_options as $email_option){
																				echo '<option value="'.$email_option['field_id'].'" '. selected( $value->embedded_signer_select, $email_option['field_id'], false ) .'>'.$email_option['label'].'</option>';
																			}
																			?>
																			<option value="other" <?= selected( $value->embedded_signer_select, 'other' ) ?>>Other</option>
																		</select>
																		<div class="email-other-signer" <?= $value->embedded_signer_select == 'other' ? '' : 'style="display:none"' ?>>
																			<br />
																			<label>Email</label><br />
																			<input type="email" name="integrations[<?= $count ?>][adobesign][embedded_recepient]" value="<?= $value->embedded_recepient ?>" />
																		</div>
																<br /><br />
																</div>
																<label>Signature Flow</label><br />
																<select name="integrations[<?= $count ?>][adobesign][signature_flow]">
																	<option value="SENDER_SIGNATURE_NOT_REQUIRED" <?= selected( $value->signature_flow, 'SENDER_SIGNATURE_NOT_REQUIRED' ) ?>>Sender Signature not Required</option>
																	<option value="SENDER_SIGNS_LAST" <?= selected( $value->signature_flow, 'SENDER_SIGNS_LAST' ) ?>>Sender Signs Last</option>
																	<option value="SENDER_SIGNS_FIRST" <?= selected( $value->signature_flow, 'SENDER_SIGNS_FIRST' ) ?>>Sender Signs First</option>
																	<option value="SEQUENTIAL" <?= selected( $value->signature_flow, 'SEQUENTIAL' ) ?>>Sequential</option>
																	<option value="PARALLEL" <?= selected( $value->signature_flow, 'PARALLEL' ) ?>>Parallel</option>
																	<option value="SENDER_SIGNS_ONLY" <?= selected( $value->signature_flow, 'SENDER_SIGNS_ONLY' ) ?>>Sender Signs Only</option>
																</select>
																<br /><br />
																<label>Add the document <span class="signer-type"><?= $value->sign_method == 'embedded' ? 'counter' : '' ?></span> signers.</label>
																<?php
																foreach($value->signersfromform as $signkey => $signerfrom):
																?>
																	<div class="clonabale-singers">
																		<div class="signers-action">
																			<a href="javascript:;" class="signers-add"><span class="dashicons dashicons-plus"></span></a>
																			<a href="javascript:;" class="signers-remove"><span class="dashicons dashicons-minus"></span></a>
																		</div>
																		<div class="adobe-signer-wrap">
																			<select name="integrations[<?= $count ?>][adobesign][signersfromform][]" class="select-2 adobe-signer" <?= $value->sign_method == 'direct-link' ? 'required="required"' : '' ?>>
																				<option value="">---</option>
																				<?php
																				foreach($email_options as $email_option){
																					echo '<option value="'.$email_option['field_id'].'" '. selected( $signerfrom, $email_option['field_id'], false ) .'>'.$email_option['label'].'</option>';
																				}
																				?>
																				<option value="other" <?= selected( $signerfrom, 'other' ) ?>>Other</option>
																			</select>
																			<div class="email-other-signer" <?= $signerfrom != 'other' ? 'style="display:none"' : '' ?>>
																				<br />
																				<label>Email</label><br />
																				<input type="email" name="integrations[<?= $count ?>][adobesign][signers][]" value="<?= $value->signers[$signkey] ?>" />
																			</div>
																		</div>
																	</div>
																<?php
																endforeach;
																?>
															</div>
															<?php
														}
														elseif ( $key == 'onedrive' ) {
															?>
															<div class="integration-wrapper">
																<a href="javascript:;" class="integration-remove"><span class="dashicons dashicons-minus"></span></a>
																<label><strong>Onerive</strong></label><br /><br />
																<label>Onedrive Delivery</label><br />
																<input type="text" name="integrations[<?= $count ?>][onedrive][integration_onedrive]" value="<?= $value->integration_onedrive ?>" />
																<span><i>Specified Folder name where the pdf must be uploaded. You can use the following user variables also %date% , %user_email% , %user_firstname% , %user_lastname% for logged in user. You can use gravity form , form entry ids also %form_id% , %form_entry_id%</i></span>
															</div>
															<?php
														}
														elseif ( $key == 'directdownload' ) {
															?>
															<div class="integration-wrapper">
																<a href="javascript:;" class="integration-remove"><span class="dashicons dashicons-minus"></span></a>
																<label><strong>Confirmation Page Download</strong></label><br /><br />
																<input type="hidden" name="integrations[<?= $count ?>][directdownload][integration_directdownload]" value="1" />
																<span>Use <strong style="color: #ca6535">[gf2pdf_direct_download]</strong> on the success page.</span>
															</div>
															<?php
														}
														elseif ( $key == 'ftp' ) {
															?>
															<div class="integration-wrapper">
																<a href="javascript:;" class="integration-remove"><span class="dashicons dashicons-minus"></span></a>
																<label><strong>FTP</strong></label><br /><br />
																<label>FTP Delivery</label><br />
																<input type="text" name="integrations[<?= $count ?>][ftp][integration_ftp]" value="<?= $value->integration_ftp ?>" />
																<span><i>Specified Folder name where the pdf must be uploaded. You can use the following user variables also %date% , %user_email% , %user_firstname% , %user_lastname% for logged in user. You can use gravity form , form entry ids also %form_id% , %form_entry_id%</i></span>
															</div>
															<?php
														}
													}
													
													$count++;
												}
											endif;
										?>
									</div>
									<?php
										$gmerge_integrations_options 	= get_option('gmerge_integrations_options');
										$integrations = array();

										if(isset($gmerge_integrations_options['dropbox_enable']) && $gmerge_integrations_options['dropbox_enable'] == 1 ){
											$integrations[] = array(
													'name'	=> 'Dropbox',
													'value'	=> 'dropbox'
												);
										}
										if(isset($gmerge_integrations_options['google_enable']) && $gmerge_integrations_options['google_enable'] == 1 ){
											$integrations[] = array(
													'name'	=> 'Google Drive',
													'value'	=> 'googledrive'
												);
										}
										if(isset($gmerge_integrations_options['adobesign_enable']) && $gmerge_integrations_options['adobesign_enable'] == 1 ){
											$integrations[] = array(
													'name'	=> 'Adobe Sign',
													'value'	=> 'adobesign'
												);
										}
										if(isset($gmerge_integrations_options['onedrive_enable']) && $gmerge_integrations_options['onedrive_enable'] == 1 ){
											$integrations[] = array(
													'name'	=> 'Onedrive',
													'value'	=> 'onedrive'
												);
										}
										if(isset($gmerge_integrations_options['ftp_enable']) && $gmerge_integrations_options['ftp_enable'] == 1 ){
											$integrations[] = array(
													'name'	=> 'Ftp',
													'value'	=> 'ftp'
												);
										}
									?>
									<select id="delivery-type-select">
										<option value="email">Email</option>
										<option value="direct-download">Confirmation Page Download</option>
										<?php
											foreach ($integrations as $key => $integration) {
												echo '<option value="'.$integration['value'].'">'.$integration['name'].'</option>';
											}
										?>
									</select>
									<a href="javascript:;" class="button button-default" id="add-integration">Add</a>
								</td>
							</tr>
							<tr class="form-field form-required term-name-wrap">
								<th scope="row">
									<label for="flatten_pdf">Flatten PDF</label>
								</th>
								<td>
									<label>
										<input type="radio" name="flatten_pdf" value="no" <?= $details->flatten_pdf == 'no' ? 'checked' : '' ?> />
										No
									</label>
									<label>
										<input type="radio" name="flatten_pdf" value="yes" <?= $details->flatten_pdf == 'yes' ? 'checked' : '' ?> />
										Yes
									</label>
								</td>
							</tr>
							<tr class="form-field form-required term-name-wrap">
								<th scope="row">
									<label for="pdf_password">PDF Password</label>
								</th>
								<td>
									<label>
										<input type="radio" name="pdf_password" value="no" <?= $details->pdf_password == 'no' ? 'checked' : '' ?> />
										No
									</label>
									<label>
										<input type="radio" name="pdf_password" value="yes" <?= $details->pdf_password == 'yes' ? 'checked' : '' ?> />
										Yes
									</label>
									<br /><br />
									<div id="pdf-password-wrapper" <?= $details->pdf_password == 'no' ? 'style="display:none"' : '' ?>>
										<input type="text" name="pdf_password_input" size="40" width="40" value="<?= $details->pdf_password_input ?>" placeholder="">
										<i>Set PDF Password</i>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					<input type="submit" class="button button-primary" name="save_new_merge" value="Save">
				</form>
				<?php
			else:
				echo '<h3>Merge not Found!</h3>';
				?>
					<a href="<?= admin_url( 'admin.php?page=gravitymerge' ); ?>">&#8592; Back to Merges</a>
				<?php
			endif;
		endif;
		?>
	</div>
</div>