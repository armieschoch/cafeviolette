<div class="wrap" id="gravity-merge-wrap">
	<?php
		include_once(GM_PATH_INCLUDES.'/gravity_merge_tab_menus.php');
	?>
	<div class="content-wrap">
		<br />
		<h2>Gravity Merge <?= GM_VERSION ?></h2>
		<img src="<?= GM_URL . '/assets/images/gravity2pdf-logo.png' ?>" width="300" style="width:300px" />
		<table class="form-table">
				<tbody>
					<tr class="form-field form-required term-name-wrap">
						<th scope="row">
							<label>PDFTK Library</label>
						</th>
						<td>
							<?php
								if( Gravity_Merge_Settings::pdftk_location_check() )
									echo "<span style='color:green;'>Pass</span>";
								else
									echo "<span style='color:red;'>Fail</span>";
							?>
						</td>
					</tr>
					<tr class="form-field form-required term-name-wrap">
						<th scope="row">
							<label>Temporary Path</label>
						</th>
						<td>
							<?php
								if( Gravity_Merge_Settings::temp_path_check() )
									echo "<span style='color:green;'>Pass</span>";
								else
									echo "<span style='color:red;'>Fail</span>";
							?>
						</td>
					</tr>
					<tr class="form-field form-required term-name-wrap">
						<th scope="row">
							<label>PHP Version (5.6.*)</label>
						</th>
						<td>
							<?php
								if( Gravity_Merge_Settings::check_php_version() )
									echo "<span style='color:green;'>Pass</span>";
								else
									echo "<span style='color:red;'>Fail</span>";
							?>
						</td>
					</tr>
				</tbody>
			</table>
	</div>	
</div>