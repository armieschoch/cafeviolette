<?php
/**
 * The template for displaying Search Result page
 *
 * @package WordPress
 * @subpackage Skillcrush_Starter
 * @since Skillcrush Starter 2.0
 */
 /*
 Template Name: Search Page
 */

get_header(); ?>

<div class="wrap">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<?php get_search_form(); ?>
		<h1 class="page-title"><?php printf( __( 'Search Results for <span>%s</span>', 'skillcrushstarter' ), single_cat_title( '', false ) ); ?></h1>
</div>
</div>

<section class="category-page">
	<div class="main-content">
		<?php get_search_form(); ?>
	</div>

	<?php get_sidebar(); ?>
</section>

<div id="navigation" class="container">
	<div class="left"><?php next_posts_link('&larr; <span>Older Posts</span>'); ?></div>
	<div class="pagination">
		<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			echo 'Page '.$paged.' of '.$wp_query->max_num_pages;
		?>
	</div>
	<div class="right"><?php previous_posts_link('<span>Newer Posts</span> &rarr;'); ?></div>
</div>

<?php get_footer(); ?>
