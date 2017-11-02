<?php
function mdocs_load_modals() {
	load_preview_modal();
	load_ratings_modal();
	load_add_update_modal();
	load_share_modal();
	load_description_modal();
	load_versions_modal();
	load_batch_edit_modal();
	load_batch_move_modal();
	load_batch_delete_modal();
}
function load_add_update_modal() {
	?>
	<div class="modal fade mdocs-modal" id="mdocs-add-update" tabindex="-1" role="dialog" aria-labelledby="mdocs-add-update" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php _e('Close','memphis-documents-library'); ?></span></button>
					<div class="mdocs-add-update-body">
						<?php mdocs_uploader(); ?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','memphis-documents-library'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<?php
}
function load_description_modal() {
	?>
	<div class="modal fade mdocs-modal" id="mdocs-description-preview" tabindex="-1" role="dialog" aria-labelledby="mdocs-description-preview" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php _e('Close','memphis-documents-library'); ?></span></button>
					<div class="mdocs-description-preview-body mdocs-modal-body mdocs-post"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','memphis-documents-library'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<?php
}
function load_preview_modal() {
	?>
	<div class="modal fade mdocs-modal" id="mdocs-file-preview" tabindex="-1" role="dialog" aria-labelledby="mdocs-file-preview" aria-hidden="true" >
		<div class="modal-dialog modal-lg" style="height: 100% !important;">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php _e('Close','memphis-documents-library'); ?></span></button>
					<div class="mdocs-file-preview-body mdocs-modal-body"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','memphis-documents-library'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<?php
}

function load_ratings_modal() {
	?>
	<div class="modal fade mdocs-modal" id="mdocs-rating" tabindex="-1" role="dialog" aria-labelledby="mdocs-ratings" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php _e('Close','memphis-documents-library'); ?></span></button>
					<div class="mdocs-ratings-body mdocs-modal-body"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','memphis-documents-library'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<?php
}
function load_share_modal() {
	?>
	<div class="modal fade mdocs-modal" id="mdocs-share" tabindex="-1" role="dialog" aria-labelledby="mdocs-share" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php _e('Close','memphis-documents-library'); ?></span></button>
					<div class="mdocs-share-body mdocs-modal-body"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','memphis-documents-library'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<?php
}
function load_batch_edit_modal() {
	?>
	<div class="modal fade mdocs-modal" id="mdocs-batch-edit" tabindex="-1" role="dialog" aria-labelledby="mdocs-batch-edit" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php _e('Close','memphis-documents-library'); ?></span></button>
					<div class="mdocs-batch-edit-body  mdocs-batch-body mdocs-modal-body"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" onclick="mdocs_batch_edit_save();"><?php _e('Save', 'memphis-documents-library'); ?></button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','memphis-documents-library'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<?php
}
function load_batch_move_modal() {
	?>
	<div class="modal fade mdocs-modal" id="mdocs-batch-move" tabindex="-1" role="dialog" aria-labelledby="mdocs-batch-move" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php _e('Close','memphis-documents-library'); ?></span></button>
					<div class="mdocs-batch-move-body mdocs-batch-body mdocs-modal-body"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" onclick="mdocs_batch_move_save();"><?php _e('Move', 'memphis-documents-library'); ?></button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','memphis-documents-library'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<?php
}
function load_batch_delete_modal() {
	?>
	<div class="modal fade mdocs-modal" id="mdocs-batch-delete" tabindex="-1" role="dialog" aria-labelledby="mdocs-batch-delete" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php _e('Close','memphis-documents-library'); ?></span></button>
					<div class="mdocs-batch-delete-body mdocs-batch-body mdocs-modal-body"></div>
					<div id="mdocs-batch-delete-test"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" onclick="mdocs_batch_delete_save();"><?php _e('Delete', 'memphis-documents-library'); ?></button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','memphis-documents-library'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<?php
}
function load_versions_modal() {
	?>
	<div class="modal fade mdocs-modal" id="mdocs-versions" tabindex="-1" role="dialog" aria-labelledby="mdocs-versions" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php _e('Close','memphis-documents-library'); ?></span></button>
					<div class="mdocs-versions-body mdocs-modal-body"></div>
					<div id="mdocs-versions-test"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','memphis-documents-library'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>