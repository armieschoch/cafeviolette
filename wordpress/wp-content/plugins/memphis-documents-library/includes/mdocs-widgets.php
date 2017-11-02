<?php
function mdocs_widgets() {
	register_widget( 'mdocs_top_downloads' );
	register_widget( 'mdocs_top_rated' );
	register_widget( 'mdocs_last_updated' );
}
class mdocs_last_updated extends WP_Widget {
	function __construct() {
		// Instantiate the parent object
		parent::__construct( 'mdocs_last_updated', 'Memphis Last Updated' );
	}
	function widget( $args, $instance ) {
		$mdocs = get_option('mdocs-list');
		$the_list  = mdocs_array_sort($mdocs,'modified', SORT_DESC, true);
		?>
		<div id="widget-last-updated" class="widget" role="complementary">
			<aside class="widget widget_pages">
				<?php
				if(get_option('mdocs-hide-widget-titles') == false) { ?> <h2 class="widget-title"><?php _e('Last Updated', 'memphis-documents-library'); ?></h2> <?php } ?>
				<div class="textwidget">
					<table class="table table-condensed">
						<tr>
							<th></th>
							<th>File</th>
							<th>Date</th>
						</tr>
					<?php
					for($i=0; $i< get_option('mdocs-last-updated');$i++) {
						if(!isset($the_list[$i])) break;
						$permalink = mdocs_get_permalink($the_list[$i]['parent']);
						echo '<tr>';
						echo '<td>'.($i+1).'.</td>';
						echo '<td><a href="'.$permalink.'null" >'.$the_list[$i]['name'].'</a></td>';
						echo '<td class="mdocs-widget-date"><small>'.date(get_option('mdocs-date-format'), $the_list[$i]['modified']).'</small></td>';
						echo '</tr>';
					}
					?>
					</table>
				</div>
			</aside>
		</div>
		<?php
	}
	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( $new_instance['title'] );
		update_option('mdocs-last-updated',$_POST['mdocs-last-updated']);
		return $instance;
	}
	function form( $instance ) {
		?>
		<p>
			<input type="text" name="mdocs-last-updated" value="<?php echo get_option('mdocs-last-updated'); ?>" />
		</p>
		<?php
	}
}
class mdocs_top_rated extends WP_Widget {
	function __construct() {
		// Instantiate the parent object
		parent::__construct( 'mdocs_top_rated', 'Memphis Top Rated' );
	}
	function widget( $args, $instance ) {
		$mdocs = get_option('mdocs-list');
		$the_list  = mdocs_array_sort($mdocs,'rating', SORT_DESC, true);
		?>
		<div id="widget-top-rated" class="widget" role="complementary">
			<aside class="widget widget_pages">
				<?php if(get_option('mdocs-hide-widget-titles') == false) { ?> <h2 class="widget-title"><?php _e('Top Rated', 'memphis-documents-library'); ?></h2> <?php } ?>
				<div class="textwidget">
					<table class="table table-condensed">
						<tr>
							<th></th>
							<th>File</th>
							<th>Rating</th>
						</tr>
					<?php
					for($i=0; $i< get_option('mdocs-top-rated');$i++) {
						if(!isset($the_list[$i])) break;
						$permalink = mdocs_get_permalink($the_list[$i]['parent']);
						echo '<tr>';
						echo '<td>'.($i+1).'.</td>';
						echo '<td><a href="'.$permalink.'null" >'.$the_list[$i]['name'].'</a></td>';
						echo '<td class="mdocs-widget-rating"><small>';
						for($j=1;$j<=5;$j++) {
							if($the_list[$i]['rating'] >= $j) echo '<i class="fa fa-star mdocs-gold" id="'.$j.'"></i>';
							elseif(ceil($the_list[$i]['rating']) == $j ) echo '<i class="fa fa-star-half-full mdocs-gold" id="'.$j.'"></i>';
							else echo '<i class="fa fa-star-o" id="'.$j.'"></i>';
						}
						echo '</small></td>';
						echo '</tr>';
					}
					?>
					</table>
				</div>
			</aside>
		</div>
		<?php
	}
	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( $new_instance['title'] );
		update_option('mdocs-top-rated',$_POST['mdocs-top-rated']);
		return $instance;
	}
	function form( $instance ) {
		?>
		<p>
			<input type="text" name="mdocs-top-rated" value="<?php echo get_option('mdocs-top-rated'); ?>" />
		</p>
		<?php
	}
}
class mdocs_top_downloads extends WP_Widget {
	function __construct() {
		// Instantiate the parent object
		parent::__construct( 'mdocs_top_downloads', 'Memphis Top Downloads' );
	}
	function widget( $args, $instance ) {
		$mdocs = get_option('mdocs-list');
		$the_list  = mdocs_array_sort($mdocs,'downloads', SORT_DESC, true);
		?>
		<div id="widget-top-downloads" class="widget" role="complementary">
			<aside class="widget widget_pages">
				<?php if(get_option('mdocs-hide-widget-titles') == false) { ?> <h2 class="widget-title"><?php _e('Top Downloads', 'memphis-documents-library'); ?></h2> <?php } ?>
				<div class="textwidget">
					<table class="table table-condensed">
						<tr>
							<th></th>
							<th>File</th>
							<th>DLs</th>
						</tr>
					<?php
					for($i=0; $i< get_option('mdocs-top-downloads');$i++) {
						if(!isset($the_list[$i])) break;
						$permalink = mdocs_get_permalink( $the_list[$i]['parent']);
						
						echo '<tr>';
						echo '<td>'.($i+1).'.</td>';
						echo '<td><a href="'.$permalink.'null" >'.$the_list[$i]['name'].'</a></td>';
						echo '<td class="text-center">'.$the_list[$i]['downloads'].'</td>';
						echo '</tr>';
					}
					?>
					</table>
				</div>
			</aside>
		</div>
		<?php
	}
	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( $new_instance['title'] );
		update_option('mdocs-top-downloads',$_POST['mdocs-top-downloads']);
		return $instance;
	}
	function form( $instance ) {
		?>
		<p>
			<input type="text" name="mdocs-top-downloads" value="<?php echo get_option('mdocs-top-downloads'); ?>" />
		</p>
		<?php
	}
}
?>