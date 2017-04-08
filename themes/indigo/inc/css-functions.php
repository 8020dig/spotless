<?php

/*-----------------------------------------------------------------------------------*/
/*	Apply Theme options to CSS
/*-----------------------------------------------------------------------------------*/

function quadro_gfonts_script( ) {
	
	// Retrieve Theme Options
	global $quadro_options, $headings_font, $body_font, $load_fonts;
	
	if ( $quadro_options['font_selection'] === 'typekit_fonts' ) {
		$kit = esc_attr( $quadro_options['typekit_kit_id'] );
	?>
	<script>
		(function(d) {
			var config = {
				kitId: '<?php echo $kit; ?>',
				scriptTimeout: 3000,
				async: true
			},
			h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='//use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
		})(document);
	</script>
	
	<?php 

	// Set Font Families
	$headings_font	= array( '', 'font-family: ' . wp_kses_post( $quadro_options['typekit_kit_headings_family'] ) . ';' );
	$body_font 		= array( '', 'font-family: ' . wp_kses_post( $quadro_options['typekit_kit_body_family'] ) . ';' );

	}
	else if ( $quadro_options['font_selection'] === 'google' ) {

		$headings_font = explode( "|", strip_tags( $quadro_options['headings_font'] ) );
		$body_font = explode( "|", strip_tags( $quadro_options['body_font'] ) );
		
		$load_fonts = '';

		if ( $headings_font[0] != 'none' && $quadro_options['custom_font_name'] == '' ) {
			$load_fonts .= "'" . $headings_font[0] . esc_attr( $quadro_options['headings_weight'] ) . esc_attr( $quadro_options['font_subset'] ) . "', ";
		}

		if ( $body_font !== $headings_font || $quadro_options['custom_font_name'] != '' ) {
			if ( $body_font[0] != 'none' ) {
				$load_fonts .= "'" . $body_font[0] . esc_attr( $quadro_options['body_weight'] ) . esc_attr( $quadro_options['font_subset'] ) . "', ";
			}
		}

		if ( $load_fonts != '' ) {
			wp_enqueue_script('googlefloader', '//ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js');
		}
	
	}

}
add_action( 'wp_enqueue_scripts', 'quadro_gfonts_script' );


