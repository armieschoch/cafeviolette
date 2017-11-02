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
		?>
		<h2>Gravity Merge Items</h2>
		<a href="<?= admin_url( 'admin.php?page=gravitymerge' ); ?>">&#8592; Back to Merges</a>
		<br /><br />
		<form method="POST" action="">
			<table class="form-table merge-table">
				<tbody>
					<tr class="form-field form-required term-name-wrap">
						<th scope="row">
							<label for="name">Name</label>
						</th>
						<td>
							<input type="text" name="name" size="40" width="40" value="" placeholder="" required>
							<i>Name your merge template.</i>
						</td>
					</tr>
					<tr class="form-field form-required term-name-wrap">
						<th scope="row">
							<label for="file_name">File Name</label>
						</th>
						<td>
							<input type="text" name="file_name" size="40" width="40" value="" placeholder="" required>
							<i>File name for the merged file.</i>
						</td>
					</tr>
					<tr class="form-field form-required term-name-wrap">
						<th scope="row">
							<label for="file_name_timestamps"></label>
						</th>
						<td>
							<input type="checkbox" name="file_name_timestamps" value="1">
							<i>Include timestamps to the file name.</i>
						</td>
					</tr>
					<tr class="form-field form-required term-name-wrap">
						<th scope="row">
							<label for="pdf_file">Upload PDF File</label>
						</th>
						<td>
							<input type="hidden" name="pdf_file" id="pdf-file-id">
							<textarea style="display:none" id="mapped-fields" name="mapped_fields"></textarea>
							<a href="javascript:;" class="button button-default" id="upload-pdf">Browse File</a>
							<span class="loading-fields" style="display:none"><img src="<?=  GM_URL . '/assets/images/loading.gif' ?>" width="28" /> Fetching fields...</span>
							<br />
							<br />
							<span id="response-message"></span>
						</td>
					</tr>
					<tr class="form-field form-required term-name-wrap section-wrap">
						<th scope="row">
							<label for="form">Forms</label>
						</th>
						<td>
							<select name="gravity_form" class="select-2" style="min-width:150px;" disabled>
								<option>---</option>
								<?php
									foreach ($forms as $key => $form) {
										echo '<option value="'.$form['id'].'">'.$form['title'].'</option>';
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
								<div id="clonable-field">
									<div class="two-cols" id="merge-fields-wrap">
										
									</div>
									<div class="two-cols" id="pdf-fields-wrap">
										
									</div>
								</div>
								<div class="added-fields">
									<!-- populate new fields here -->
								</div>
								<div class="clear"></div>
								<div style="float:left;padding:12px 4px;display:none" class="add-column-wrap">
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
							<div id="integrations-container"></div>
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
								<input type="radio" name="flatten_pdf" value="no" checked="" />
								No
							</label>
							<label>
								<input type="radio" name="flatten_pdf" value="yes" />
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
								<input type="radio" name="pdf_password" value="no" checked="" />
								No
							</label>
							<label>
								<input type="radio" name="pdf_password" value="yes" />Yes
							</label>
							<br /><br />
							<div id="pdf-password-wrapper" style="display:none">
								<input type="text" name="pdf_password_input" size="40" width="40" value="" placeholder="">
								<i>Set PDF Password</i>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<input type="submit" class="button button-primary" name="save_new_merge" value="Save">
		</form>
		<?php
		endif;
		?>
	</div>
</div>