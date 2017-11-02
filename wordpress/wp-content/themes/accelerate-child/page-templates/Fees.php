<?php
/**
 * Template Name: Fees Template
 *
 * Displays the Fees Template of the theme.
 *
 * @package ThemeGrill
 * @subpackage Accelerate
 * @since Accelerate 1.0
 */
?>

<?php get_header(); ?>

<div id="content" class="clearfix">

	<?php
		if( is_active_sidebar( 'accelerate_fees_sidebar' ) ) {
			if ( !dynamic_sidebar( 'accelerate_fees_sidebar' ) ):
			endif;
		}
	?>

</div>

<?php get_footer(); ?>
