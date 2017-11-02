<?php
function mdocs_get_inline_css() {
	$num_show = 0;
	$show_array = get_option('mdocs-displayed-file-info');
	$sa =  mdocs_get_table_atts();
	if($sa['show-downloads']['show']) $num_show++;
	if($sa['show-author']['show']) $num_show++;
	if($sa['show-version']['show']) $num_show++;
	if($sa['show-ratings']['show']) $num_show++;
	if($sa['show-update']['show']) $num_show++;
	if($sa['show-ratings']['show']) $num_show++;
	$mdocs_font_size = get_option('mdocs-font-size');
	if($num_show>=5) $title_width = '35%';
	if($num_show==4) $title_width = '45%';
	if($num_show==3) $title_width = '55%';
	if($num_show==2) $title_width = '65%';
	if($num_show==1) $title_width = '75%';
	if($num_show==0) $title_width = '100%';
	$download_button_color = get_option('mdocs-download-text-color-normal');
	$download_button_bg = get_option('mdocs-download-color-normal'); 
	$download_button_hover_color = get_option('mdocs-download-text-color-hover');
	$download_button_hover_bg = get_option('mdocs-download-color-hover');
	$navbar_bg_color = get_option('mdocs-navbar-bgcolor');
	$navbar_border_color = get_option('mdocs-navbar-bordercolor');
	$navbar_text_color_normal = get_option('mdocs-navbar-text-color-normal');
	$navbar_text_color_hover = get_option('mdocs-navbar-text-color-hover');
	if(get_option('mdocs-override-post-title-font-size') == true) $mdocs_post_title_font_size = 'font-size: '.get_option('mdocs-post-title-font-size').'px;';
	else $mdocs_post_title_font_size = '';
	if(get_option('mdocs-post-show-title') == false) $mdocs_post_show_title = 'display: none;';
	else $mdocs_post_show_title = '';
	if(get_option('mdocs-hide-entry-div') == true) $mdocs_hide_entry_div = 'display: none !important;';
	else $mdocs_hide_entry_div = '';
	$set_inline_style = "
		/*body { background: inherit; } CAN'T REMEMBER WHY I PUT THIS IN?*/
		dd, li { margin: 0; }
		.mdocs-list-table #title { width: $title_width !important }
		.mdocs-download-btn-config:hover { background: $download_button_hover_bg; color: $download_button_hover_color; }
		.mdocs-download-btn-config { color: $download_button_color; background: $download_button_bg ; }
		.mdocs-download-btn, .mdocs-download-btn:active { color: $download_button_color !important; background: $download_button_bg !important;  }
		.mdocs-download-btn:hover { background: $download_button_hover_bg !important; color: $download_button_hover_color !important;}
		.mdocs-container table, .mdocs-show-container, .mdocs-versions-body, .mdocs-container table #desc p { font-size: ".$mdocs_font_size."px !important; }
		.mdocs-navbar-default { background-color: $navbar_bg_color; border: solid $navbar_border_color 1px; }
		.mdocs-navbar-default .navbar-nav > li > a, .mdocs-navbar-default .navbar-brand { color: $navbar_text_color_normal; }
		.mdocs-navbar-default .navbar-nav > li > a:hover,
		.mdocs-navbar-default .navbar-brand:hover,
		.mdocs-navbar-default .navbar-nav > li > a:focus { color: $navbar_text_color_hover; }
		.mdocs-tooltip { list-style: none; }
		#mdocs-post-title { $mdocs_post_title_font_size $mdocs_post_show_title}
		.entry-summary { $mdocs_hide_entry_div }
	";
	//	TWENTY SIXTEEN FIX
	if(wp_get_theme() == "Twenty Sixteen") $set_inline_style .= "html { font-size: inherit !important; }";
	return $set_inline_style;
}
?>