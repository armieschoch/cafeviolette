<div class="wrap" id="gravity-merge-wrap">
	<?php settings_errors() ?>
	<?php
		include_once(GM_PATH_INCLUDES.'/gravity_merge_tab_menus.php');
	?>
	<div class="content-wrap">
		<?php
			$gmerge_settings_options = get_option('gmerge_settings_options');
			$temp_path = isset($gmerge_settings_options['temp_path']) ? $gmerge_settings_options['temp_path'] : '';

		?>
		<br />
		<h2>Gravity Merge Settings</h2>
		<form method="post" action="options.php">
			<?php settings_fields( 'gmerge_settings_options' ); ?>
			<?php do_settings_sections( 'gmerge_settings_options' ); ?> 
			<table class="form-table">
				<tbody>
					<tr class="form-field form-required term-name-wrap">
						<th scope="row">
							<label>Use Our PDFTK Library</label>
						</th>
						<td>
							<input value="1" type="checkbox" name="gmerge_settings_options[use_own_pdfk]" id="use-ownpdfk" disabled="disabled" checked>
						</td>
					</tr>
					<tr class="form-field form-required term-name-wrap">
						<th scope="row">
							<label>PDFTK Library Location</label>
						</th>
						<td>
							<em style="color: #f75252;">Gravity 2 PDF Free does not support defining your own PDFTK library. Please upgrade for this feature.</em>
						</td>
					</tr>
					<tr class="form-field form-required term-name-wrap">
						<th scope="row">
							<label>Temporary Path</label>
						</th>
						<td>
							<input type="text" name="gmerge_settings_options[temp_path]" size="40" width="40" value="<?= $temp_path ?>">
						</td>
					</tr>
				</tbody>
			</table>
			<p>
				<input type="submit" name="save_settings" class="button button-primary" value="Save">
			</p>
		</form>
	</div>
</div>