function quadro_css_aply( ) {
	
	// Retrieve Theme Options and font families
	global $quadro_options, $headings_font, $body_font, $load_fonts;

	if ( $quadro_options['font_selection'] === 'google' && $load_fonts != '' ) { ?>
		<script>
			WebFont.load({
				google: {
					families: [<?php echo $load_fonts; ?>],
				},
				timeout: 3500 // Set the timeout
			});
		</script>
	<?php }

echo '<style>'; ?>

body {
	<?php 
	echo 'background-color: ' . esc_attr( $quadro_options['background_color'] ) . ';';
	if ( $quadro_options['background_img'] != '' ) {
		echo 'background-image: url(\'' . esc_url( $quadro_options['background_img'] ) . '\');';
		echo 'background-size: cover;';
	} else {
		if ( $quadro_options['background_pattern'] != 'none' ) {
			echo 'background-image: url(\'' . get_stylesheet_directory_uri() . '/images/patterns/' . esc_attr( $quadro_options['background_pattern'] ) . '.jpg\');';
			echo 'background-repeat: repeat;';
		}
	} ?>
	<?php echo $body_font[1]; ?>
	font-size: <?php echo esc_attr( $quadro_options['body_size'] ); ?>px;
}

@media only screen and (min-width: 960px) {
	.site-boxed:not(.header-layout7),
	.site-boxed:not(.header-layout17) {
		border-color: <?php echo esc_attr( $quadro_options['background_color'] ); ?> ;
	}
	.site-boxed:not(.header-layout7):before,
	.site-boxed:not(.header-layout17):before,
	.site-boxed:not(.header-layout7):after,
	.site-boxed:not(.header-layout17):after {
		background: <?php echo esc_attr( $quadro_options['background_color'] ); ?> ;
	}
}

.insight-content,
.sl-insight-text,
.wpcf7 {
	font-size: <?php echo esc_attr( $quadro_options['body_size'] ); ?>px;
}

<?php // Header Backgrounds & Colors
if ( $quadro_options['header_layout'] == 'header-layout7' ) {
	echo '	.site-header { background-color: ' . esc_attr( $quadro_options['side_header_back'] ) . '; }';
	echo '	.site-header,
			.site-header .site-title a,
			.site-header .site-title a:visited,
			.site-header .main-navigation .menu > ul > li > a,
			.site-header .main-navigation .menu > li > a,
			.site-header .header-extras > ul > li a,
			.site-header .header-extras > ul > li i,
			.site-header .header-extras .search-handler {
				color: ' . esc_attr( $quadro_options['side_header_color'] ) . ';
			}
		  	.menu-toggle-icon { background-color: ' . esc_attr( $quadro_options['side_header_color'] ) . '; }';
} elseif ( $quadro_options['header_transp'] == 'background' ) {
	echo '	.headroom--not-top .header-1st-row,
			.background-header .header-1st-row {
				background-color: ' . esc_attr( $quadro_options['1st_row_back'] ) . ';
			}';
	echo '	.headroom--not-top .header-1st-row,
			.background-header .header-1st-row,
			.headroom--not-top .header-1st-row .site-title a,
			.background-header .header-1st-row .site-title a,
			.headroom--not-top .header-1st-row .site-title a:visited,
			.background-header .header-1st-row .site-title a:visited,
			.headroom--not-top .header-1st-row .main-navigation .menu > ul > li > a,
			.background-header .header-1st-row .main-navigation .menu > ul > li > a,
			.headroom--not-top .header-1st-row .main-navigation .menu > li > a,
			.background-header .header-1st-row .main-navigation .menu > li > a,
			.headroom--not-top .header-1st-row .header-extras > ul > li,
			.background-header .header-1st-row .header-extras > ul > li,
			.headroom--not-top .header-1st-row .header-extras > ul > li a,
			.background-header .header-1st-row .header-extras > ul > li a,
			.headroom--not-top .header-1st-row .header-extras > ul > li i,
			.background-header .header-1st-row .header-extras > ul > li i,
			.headroom--not-top .header-1st-row .header-extras .search-handler,
			.background-header .header-1st-row .header-extras .search-handler,
			.headroom--not-top .header-1st-row .site-description,
			.background-header .header-1st-row .site-description {
				color: ' . esc_attr( $quadro_options['1st_row_color'] ) . ';
			}
			.headroom--not-top .header-1st-row .menu-toggle-icon,
			.background-header .header-1st-row .menu-toggle-icon {
				background-color: ' . esc_attr( $quadro_options['1st_row_color'] ) . ';
			}';
	echo '	.headroom--not-top .header-2nd-row,
			.background-header .header-2nd-row  {
				background-color: ' . esc_attr( $quadro_options['2nd_row_back'] ) . ';
			}';
	echo '	.headroom--not-top .header-2nd-row,
			.background-header .header-2nd-row,
			.headroom--not-top .header-2nd-row .site-title a,
			.background-header .header-2nd-row .site-title a,
			.headroom--not-top .header-2nd-row .site-title a:visited,
			.background-header .header-2nd-row .site-title a:visited,
			.headroom--not-top .header-2nd-row .main-navigation .menu > ul > li > a,
			.background-header .header-2nd-row .main-navigation .menu > ul > li > a,
			.headroom--not-top .header-2nd-row .main-navigation .menu > li > a,
			.background-header .header-2nd-row .main-navigation .menu > li > a,
			.headroom--not-top .header-2nd-row .header-extras > ul > li,
			.background-header .header-2nd-row .header-extras > ul > li,
			.headroom--not-top .header-2nd-row .header-extras > ul > li a,
			.background-header .header-2nd-row .header-extras > ul > li a,
			.headroom--not-top .header-2nd-row .header-extras > ul > li i,
			.background-header .header-2nd-row .header-extras > ul > li i,
			.headroom--not-top .header-2nd-row .header-extras .search-handler,
			.background-header .header-2nd-row .header-extras .search-handler,
			.headroom--not-top .header-2nd-row .site-description,
			.background-header .header-2nd-row .site-description  {
				color: ' . esc_attr( $quadro_options['2nd_row_color'] ) . ';
			}
			.headroom--not-top .header-2nd-row .menu-toggle-icon,
			.background-header .header-2nd-row .menu-toggle-icon {
				background-color: ' . esc_attr( $quadro_options['2nd_row_color'] ) . ';
			}';
} elseif ( $quadro_options['transp_header_color'] == 'custom' ) {
	echo '	.header-1st-row,
			.header-2nd-row,
			.header-1st-row .site-title a,
			.header-2nd-row .site-title a,
			.main-navigation .menu > ul > li > a,
			.main-navigation .menu > li > a,
			.header-extras > ul > li,
			.header-extras > ul > li a,
			.header-extras > ul > li i,
			.header-extras .search-handler,
			.site-description {
				color: ' . esc_attr( $quadro_options['transp_header_custom'] ) . ';
			}
			.menu-toggle-icon {
				background-color: ' . esc_attr( $quadro_options['transp_header_custom'] ) . ';
			}';
} ?>

.header-layout13 .headroom--not-top .header-2nd-row .site-title a,
.header-layout13.background-header .header-2nd-row .site-title a,
.header-layout15 .headroom--not-top .header-2nd-row .site-title a,
.header-layout15.background-header .header-2nd-row .site-title a {
	color: <?php echo esc_attr( $quadro_options['2nd_row_color'] ); ?>;
}

@media only screen and (max-width: 959px) {
	.background-header .site-header,
	.headroom--not-top.site-header {
		background-color: <?php echo esc_attr( $quadro_options['1st_row_back'] ); ?>;
	}

	.headroom--not-top .menu-toggle-icon,
	.background-header .menu-toggle-icon {
		background-color: <?php echo esc_attr( $quadro_options['1st_row_color'] ); ?> !important;
	}

	.header-layout4 .headroom--not-top.site-header,
	.header-layout4.background-header .site-header,
	.header-layout13 .headroom--not-top.site-header,
	.header-layout13.background-header .site-header,
	.header-layout15 .headroom--not-top.site-header,
	.header-layout15.background-header .site-header {
		background-color: <?php echo esc_attr( $quadro_options['2nd_row_back'] ); ?>;
	}

	.header-layout13 .headroom--not-top .header-2nd-row .site-title a,
	.header-layout13.background-header .header-2nd-row .site-title a,
	.header-layout13 .headroom--not-top .header-extras > ul > li,
	.header-layout13.background-header .header-extras > ul > li,
	.header-layout13 .headroom--not-top .header-extras > ul > li a,
	.header-layout13.background-header .header-extras > ul > li a,
	.header-layout13 .headroom--not-top .header-1st-row .site-description,
	.header-layout13.background-header .header-1st-row .site-description,
	.header-layout15 .headroom--not-top .header-2nd-row .site-title a,
	.header-layout15.background-header .header-2nd-row .site-title a,
	.header-layout15 .headroom--not-top .header-extras > ul > li,
	.header-layout15.background-header .header-extras > ul > li,
	.header-layout15 .headroom--not-top .header-extras > ul > li a,
	.header-layout15.background-header .header-extras > ul > li a {
		color: <?php echo esc_attr( $quadro_options['2nd_row_color'] ); ?>;
	}

	.header-layout4 .headroom--not-top .menu-toggle-icon,
	.header-layout4.background-header .menu-toggle-icon,
	.header-layout13 .headroom--not-top .menu-toggle-icon,
	.header-layout13.background-header .menu-toggle-icon,
	.header-layout15 .headroom--not-top .menu-toggle-icon,
	.header-layout15.background-header .menu-toggle-icon {
		background-color: <?php echo esc_attr( $quadro_options['2nd_row_color'] ); ?> !important;
	}

	.header-layout14 .headroom--not-top .header-extras > ul > li,
	.header-layout14.background-header .header-extras > ul > li,
	.header-layout14 .headroom--not-top .header-extras > ul > li a,
	.header-layout14.background-header .header-extras > ul > li a {
		color: <?php echo esc_attr( $quadro_options['1st_row_color'] ); ?>;
	}

	.header-layout7 .site-header {
		background-color: <?php echo esc_attr( $quadro_options['side_header_back'] ); ?>;
	}

	.header-layout7 .menu-toggle-icon {
		background-color: <?php echo esc_attr( $quadro_options['side_header_color'] ); ?> !important;
	}
}

.meta-nav strong,
.page-tagline {
	<?php echo $body_font[1]; ?>
}

.archive:not(.post-type-archive-product) .site-main, .search-results .site-main, .blog .site-main {
	background: <?php echo esc_attr( $quadro_options['archive_background'] ); ?>;
}

a, .single-post .entry-content a, .single-post .entry-content a:visited,
.page-content a, .page-content a:visited {
	color: <?php echo esc_attr( $quadro_options['links_color'] ); ?>;
}

a:hover,
a:visited,
.single-post .entry-content a:hover,
.page-content a:hover {
	color: <?php echo esc_attr( $quadro_options['hover_color'] ); ?>;
}

.main-navigation ul ul li:hover > a, .main-navigation ul ul li.current_page_item > a,
.main-navigation ul ul li.current-menu-item > a, .header-extras > ul > li:hover, .header-search .search-submit,
.transparent-header.light-header .headroom--not-top .header-extras > ul > li:hover, #widgt-header-handle.open-header,
.header-cart-link .header-cart-qy, .header-cart-link-mobile .header-cart-qy, .flex-direction-nav a, .flashnews-content .cat-links,
.magazine-item .cat-links, .crellyslider > .cs-controls > .cs-next, .crellyslider > .cs-controls > .cs-previous, .paging-navigation a,
.qbtn.slogan-call-to-action, a.cta-button, .slide-content-rmore, .display-content .readmore-link .read-more,
.member-socials a:hover i, .widget_search .search-submit, .filter-terms li.filter-active,
.header-extras .user-navigation ul.menu li a:hover, .mod-nav-tooltip, .mod-nav-tooltip:before, .qbtn.ibox-button {
	background-color: <?php echo esc_attr( $quadro_options['main_color'] ); ?>;
}

button, .button, a.button, .qbtn, a.qbtn, html input[type="button"], input[type="reset"], .back-to-top,
.comment-reply-link, .cancel-comment-reply-link, a.post-edit-link, a.insight-link,
.read-more, .widget_sow-features .sow-features-list .sow-features-feature p.sow-more-text a,
.mods-tabs-list li.current a, .mods-tabs-list li a:hover {
	color: <?php echo esc_attr( $quadro_options['main_color'] ); ?>;
}

	button:hover, .button:hover, a.button:hover, .qbtn:hover, a.qbtn:hover, html input[type="button"]:hover,
	input[type="reset"]:hover, input[type="submit"], .back-to-top, .main-navigation .menu > li.feat-menu-background > a,
	.comment-reply-link:hover, .cancel-comment-reply-link:hover, a.post-edit-link:hover, a.insight-link,
	.read-more:hover, .widget_sow-features .sow-features-list .sow-features-feature p.sow-more-text a,
	.footer-social-icons li a:hover i {
		background: <?php echo esc_attr( $quadro_options['main_color'] ); ?>;
		border-color: <?php echo esc_attr( $quadro_options['main_color'] ); ?>;
		color: #fff !important;
	}

.mm-menu .mm-listview > li.mm-selected > a:not(.mm-next),
.mm-menu .mm-listview > li.mm-selected > span {
	color: #fff !important;
	background: <?php echo esc_attr( $quadro_options['main_color'] ); ?> !important;
}

.mejs-controls .mejs-time-rail .mejs-time-current {
	background: <?php echo esc_attr( $quadro_options['main_color'] ); ?> !important;
}

.entry-content h1, .entry-content h2, .entry-content h3, .header-extras > ul li .cart-link a.cart-link-a,
.site-content .widget_nav_menu .current-menu-item a, .type-sl-insights .flex-control-nav a.flex-active {
	color: <?php echo esc_attr( $quadro_options['main_color'] ); ?> !important;
}

h1 a, h2 a, h3 a, h4 a, h5 a, h6 a, h1, h2, h3, h4, h5, h6,
.comment-author cite, .post-navigation .meta-nav,
.paging-navigation .meta-nav, .comment-navigation a, blockquote, q,
.taxonomy-description p, .wpcf7 p, .read-author-link a, .flashnews-content .entry-title,
div#jp-relatedposts h3.jp-relatedposts-headline, .mods-tabs-list li, .price-numb, .plan-highlight {
	<?php echo $headings_font[1]; ?>
}

