<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package dazzling
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<nav class="navbar navbar-default" role="navigation">
		<div class="container">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
			    <span class="sr-only"><?php _e( 'Toggle navigation', 'dazzling' ); ?></span>
			    <span class="icon-bar"></span>
			    <span class="icon-bar"></span>
			    <span class="icon-bar"></span>
			  </button>

				<div id="logo">
					<?php echo is_home() ?  '<h1 class="site-title">' : '<span class="site-title">'; ?>
						<?php if( get_header_image() != '' ) : ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php header_image(); ?>"
								height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width;
								?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
						<?php endif; // header image was removed ?>
						<?php if( !get_header_image() ) : ?>
							<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"
								title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
								<?php bloginfo( 'name' ); ?></a>
						<?php endif; // header image was removed (again) ?>
					<?php echo is_home() ?  '</h1>' : '</span>'; ?><!-- end of .site-name -->

					<?php if( !get_header_image() ) : ?>
						<?php $description = get_bloginfo( 'description', 'display' );
						if ( $description || is_customize_preview() ) : ?>
							<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
						<?php
						endif; ?>
					<?php endif; ?>

					<form method="get" class="form-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<div class="form-group">
							<div class="input-group">
						  		<span class="screen-reader-text"><?php _ex( 'Search for:', 'label', 'dazzling' ); ?></span>
						    	<input type="text" class="form-control search-query" placeholder="<?php _e( 'Search...', 'dazzling' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
						    	<span class="input-group-btn">
						      		<button type="submit" class="btn btn-default" name="submit" id="searchsubmit" value="Search"><span class="glyphicon glyphicon-search"></span></button>
						    	</span>
						    </div>
						</div>
					</form>
				</div><!-- end of #logo -->


			</div>
				<?php dazzling_header_menu(); ?>
		</div>
	</nav><!-- .site-navigation -->

        <div class="top-section">
		<?php dazzling_featured_slider(); ?>
		<?php dazzling_call_for_action(); ?>
        </div>
        <div id="content" class="site-content container">

            <div class="container main-content-area"><?php

                global $post;
                if( get_post_meta($post->ID, 'site_layout', true) ){
                        $layout_class = get_post_meta($post->ID, 'site_layout', true);
                }
                else{
                        $layout_class = of_get_option( 'site_layout' );
                }
                if( is_home() && is_sticky( $post->ID ) ){
                        $layout_class = of_get_option( 'site_layout' );
                }
                ?>
                <div class="row <?php echo $layout_class; ?>">
