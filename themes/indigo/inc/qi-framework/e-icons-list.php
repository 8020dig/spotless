<?php 

// Function that defines available icons for Elegant Icons and its values
function quadro_icons_font_def() {

	$icons_list = array(

		'all-icons' => array(
			'section-name' => 'All Icons',
			'icon-classes' => array( 'fa fa-arrow_up', 'fa fa-arrow_down', 'fa fa-arrow_left', 'fa fa-arrow_right', 'fa fa-arrow_left-up', 'fa fa-arrow_right-up', 'fa fa-arrow_right-down', 'fa fa-arrow_left-down', 'fa fa-arrow-up-down', 'fa fa-arrow_up-down_alt', 'fa fa-arrow_left-right_alt', 'fa fa-arrow_left-right', 'fa fa-arrow_expand_alt2', 'fa fa-arrow_expand_alt', 'fa fa-arrow_condense', 'fa fa-arrow_expand', 'fa fa-arrow_move', 'fa fa-angle-up', 'fa fa-angle-down', 'fa fa-angle-left', 'fa fa-angle-right', 'fa fa-angle-2up', 'fa fa-angle-2down', 'fa fa-angle-2left', 'fa fa-angle-2right', 'fa fa-angle-up_alt2', 'fa fa-angle-down_alt2', 'fa fa-angle-left_alt2', 'fa fa-angle-right_alt2', 'fa fa-angle-2up_alt2', 'fa fa-angle-2down_alt2', 'fa fa-angle-2left_alt2', 'fa fa-angle-2right_alt2', 'fa fa-arrow_triangle-up', 'fa fa-arrow_triangle-down', 'fa fa-arrow_triangle-left', 'fa fa-arrow_triangle-right', 'fa fa-arrow_triangle-up_alt2', 'fa fa-arrow_triangle-down_alt2', 'fa fa-arrow_triangle-left_alt2', 'fa fa-arrow_triangle-right_alt2', 'fa fa-arrow_back', 'fa fa-icon_minus-06', 'fa fa-icon_plus', 'fa fa-icon_close', 'fa fa-icon_check', 'fa fa-icon_minus_alt2', 'fa fa-icon_plus_alt2', 'fa fa-icon_close_alt2', 'fa fa-icon_check_alt2', 'fa fa-icon_zoom-out_alt', 'fa fa-icon_zoom-in_alt', 'fa fa-search', 'fa fa-icon_box-empty', 'fa fa-icon_box-selected', 'fa fa-icon_minus-box', 'fa fa-icon_plus-box', 'fa fa-icon_box-checked', 'fa fa-icon_circle-empty', 'fa fa-icon_circle-slelected', 'fa fa-icon_stop_alt2', 'fa fa-icon_stop', 'fa fa-icon_pause_alt2', 'fa fa-icon_pause', 'fa fa-icon_menu', 'fa fa-icon_menu-square_alt2', 'fa fa-icon_menu-circle_alt2', 'fa fa-icon_ul', 'fa fa-icon_ol', 'fa fa-icon_adjust-horiz', 'fa fa-icon_adjust-vert', 'fa fa-icon_document_alt', 'fa fa-icon_documents_alt', 'fa fa-pencil', 'fa fa-pencil-edit_alt', 'fa fa-pencil-edit', 'fa fa-icon_folder-alt', 'fa fa-icon_folder-open_alt', 'fa fa-icon_folder-add_alt', 'fa fa-icon_info_alt', 'fa fa-icon_error-oct_alt', 'fa fa-icon_error-circle_alt', 'fa fa-icon_error-triangle_alt', 'fa fa-icon_question_alt2', 'fa fa-icon_question', 'fa fa-icon_comment_alt', 'fa fa-icon_chat_alt', 'fa fa-icon_vol-mute_alt', 'fa fa-icon_volume-low_alt', 'fa fa-icon_volume-high_alt', 'fa fa-icon_quotations', 'fa fa-icon_quotations_alt2', 'fa fa-icon_clock_alt', 'fa fa-icon_lock_alt', 'fa fa-icon_lock-open_alt', 'fa fa-sign-out', 'fa fa-icon_cloud_alt', 'fa fa-icon_cloud-upload_alt', 'fa fa-icon_cloud-download_alt', 'fa fa-icon_image', 'fa fa-icon_images', 'fa fa-icon_lightbulb_alt', 'fa fa-icon_gift_alt', 'fa fa-icon_house_alt', 'fa fa-icon_genius', 'fa fa-icon_mobile', 'fa fa-icon_tablet', 'fa fa-icon_laptop', 'fa fa-icon_desktop', 'fa fa-icon_camera_alt', 'fa fa-envelope_alt', 'fa fa-icon_cone_alt', 'fa fa-icon_ribbon_alt', 'fa fa-shopping-bag', 'fa fa-icon_creditcard', 'fa fa-icon_cart_alt', 'fa fa-icon_paperclip', 'fa fa-icon_tag_alt', 'fa fa-icon_tags_alt', 'fa fa-icon_trash_alt', 'fa fa-icon_cursor_alt', 'fa fa-icon_mic_alt', 'fa fa-icon_compass_alt', 'fa fa-icon_pin_alt', 'fa fa-icon_pushpin_alt', 'fa fa-icon_map_alt', 'fa fa-icon_drawer_alt', 'fa fa-icon_toolbox_alt', 'fa fa-icon_book_alt', 'fa fa-icon_calendar', 'fa fa-icon_film', 'fa fa-icon_table', 'fa fa-icon_contacts_alt', 'fa fa-icon_headphones', 'fa fa-icon_lifesaver', 'fa fa-icon_piechart', 'fa fa-icon_refresh', 'fa fa-link_alt', 'fa fa-link', 'fa fa-spinner', 'fa fa-icon_blocked', 'fa fa-icon_archive_alt', 'fa fa-icon_heart_alt', 'fa fa-icon_star_alt', 'fa fa-icon_star-half_alt', 'fa fa-icon_star', 'fa fa-icon_star-half', 'fa fa-icon_tools', 'fa fa-icon_tool', 'fa fa-icon_cog', 'fa fa-icon_cogs', 'fa fa-arrow_up_alt', 'fa fa-arrow_down_alt', 'fa fa-arrow_left_alt', 'fa fa-arrow_right_alt', 'fa fa-arrow_left-up_alt', 'fa fa-arrow_right-up_alt', 'fa fa-arrow_right-down_alt', 'fa fa-arrow_left-down_alt', 'fa fa-arrow_condense_alt', 'fa fa-arrow_expand_alt3', 'fa fa-angle_up_alt', 'fa fa-angle-down_alt', 'fa fa-angle-left_alt', 'fa fa-angle-right_alt', 'fa fa-angle-2up_alt', 'fa fa-angle-2dwnn_alt', 'fa fa-angle-2left_alt', 'fa fa-angle-2right_alt', 'fa fa-arrow_triangle-up_alt', 'fa fa-arrow_triangle-down_alt', 'fa fa-arrow_triangle-left_alt', 'fa fa-arrow_triangle-right_alt', 'fa fa-icon_minus_alt', 'fa fa-icon_plus_alt', 'fa fa-icon_close_alt', 'fa fa-icon_check_alt', 'fa fa-icon_zoom-out', 'fa fa-icon_zoom-in', 'fa fa-icon_stop_alt', 'fa fa-icon_menu-square_alt', 'fa fa-icon_menu-circle_alt', 'fa fa-icon_document', 'fa fa-icon_documents', 'fa fa-pencil_alt', 'fa fa-icon_folder', 'fa fa-icon_folder-open', 'fa fa-icon_folder-add', 'fa fa-icon_folder_upload', 'fa fa-icon_folder_download', 'fa fa-icon_info', 'fa fa-icon_error-circle', 'fa fa-icon_error-oct', 'fa fa-icon_error-triangle', 'fa fa-icon_question_alt', 'fa fa-icon_comment', 'fa fa-icon_chat', 'fa fa-icon_vol-mute', 'fa fa-icon_volume-low', 'fa fa-icon_volume-high', 'fa fa-icon_quotations_alt', 'fa fa-icon_clock', 'fa fa-icon_lock', 'fa fa-icon_lock-open', 'fa fa-icon_key', 'fa fa-icon_cloud', 'fa fa-icon_cloud-upload', 'fa fa-icon_cloud-download', 'fa fa-icon_lightbulb', 'fa fa-icon_gift', 'fa fa-icon_house', 'fa fa-icon_camera', 'fa fa-envelope', 'fa fa-icon_cone', 'fa fa-icon_ribbon', 'fa fa-shopping-bag_alt', 'fa fa-icon_cart', 'fa fa-icon_tag', 'fa fa-icon_tags', 'fa fa-icon_trash', 'fa fa-icon_cursor', 'fa fa-icon_mic', 'fa fa-icon_compass', 'fa fa-icon_pin', 'fa fa-icon_pushpin', 'fa fa-icon_map', 'fa fa-icon_drawer', 'fa fa-icon_toolbox', 'fa fa-icon_book', 'fa fa-icon_contacts', 'fa fa-icon_archive', 'fa fa-icon_heart', 'fa fa-user', 'fa fa-icon_group', 'fa fa-icon_grid-2x2', 'fa fa-icon_grid-3x3', 'fa fa-icon_music', 'fa fa-icon_pause_alt', 'fa fa-icon_phone', 'fa fa-icon_upload', 'fa fa-icon_download', 'fa fa-facebook', 'fa fa-twitter', 'fa fa-pinterest', 'fa fa-google-plus', 'fa fa-tumblr', 'fa fa-tumbleupon', 'fa fa-wordpress', 'fa fa-instagram', 'fa fa-dribbble', 'fa fa-vimeo', 'fa fa-linkedin', 'fa fa-rss', 'fa fa-deviantart', 'fa fa-share', 'fa fa-myspace', 'fa fa-skype', 'fa fa-youtube', 'fa fa-picassa', 'fa fa-googledrive', 'fa fa-flickr', 'fa fa-blogger', 'fa fa-spotify', 'fa fa-delicious', 'fa fa-facebook_circle', 'fa fa-twitter_circle', 'fa fa-pinterest_circle', 'fa fa-googleplus_circle', 'fa fa-tumblr_circle', 'fa fa-stumbleupon_circle', 'fa fa-wordpress_circle', 'fa fa-instagram_circle', 'fa fa-dribbble_circle', 'fa fa-vimeo_circle', 'fa fa-linkedin_circle', 'fa fa-rss_circle', 'fa fa-deviantart_circle', 'fa fa-share_circle', 'fa fa-myspace_circle', 'fa fa-skype_circle', 'fa fa-youtube_circle', 'fa fa-picassa_circle', 'fa fa-googledrive_alt2', 'fa fa-flickr_circle', 'fa fa-blogger_circle', 'fa fa-spotify_circle', 'fa fa-delicious_circle', 'fa fa-facebook_square', 'fa fa-twitter_square', 'fa fa-pinterest_square', 'fa fa-googleplus_square', 'fa fa-tumblr_square', 'fa fa-stumbleupon_square', 'fa fa-wordpress_square', 'fa fa-instagram_square', 'fa fa-dribbble_square', 'fa fa-vimeo_square', 'fa fa-linkedin_square', 'fa fa-rss_square', 'fa fa-deviantart_square', 'fa fa-share_square', 'fa fa-myspace_square', 'fa fa-skype_square', 'fa fa-youtube_square', 'fa fa-picassa_square', 'fa fa-googledrive_square', 'fa fa-flickr_square', 'fa fa-blogger_square', 'fa fa-spotify_square', 'fa fa-delicious_square', 'fa fa-icon_printer', 'fa fa-icon_calulator', 'fa fa-icon_building', 'fa fa-icon_floppy', 'fa fa-icon_drive', 'fa fa-search-2', 'fa fa-icon_id', 'fa fa-icon_id-2', 'fa fa-icon_puzzle', 'fa fa-icon_like', 'fa fa-icon_dislike', 'fa fa-icon_mug', 'fa fa-icon_currency', 'fa fa-icon_wallet', 'fa fa-icon_pens', 'fa fa-icon_easel', 'fa fa-icon_flowchart', 'fa fa-icon_datareport', 'fa fa-icon_briefcase', 'fa fa-icon_shield', 'fa fa-icon_percent', 'fa fa-icon_globe', 'fa fa-icon_globe-2', 'fa fa-icon_target', 'fa fa-icon_hourglass', 'fa fa-icon_balance', 'fa fa-icon_rook', 'fa fa-icon_printer-alt', 'fa fa-icon_calculator_alt', 'fa fa-icon_building_alt', 'fa fa-icon_floppy_alt', 'fa fa-icon_drive_alt', 'fa fa-search_alt', 'fa fa-icon_id_alt', 'fa fa-icon_id-2_alt', 'fa fa-icon_puzzle_alt', 'fa fa-icon_like_alt', 'fa fa-icon_dislike_alt', 'fa fa-icon_mug_alt', 'fa fa-icon_currency_alt', 'fa fa-icon_wallet_alt', 'fa fa-icon_pens_alt', 'fa fa-icon_easel_alt', 'fa fa-icon_flowchart_alt', 'fa fa-icon_datareport_alt', 'fa fa-icon_briefcase_alt', 'fa fa-icon_shield_alt', 'fa fa-icon_percent_alt', 'fa fa-icon_globe_alt', 'fa fa-icon_clipboard' )
		),

	);

	return $icons_list;

}

?>