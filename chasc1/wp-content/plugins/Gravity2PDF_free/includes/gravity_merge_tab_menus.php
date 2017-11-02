<h1><?php _e( 'Gravity 2 PDF', 'gravity-merge' ) ?></h1>
<br />
<h2 class="nav-tab-wrapper">

	<?php if ( current_user_can('gravity2pdf_manage') ) { ?>
    	<a href="<?= admin_url( 'admin.php?page=gravitymerge' ); ?>" class="nav-tab <?= $_GET['page'] == 'gravitymerge' ? 'nav-tab-active' : '' ?>"><?php _e( 'Merges', 'gravity-merge' ) ?></a>
    <?php } ?>

	<?php if ( current_user_can('gravity2pdf_status') ) { ?>
    	<a href="<?= admin_url( 'admin.php?page=gravitymergestatus' ); ?>" class="nav-tab <?= $_GET['page'] == 'gravitymergestatus' ? 'nav-tab-active' : '' ?>"><?php _e( 'System Check', 'gravity-merge' ) ?></a>
    <?php } ?>

    <?php if ( current_user_can('gravity2pdf_manage_settings') ) { ?>
    	<a href="<?= admin_url( 'admin.php?page=gravitymergesettings' ); ?>" class="nav-tab <?= $_GET['page'] == 'gravitymergesettings' ? 'nav-tab-active' : '' ?>"><?php _e( 'Settings', 'gravity-merge' ) ?></a>
    <?php } ?>
</h2>
<div id="area-loading" style="display:none">
	<img src="<?=  GM_URL . '/assets/images/loading.gif' ?>" width="40">
</div>