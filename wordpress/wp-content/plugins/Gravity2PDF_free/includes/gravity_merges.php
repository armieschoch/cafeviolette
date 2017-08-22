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
		?>
		<h2>Gravity Merge Items</h2>
		<a href="<?= admin_url( 'admin.php?page=gravitymerge&action=new' ) ?>" class="button button-default">Add New</a>
		<form method="post">
		<input type="hidden" name="course_id" value="<?= $_GET['courses'] ?>" />
			<?php
				$this->merge_obj->prepare_items();
				$this->merge_obj->display(); 
			?>
		</form>
		<?php
		endif;
		?>
	</div>
</div>