.topper-header {
	background: <?php echo esc_attr( $quadro_options['widgt_header_background'] ); ?>;
}

.topper-header, .topper-header .widget a {
	color: <?php echo esc_attr( $quadro_options['widgt_header_color'] ); ?>;
}

<?php if ( class_exists( 'Woocommerce' ) ) { ?>
.woocommerce a.button, .woocommerce input.button, .woocommerce .star-rating {
	color: <?php echo esc_attr( $quadro_options['main_color'] ); ?> !important;
	border-color: <?php echo esc_attr( $quadro_options['main_color'] ); ?> !important; 
}

.woocommerce p.stars a {
	color: <?php echo esc_attr( $quadro_options['main_color'] ); ?> !important;
}

.woocommerce a.button:hover,
.woocommerce input.button:hover,
.woocommerce button.button,
.woocommerce #respond input#submit,
.cart-actions div a.qbtn,
.woocommerce #respond input#submit,
.woocommerce-page #respond input#submit:hover,
.woocommerce-page #content div.product form.cart .button,
.woocommerce ul.products li.product .button,
.woocommerce nav.woocommerce-pagination ul li span.current,
.woocommerce nav.woocommerce-pagination ul li a:hover,
.woocommerce nav.woocommerce-pagination ul li a:focus,
.woocommerce #content nav.woocommerce-pagination ul li span.current,
.woocommerce #content nav.woocommerce-pagination ul li a:hover,
.woocommerce #content nav.woocommerce-pagination ul li a:focus,
.woocommerce-page nav.woocommerce-pagination ul li span.current,
.woocommerce-page nav.woocommerce-pagination ul li a:hover,
.woocommerce-page nav.woocommerce-pagination ul li a:focus,
.woocommerce-page #content nav.woocommerce-pagination ul li span.current,
.woocommerce-page #content nav.woocommerce-pagination ul li a:hover,
.woocommerce-page #content nav.woocommerce-pagination ul li a:focus,
.woocommerce #respond input#submit.alt,
.woocommerce a.button.alt,
.woocommerce button.button.alt,
.woocommerce input.button.alt {
	background-color: <?php echo esc_attr( $quadro_options['main_color'] ); ?> !important;
	color: #fff !important;
	border-color: <?php echo esc_attr( $quadro_options['main_color'] ); ?> !important;
}

.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active a,
.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active a,
.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active a,
.woocommerce div.product .woocommerce-tabs ul.tabs li:hover a,
.woocommerce #content div.product .woocommerce-tabs ul.tabs li:hover a,
.woocommerce-page div.product .woocommerce-tabs ul.tabs li:hover a,
.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li:hover a {
	color: <?php echo esc_attr( $quadro_options['main_color'] ); ?> !important;
}
<?php } ?>

