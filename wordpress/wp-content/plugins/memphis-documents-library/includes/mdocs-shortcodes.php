<?php
function mdocs_shortcodes($current_cat) {
	mdocs_list_header();
	?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><?php _e('Short Codes','memphis-documents-library'); ?></h3>
		</div>
		<div class="panel-body">
			<table class="table table-hover table-striped table-bordered" >
				<tr>
					<th><?php _e('Short Codes','memphis-documents-library');?></th>
					<th><?php _e('Description','memphis-documents-library');?></th>
				</tr>
				<tr>
					<td>[mdocs]</td>
					<td><?php _e('Adds the default Memphis Documents Library file list to any page, post or widget.','memphis-documents-library');?></td>
				</tr>
				<tr>
					<td>[mdocs cat="<?php _e('The Category Name','memphis-documents-library');?>"]</td>
					<td><?php _e('Adds files from  a specific folder of the Memphis Documents Library on any page, post or widget.','memphis-documents-library');?></td>
				</tr>
				<tr>
					<td>[mdocs cat="All Files"]</td>
					<td><?php _e('Adds a list of all files of the Memphis Documents Library on any page, post or widget.','memphis-documents-library');?></td>
				</tr>
				<tr>
					<td>[mdocs single-file="<?php _e('Enter the file name.','memphis-documents-library'); ?>"]</td>
					<td><?php _e('Adds a single file to any post, page or widget.','memphis-documents-library');?></td>
				</tr>
				<tr>
					<td>[mdocs header="<?php _e('This text will show up above the documents list.','memphis-documents-library'); ?>"]</td>
					<td><?php _e('Adds a header to the Memphis Documents LIbrary on ay page, post or widget.','memphis-documents-library');?></td>
				</tr>
			</table>
		</div>
	</div>
	<?php
}
?>