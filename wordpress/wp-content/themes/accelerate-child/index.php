<?php
/**
 * Theme Index Section for our theme.
 *
 * @package ThemeGrill
 * @subpackage Accelerate
 * @since Accelerate 1.0
 */
get_header(); ?>

	<?php do_action( 'accelerate_before_body_content' ); ?>

	<div id="primary">
		<div id="content" class="clearfix">
			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', get_post_format() );

					$register_icon = get_field("register_icon");
					$register = get_field("register");
					$services_icon = get_field("services_icon");
					$services = get_field("services");
					$my_account_icon = get_field("my_account_icon");
					$my_account = get_field("my_account");
					$size = "medium";
					?>
				<?php endwhile; ?>

				<?php get_template_part( 'navigation', 'none' ); ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'none' ); ?>

			<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->


			<section class="homepage">
				<div class="page-content">
						<div class = "register-icon">
								<?php echo wp_get_attachment_image($register_icon, $size); ?>
						</div>
						<div class = "register-content"><h5><?php echo $register; ?></h5></div>

						<div class = "services-icon">
								<?php echo wp_get_attachment_image($register_icon, $size); ?>
						</div>
						<div class = "services-content"><h5><?php echo $services; ?></h5></div>

						<div class = "my-account-icon">
								<?php echo wp_get_attachment_image($my_account_icon, $size); ?>
						</div>

						<div class = "my-account-content"><h5><?php echo $my_account; ?></h5></div>


	<?php accelerate_sidebar_select(); ?>

	<?php do_action( 'accelerate_after_body_content' ); ?>

<?php get_footer(); ?>