/* Site Title */
.site-title {
	<?php echo $headings_font[1]; ?>
	font-size: <?php echo esc_attr( $quadro_options['site_title_size'] ); ?>px;
}

.site-footer { background-color: <?php echo esc_attr( $quadro_options['footer_background'] ); ?>; }
.site-footer, .site-footer .widget select { color: <?php echo esc_attr( $quadro_options['footer_text_color'] ); ?> }
.site-footer a { color: <?php echo esc_attr( $quadro_options['footer_links_color'] ); ?> }

<?php // Colors for Social Icons Areas
if ( $quadro_options['header_icons_color_type'] == 'custom' ) {
		echo '	.headroom--not-top .header-social-icons li a i,
				.background-header .header-social-icons li a i,
				.header-layout7 .header-social-icons li a i { color: ' . esc_attr( $quadro_options['header_icons_color'] ) . ' !important; }';
}
if ( $quadro_options['footer_icons_color_type'] == 'custom' ) {
		echo '.footer-social-icons li a i { color: ' . esc_attr( $quadro_options['footer_icons_color'] ) . '; }';
} ?>

<?php // Custom Font Management
if ( $quadro_options['custom_font_name'] != '' ) {
	
	// Stam variable for comma adding
	$prev = false;

	// First, load the font
	echo '@font-face {';
	echo 'font-family: "' . esc_attr($quadro_options['custom_font_name']) . '";';
	if ( $quadro_options['custom_font_eot'] != '' ) echo 'src: url("' . esc_url($quadro_options['custom_font_eot']) . '");';
	echo 'src: ';
	if ( $quadro_options['custom_font_eot'] != '' ) { 
		$prev = true;
		echo 'url("' . esc_url($quadro_options['custom_font_eot']) . '?#iefix") format("embedded-opentype")';
	} if ( $quadro_options['custom_font_woff'] != '' ) { 
		if ( $prev == true ) echo ', '; $prev = true;
		echo 'url("' . esc_url($quadro_options['custom_font_woff']) . '") format("woff")';
	} if ( $quadro_options['custom_font_ttf'] != '' ) { 
		if ( $prev == true ) echo ', '; $prev = true;
		echo 'url("' . esc_url($quadro_options['custom_font_ttf']) . '") format("truetype")';
	} if ( $quadro_options['custom_font_svg'] != '' ) { 
		if ( $prev == true ) echo ', '; $prev = true;
		echo 'url("' . esc_url($quadro_options['custom_font_svg']) . '") format("svg")';
	} 
	echo '; font-weight: normal; font-style: normal; }';

	// Then, declare rules for it
	if ( $quadro_options['custom_font_use_logo'] == true && $quadro_options['logo_type'] == 'text' ) {
		echo '.site-title a { font-family: ' . esc_attr($quadro_options['custom_font_name']) . ', Helvetica, Arial, sans-serif;}';
	}
	if ( $quadro_options['custom_font_use_headings'] == true ) {
		echo 'h1 a, h2 a, h3 a, h4 a, h5 a, h6, h1, h2, h3, h4, h5, h6 { font-family: ' . esc_attr($quadro_options['custom_font_name']) . ', Helvetica, Arial, sans-serif;}';
	}

} ?>

<?php if ( $quadro_options['custom_css'] != '' ) {
	$css = preg_replace( "'<[^>]+>'U", "", $quadro_options['custom_css']);
	$css = str_replace( '&gt;', '>', $css ); // pre_replace replaces lone '>' with &gt;
	// Why both preg_replace and strip_tags?  Because we just added some '>'.
	$css = strip_tags( $css );
	echo $css;
} ?>

<?php echo '</style>'; ?>

<!--[if lt IE 10]>
<style>
@media only screen and (min-width: 760px) {
	.caption-type1 .slide-caption,
	.caption-type1.caption-right .slide-caption,
	.caption-type1.caption-alternated .quadro-slides li:nth-of-type(even) .slide-caption {
		min-width: 500px; 
		padding: 60px;
	}
}
</style>
<![endif]-->

<!--[if lt IE 9]>
	<?php $IEfontsPre = str_replace("'", "", $load_fonts); ?>
	<?php $IEfonts = str_replace(",", "|", $IEfontsPre); ?>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo esc_attr( $IEfonts ); ?>">
<![endif]-->
 
<?php } // end of function

add_action( 'wp_head', 'quadro_css_aply' );

?>