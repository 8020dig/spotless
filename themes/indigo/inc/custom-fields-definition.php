<?php

$prefix = 'quadro_';

/*-----------------------------------------------------------------------------------*/
/*	Meta Boxes & Options for Posts
/*-----------------------------------------------------------------------------------*/

// Define available modules
$qi_available_modules = array( 
	'Authors'						=> 'authors',
	'Blog' 							=> 'blog',
	'Call to Action' 				=> 'cta',
	'Canvas' 						=> 'canvas',
	'Carousel' 						=> 'carousel',
	'Crelly slider' 				=> 'crelly',
	'Featured Post' 				=> 'featured',
	'Flash News' 					=> 'flashnews',
	'Gallery' 						=> 'gallery',
	'Image'							=> 'image',
	'Info Box' 						=> 'ibox',
	'Insights'						=> 'insights',
	'Slidable Insights'				=> 'sl_insights',
	'Logos Roll'					=> 'logos',
	'Magazine' 						=> 'magazine',
	'Portfolio'						=> 'portfolio',
	'Pricing Tables'				=> 'pr_tables',
	'Services'						=> 'services',
	'Slider' 						=> 'slider',
	'Posts Slider' 					=> 'pslider',
	'Slogan' 						=> 'slogan',
	'Team'							=> 'team',
	'Testimonials'					=> 'testimonials',
	'Tiled Display' 				=> 'display',
	'Video & Embeds'				=> 'video',
	'Video Posts Slider'			=> 'videoposts',
	'Modules Columns'				=> 'columns',
	'Modules Tabs'					=> 'tabs',
	'Modules Wrapper (W/Sidebar)'	=> 'wrapper',
);

// Apply Filter Available Modules
$qi_available_modules = apply_filters( 'qi_filter_available_modules', $qi_available_modules );

// Create Modules definition array
foreach ($qi_available_modules as $type => $slug) {
	$modules_array[] = array( 'type' => $type, 'slug' => $slug );
}

$quadro_cfields_def = array(

	// Adding Posts basic meta box
	'post_metabox' => array(
		'id' => 'post-metabox',
		'title' => esc_html__('Post Header Options', 'indigo'),
		'page' => 'post',
		'context' => 'side',
		'priority' => 'default',
		'fields' => array(
			array(
				'name' => esc_html__('Header Size', 'indigo'),
				'id' => $prefix . 'post_header_size',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Regular', 'indigo' ), 'value' => 'regular'),
					array('name' => esc_html__('Big', 'indigo' ), 'value' => 'big'),
					array('name' => esc_html__('Giant', 'indigo' ), 'value' => 'giant'),
					),
				'std' => 'regular'
			),
			array(
				'name' => esc_html__('Use as Background', 'indigo'),
				'id' => $prefix . 'post_header_back',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Featured Image', 'indigo' ), 'value' => 'featured'),
					array('name' => esc_html__('Solid Color', 'indigo' ), 'value' => 'color'),
					),
				'std' => 'featured'
			),
			array(
				'name' => esc_html__('Back color', 'indigo'),
				'id' => $prefix . 'post_header_back_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Text color', 'indigo'),
				'id' => $prefix . 'post_header_text_color',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Automatic', 'indigo' ), 'value' => 'auto'),
					array('name' => esc_html__('Dark', 'indigo' ), 'value' => 'dark'),
					array('name' => esc_html__('Light', 'indigo' ), 'value' => 'light'),
					),
				'std' => 'auto'
			),
			array(
				'name' => esc_html__('Dark Background Overlay', 'indigo'),
				'id' => $prefix . 'post_header_overlay',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Enabled', 'indigo' ), 'value' => 'on'),
					array('name' => esc_html__('Disabled', 'indigo' ), 'value' => 'off'),
					),
				'std' => 'on'
			),
		)
	),

	// Adding Modular Template meta box
	'modular_template_metabox' => array(
		'id' => 'modular-qi-template-metabox',
		'title' => esc_html__('Modular Template Options', 'indigo'),
		'page' => 'page',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Choose Modules to Show', 'indigo'),
				'id' => $prefix . 'mod_temp_modules',
				'type' => 'posts_picker',
				'post_type' => 'quadro_mods',
				'available_mods' => $qi_available_modules,
				'show_type' => false
			),
			array(
				'name' => esc_html__('Modules Navigation', 'indigo'),
				'id' => $prefix . 'mod_temp_navigation',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Disabled', 'indigo' ), 'value' => 'off'),
					array('name' => esc_html__('Enabled', 'indigo' ), 'value' => 'on'),
					),
				'std' => 'off'
			),
		)
	),

	// Adding Pages basic meta box
	'page_metabox' => array(
		'id' => 'page-metabox',
		'title' => esc_html__('Page Options', 'indigo'),
		'page' => 'page',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Site Header Style', 'indigo'),
				'id' => $prefix . 'site_header_style',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Same as site', 'indigo' ), 'value' => 'same'),
					array('name' => esc_html__('With background', 'indigo' ), 'value' => 'background'),
					array('name' => esc_html__('Transparent', 'indigo' ), 'value' => 'transparent'),
					),
				'desc' => esc_html__('Overrides Theme Options Header Style Setting. Note: won\'t apply for Header Layout 7.', 'indigo'),
				'std' => 'same'
			),
			array(
				'name' => esc_html__('Color for Transparent Site Header', 'indigo'),
				'id' => $prefix . 'site_header_color',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Same as site', 'indigo' ), 'value' => 'same'),
					array('name' => esc_html__('Light', 'indigo' ), 'value' => 'light'),
					array('name' => esc_html__('Dark', 'indigo' ), 'value' => 'dark'),
					),
				'std' => 'same'
			),
			array(
				'name' => esc_html__('Select Sidebar', 'indigo'),
				'id' => $prefix . 'page_sidebar',
				'type' => 'sidebar_picker',
			),
			array(
				'name' => esc_html__('Hide Page Header (homepage use, for example)', 'indigo'),
				'id' => $prefix . 'page_header_hide',
				'type' => 'checkbox'
			),
			array(
				'name' => esc_html__('Page Header Position', 'indigo'),
				'id' => $prefix . 'page_header_pos',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Center', 'indigo' ), 'value' => 'center'),
					array('name' => esc_html__('Left', 'indigo' ), 'value' => 'left'),
					),
				'std' => 'center'
			),
			array(
				'name' => esc_html__('Page Header Size', 'indigo'),
				'id' => $prefix . 'page_header_size',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Regular', 'indigo' ), 'value' => 'regular'),
					array('name' => esc_html__('Big', 'indigo' ), 'value' => 'big'),
					),
				'std' => 'regular'
			),
			array(
				'name' => esc_html__('Breadcrumbs on this page', 'indigo'),
				'id' => $prefix . 'page_breadcrumbs',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'indigo' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'indigo' ), 'value' => 'hide')
					),
				'std' => 'show'
			),
			array(
				'name' => esc_html__('Title color', 'indigo'),
				'id' => $prefix . 'page_title_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Header Back color', 'indigo'),
				'id' => $prefix . 'page_header_back_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Use Picture as Header Back (uses Feat. Image)', 'indigo'),
				'id' => $prefix . 'page_header_back_usepic',
				'type' => 'checkbox'
			),
			array(
				'name' => esc_html__('Display Tagline', 'indigo'),
				'id' => $prefix . 'page_show_tagline',
				'type' => 'checkbox'
			),
			array(
				'name' => esc_html__('Tagline text', 'indigo'),
				'id' => $prefix . 'page_tagline',
				'type' => 'textarea',
				'sanitize' => 'html',
				'desc' => ''
			),
			array(
				'name' => esc_html__('Use Picture as Page Back', 'indigo'),
				'id' => $prefix . 'page_back_usepic',
				'type' => 'checkbox'
			),
			array(
				'name' => esc_html__('Background for this Page', 'indigo'),
				'id' => $prefix . 'page_back_pic',
				'type' => 'upload'
			)
		)
	),

	// Adding modules Types meta box
	'mod_type_metabox' => array(
		'id' => 'mod-type-metabox',
		'title' => esc_html__('Module Type', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Select Module Type', 'indigo'),
				'id' => $prefix . 'mod_type',
				'type' => 'double_select',
				'options' => $modules_array
			),
		)
	),

	// Adding modules Fields Container meta box
	'mod_container_metabox' => array(
		'id' => 'mod-container-metabox',
		'title' => esc_html__('Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array()
	),

	// Adding modules basic meta box
	'mod_metabox' => array(
		'id' => 'mod-metabox',
		'title' => esc_html__('Module Style', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Module Header', 'indigo'),
				'id' => $prefix . 'mod_header_subtitle',
				'type' => 'subtitle'
			),
			array(
				'name' => esc_html__('Header Layout', 'indigo'),
				'id' => $prefix . 'mod_header_layout',
				'type' => 'layout-picker',
				'path' => '/images/admin/module-header/',
				'options' => array(
					'none' => array(
						'name' => 'none',
						'title' => esc_html__( 'No Header', 'indigo' ),
						'img' => 'mod-header-none.png',
						'description' => '',
					),
					'fullwidth' => array(
						'name' => 'fullwidth',
						'title' => esc_html__( 'Fullwidth', 'indigo' ),
						'img' => 'mod-header-full.png',
						'description' => '',
					),
					'integrated' => array(
						'name' => 'integrated',
						'title' => esc_html__( 'Integrated', 'indigo' ),
						'img' => 'mod-header-integrated.png',
						'description' => '',
					),
					'left' => array(
						'name' => 'left',
						'title' => esc_html__( 'Left Header', 'indigo' ),
						'img' => 'mod-header-left.png',
						'description' => '',
					),
					'right' => array(
						'name' => 'right',
						'title' => esc_html__( 'Right Header', 'indigo' ),
						'img' => 'mod-header-right.png',
						'description' => '',
					),
					'left-50' => array(
						'name' => 'left-50',
						'title' => esc_html__( 'Left Header - 50%', 'indigo' ),
						'img' => 'mod-header-left-50.png',
						'description' => '',
					),
					'right-50' => array(
						'name' => 'right-50',
						'title' => esc_html__( 'Right Header - 50%', 'indigo' ),
						'img' => 'mod-header-right-50.png',
						'description' => '',
					),
				),
				'desc' => '',
				'std' => 'none'
			),
			array(
				'name' => esc_html__('Module Introduction', 'indigo'),
				'id' => $prefix . 'mod_intro',
				'type' => 'textarea',
			),
			array(
				'name' => esc_html__('Button Text', 'indigo'),
				'id' => $prefix . 'mod_header_btn',
				'type' => 'text',
				'std' => '',
				'desc' => esc_html__('(Optional) Leave empty for no button.', 'indigo')
			),
			array(
				'name' => esc_html__('Button Link', 'indigo'),
				'id' => $prefix . 'mod_header_btn_url',
				'type' => 'text',
				'std' => '',
			),
			array(
				'name' => esc_html__('Title color', 'indigo'),
				'id' => $prefix . 'mod_title_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Header background color', 'indigo'),
				'id' => $prefix . 'mod_title_back',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => '',
				'id' => $prefix . 'mod_title_back_usepic',
				'type' => 'checkbox',
				'desc' => esc_html__('Use Picture as Header Background', 'indigo'),
			),
			array(
				'name' => esc_html__('Header Image Background', 'indigo'),
				'id' => $prefix . 'mod_title_back_pic',
				'type' => 'upload'
			),
			array(
				'name' => esc_html__('Module Background', 'indigo'),
				'id' => $prefix . 'mod_back_subtitle',
				'type' => 'subtitle'
			),
			array(
				'name' => esc_html__('Background color', 'indigo'),
				'id' => $prefix . 'mod_back_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Background pattern', 'indigo'),
				'id' => $prefix . 'mod_back_pattern',
				'type' => 'pattern_picker'
			),
			array(
				'name' => '',
				'id' => $prefix . 'mod_back_usepic',
				'type' => 'checkbox',
				'desc' => esc_html__('Use Picture as Background', 'indigo'),
			),
			array(
				'name' => esc_html__('Image Background', 'indigo'),
				'id' => $prefix . 'mod_back_pic',
				'type' => 'upload'
			),
			array(
				'name' => esc_html__('Dark Background Overlay', 'indigo'),
				'id' => $prefix . 'mod_overlay',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Disabled', 'indigo' ), 'value' => 'off'),
					array('name' => esc_html__('Enabled', 'indigo' ), 'value' => 'on'),
					),
				'std' => 'off'
			),
			array(
				'name' => '',
				'id' => $prefix . 'mod_parallax',
				'type' => 'checkbox',
				'desc' => esc_html__('Fixed Background', 'indigo'),
			),
		)
	),

	// Adding quadro_portfolio meta boxes for Portfolio type
	'quadro_portfolio_meta_box' => array(
		'id' => 'quadro-portfolio-metabox',
		'title' => esc_html__('Portfolio Item Options', 'indigo'),
		'page' => 'quadro_portfolio',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
			array(
				'name' => esc_html__('Item Style', 'indigo'),
				'id' => $prefix . 'portfolio_item_style',
				'type' => 'layout-picker',
				'path' => '/images/admin/single-port-layouts/',
				'options' => array(
					'portf-layout1' => array(
						'name' => 'portf-layout1',
						'title' => esc_html__( 'Content on Right w/Expanded Media', 'indigo' ),
						'img' => 'portf-layout1.png',
						'description' => '',
					),
					'portf-layout2' => array(
						'name' => 'portf-layout2',
						'title' => esc_html__( 'Content on Right w/Media Slider', 'indigo' ),
						'img' => 'portf-layout2.png',
						'description' => '',
					),
					'portf-layout3' => array(
						'name' => 'portf-layout3',
						'title' => esc_html__( 'Content on Top w/Expanded Media', 'indigo' ),
						'img' => 'portf-layout3.png',
						'description' => '',
					),
					'portf-layout4' => array(
						'name' => 'portf-layout4',
						'title' => esc_html__( 'Content on Top w/Media Slider', 'indigo' ),
						'img' => 'portf-layout4.png',
						'description' => '',
					),
					'portf-layout5' => array(
						'name' => 'portf-layout5',
						'title' => esc_html__( 'Masonry Grid (three columns)', 'indigo' ),
						'img' => 'portf-layout5.png',
						'description' => '',
					),
					'portf-layout5b' => array(
						'name' => 'portf-layout5b',
						'title' => esc_html__( 'Masonry Grid (two columns)', 'indigo' ),
						'img' => 'portf-layout5b.png',
						'description' => '',
					),
					'portf-layout6' => array(
						'name' => 'portf-layout6',
						'title' => esc_html__( 'Large Media Slider w/Slidable Content', 'indigo' ),
						'img' => 'portf-layout6.png',
						'description' => '',
					),
					'as-created' => array(
						'name' => 'as-created',
						'title' => esc_html__( 'As Created & Formatted', 'indigo' ),
						'img' => 'as-created.png',
						'description' => '',
					),
				),
				'desc' => '',
				'std' => 'portf-layout1'
			),
			array(
				'name' => esc_html__('Use Feat. Image on', 'indigo'),
				'id' => $prefix . 'portfolio_feat_image',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Item Header', 'indigo' ), 'value' => 'header'),
					array('name' => esc_html__('Item Media', 'indigo' ), 'value' => 'media'),
					),
				'std' => 'header'
			),
			array(
				'name' => esc_html__('Video Position', 'indigo'),
				'id' => $prefix . 'portfolio_video_position',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('After Gallery/Image', 'indigo' ), 'value' => 'gallery,video'),
					array('name' => esc_html__('Before Gallery/Image', 'indigo' ), 'value' => 'video,gallery'),
					),
				'std' => 'gallery,video'
			),
			array(
				'name' => esc_html__('Keep video out of slider', 'indigo'),
				'id' => $prefix . 'portfolio_video_out',
				'type' => 'checkbox'
			),
			array(
				'name' => esc_html__('External Link', 'indigo'),
				'id' => $prefix . 'portfolio_link',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Link Title', 'indigo'),
				'id' => $prefix . 'portfolio_link_title',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Wrap images with links', 'indigo'),
				'id' => $prefix . 'portfolio_img_link',
				'type' => 'checkbox',
				'desc' => esc_html__('Links images in galleries to their own files (useful for use with lightbox plugins).', 'indigo')
			),
			array(
				'name' => esc_html__('View All Items URL', 'indigo'),
				'id' => $prefix . 'portfolio_viewall_url',
				'type' => 'text',
				'desc' => esc_html__('Note: will override Theme Options setting.', 'indigo')
			),
			array(
				'name' => esc_html__('View All Items Text', 'indigo'),
				'id' => $prefix . 'portfolio_viewall',
				'type' => 'text',
				'desc' => esc_html__('Note: will override Theme Options setting.', 'indigo')
			),
			array(
				'name' => esc_html__('Data Fields', 'indigo'),
				'id' => $prefix . 'portfolio_fields',
				'type' => 'portfolio-fields-input',
				'desc' => esc_html__('Add new data fields in', 'indigo') . ' <a href="' . esc_url( admin_url( 'themes.php?page=quadro-settings&tab=portfolio' ) ) . '">' . esc_html__('Theme Options >> Portfolio Tab', 'indigo') . '</a>.<br />' . esc_html__('Fields with completed info will be shown on this Item\'s view.', 'indigo')
			),
		)
	),

);

$quadro_cfields_mods_def = array(

	// Adding modules TABS Type meta box
	'mod_tabs_type_metabox' => array(
		'id' => 'mod-tabs-qi-type-metabox',
		'title' => esc_html__('Modules Tabs Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => wp_kses_post( __('Choose Modules to Show <small>Each selected module will create a tab for itself.</small>', 'indigo') ),
				'id' => $prefix . 'mod_tabs_modules',
				'type' => 'posts_picker',
				'post_type' => 'quadro_mods',
				'available_mods' => $qi_available_modules,
				'show_type' => false,
				'wrapper' => true
			),
			array(
                'name' => wp_kses_post( __('Tabs Titles <br /><small>These need to be added manually and in proper order.<small>', 'indigo') ),
                'id' => $prefix . 'mod_tabs_titles',
                'type' => 'repeatable',
                'item-name' => esc_html__('Tab', 'indigo'),
                'repeat-fields' => array(
                	'title' => array( 'name' => 'title', 'title' => 'Title', 'type' => 'text' ),
                ),
                'repeat-item' => esc_html__('Add another Title', 'indigo'),
                'dependant'
            ),
		)
	),

	// Adding modules IMAGE Type meta box
	'mod_image_type_metabox' => array(
		'id' => 'mod-image-qi-type-metabox',
		'title' => esc_html__('Image Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Note:', 'indigo'),
				'id' => $prefix . 'mod_image_desc',
				'type' => 'subtitle',
				'desc' => esc_html__('Upload an image for this module through the Media Library or via the "Set Featured Image" metabox, and set it as featured image.', 'indigo'),
			),
		)
	),

	// Adding modules WRAPPER Type meta box
	'mod_wrapper_type_metabox' => array(
		'id' => 'mod-wrapper-qi-type-metabox',
		'title' => esc_html__('Wrapper Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Sidebar Position', 'indigo'),
				'id' => $prefix . 'mod_wrapper_sidebar',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Right', 'indigo' ), 'value' => 'right'),
					array('name' => esc_html__('Left', 'indigo' ), 'value' => 'left'),
				),
				'std' => 'right'
			),
			array(
				'name' => esc_html__('Select Sidebar', 'indigo'),
				'id' => $prefix . 'mod_wrapper_sidebar_pick',
				'type' => 'sidebar_picker',
			),
			array(
				'name' => esc_html__('Choose Modules to Show', 'indigo'),
				'id' => $prefix . 'mod_wrapper_modules',
				'type' => 'posts_picker',
				'post_type' => 'quadro_mods',
				'available_mods' => $qi_available_modules,
				'show_type' => false,
				'wrapper' => true
			),
		)
	),

	// Adding modules COLUMNS Type meta box
	'mod_columns_type_metabox' => array(
		'id' => 'mod-columns-qi-type-metabox',
		'title' => esc_html__('Columns Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Columns Layout', 'indigo'),
				'id' => $prefix . 'mod_columns_layout',
				'type' => 'layout-picker',
				'path' => '/images/admin/columns-layouts/',
				'options' => array(
					'layout1' => array(
						'name' => 'layout1',
						'title' => esc_html__( '½ - ½', 'indigo' ),
						'img' => 'columns-layout1.png',
						'description' => '',
					),
					'layout2' => array(
						'name' => 'layout2',
						'title' => esc_html__( '⅓ - ⅓ - ⅓', 'indigo' ),
						'img' => 'columns-layout2.png',
						'description' => '',
					),
					'layout3' => array(
						'name' => 'layout3',
						'title' => esc_html__( '¼ - ¼ - ¼ - ¼', 'indigo' ),
						'img' => 'columns-layout3.png',
						'description' => '',
					),
					'layout4' => array(
						'name' => 'layout4',
						'title' => esc_html__( '½ - ¼ - ¼', 'indigo' ),
						'img' => 'columns-layout4.png',
						'description' => '',
					),
					'layout5' => array(
						'name' => 'layout5',
						'title' => esc_html__( '¼ - ¼ - ½', 'indigo' ),
						'img' => 'columns-layout5.png',
						'description' => '',
					),
					'layout6' => array(
						'name' => 'layout6',
						'title' => esc_html__( '⅔ - ⅓', 'indigo' ),
						'img' => 'columns-layout6.png',
						'description' => '',
					),
					'layout7' => array(
						'name' => 'layout7',
						'title' => esc_html__( '⅓ - ⅔', 'indigo' ),
						'img' => 'columns-layout7.png',
						'description' => '',
					),
					'layout8' => array(
						'name' => 'layout8',
						'title' => esc_html__( '¾ - ¼', 'indigo' ),
						'img' => 'columns-layout8.png',
						'description' => '',
					),
					'layout9' => array(
						'name' => 'layout9',
						'title' => esc_html__( '¼ - ¾', 'indigo' ),
						'img' => 'columns-layout9.png',
						'description' => '',
					),
					'layout10' => array(
						'name' => 'layout10',
						'title' => esc_html__( '¼ - ½ - ¼', 'indigo' ),
						'img' => 'columns-layout10.png',
						'description' => '',
					),
					'layout11' => array(
						'name' => 'layout11',
						'title' => esc_html__( '⅕ - ⅗ - ⅕', 'indigo' ),
						'img' => 'columns-layout11.png',
						'description' => '',
					),
					'layout12' => array(
						'name' => 'layout12',
						'title' => esc_html__( '⅗ - ⅖', 'indigo' ),
						'img' => 'columns-layout12.png',
						'description' => '',
					),
					'layout13' => array(
						'name' => 'layout13',
						'title' => esc_html__( '⅖ - ⅗', 'indigo' ),
						'img' => 'columns-layout13.png',
						'description' => '',
					),
					'layout14' => array(
						'name' => 'layout14',
						'title' => esc_html__( '1 - ½ - ½', 'indigo' ),
						'img' => 'columns-layout14.png',
						'description' => '',
					),
					'layout15' => array(
						'name' => 'layout15',
						'title' => esc_html__( '½ - ½ - 1', 'indigo' ),
						'img' => 'columns-layout15.png',
						'description' => '',
					),
				),
				'std' => 'layout1'
			),
			array(
				'name' => esc_html__('1st Column Modules', 'indigo'),
				'id' => $prefix . 'mod_columns_modules_subtitle1',
				'type' => 'subtitle',
				'desc' => esc_html__('Choose the modules that go on the first column.', 'indigo'),
			),
			array(
				'name' => esc_html__('Choose Modules to Show', 'indigo'),
				'id' => $prefix . 'mod_columns_modules1',
				'type' => 'posts_picker',
				'post_type' => 'quadro_mods',
				'available_mods' => $qi_available_modules,
				'show_type' => false,
				'wrapper' => true
			),
			array(
				'name' => esc_html__('2nd Column Modules', 'indigo'),
				'id' => $prefix . 'mod_columns_modules_subtitle2',
				'type' => 'subtitle',
				'desc' => esc_html__('Choose the modules that go on the second column.', 'indigo'),
			),
			array(
				'name' => esc_html__('Choose Modules to Show', 'indigo'),
				'id' => $prefix . 'mod_columns_modules2',
				'type' => 'posts_picker',
				'post_type' => 'quadro_mods',
				'available_mods' => $qi_available_modules,
				'show_type' => false,
				'wrapper' => true
			),
			array(
				'name' => esc_html__('3rd Column Modules', 'indigo'),
				'id' => $prefix . 'mod_columns_modules_subtitle3',
				'type' => 'subtitle',
				'desc' => esc_html__('Choose the modules that go on the third column (if the layout has 3 or more columns).', 'indigo'),
			),
			array(
				'name' => esc_html__('Choose Modules to Show', 'indigo'),
				'id' => $prefix . 'mod_columns_modules3',
				'type' => 'posts_picker',
				'post_type' => 'quadro_mods',
				'available_mods' => $qi_available_modules,
				'show_type' => false,
				'wrapper' => true
			),
			array(
				'name' => esc_html__('4th Column Modules', 'indigo'),
				'id' => $prefix . 'mod_columns_modules_subtitle4',
				'type' => 'subtitle',
				'desc' => esc_html__('Choose the modules that go on the fourth column (if the layout has 4 columns).', 'indigo'),
			),
			array(
				'name' => esc_html__('Choose Modules to Show', 'indigo'),
				'id' => $prefix . 'mod_columns_modules4',
				'type' => 'posts_picker',
				'post_type' => 'quadro_mods',
				'available_mods' => $qi_available_modules,
				'show_type' => false,
				'wrapper' => true
			),
		)
	),

	// Adding modules CAROUSEL Type meta box
	'mod_carousel_type_metabox' => array(
		'id' => 'mod-carousel-qi-type-metabox',
		'title' => esc_html__('Carousel Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Margins (make full width)', 'indigo'),
				'id' => $prefix . 'mod_carousel_margins',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('With Margins', 'indigo' ), 'value' => 'with-margins'),
					array('name' => esc_html__('Without Margins', 'indigo' ), 'value' => 'no-margins'),
				),
				'std' => 'with-margins'
			),
			array(
				'name' => esc_html__('How many posts to show?', 'indigo'),
				'id' => $prefix . 'mod_carousel_pper',
				'type' => 'text',
				'std' => '',
				'desc' => esc_html__('Enter -1 to show all posts.', 'indigo')
			),
			array(
				'name' => esc_html__('What to show?', 'indigo'),
				'id' => $prefix . 'mod_carousel_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('All Posts', 'indigo' ), 'value' => 'all'),
					array('name' => esc_html__('By Categories', 'indigo' ), 'value' => 'tax'),
					array('name' => esc_html__('By Post Format', 'indigo' ), 'value' => 'format'),
					array('name' => esc_html__('Custom Selection', 'indigo' ), 'value' => 'custom'),
				),
				'std' => 'all'
			),
			array(
				'name' => esc_html__('Choose Categories to Show', 'indigo'),
				'id' => $prefix . 'mod_carousel_terms',
				'type' => 'tax_picker',
				'tax_slug' => 'category'
			),
			array(
				'name' => esc_html__('Choose Post Formats to Show', 'indigo'),
				'id' => $prefix . 'mod_carousel_formats',
				'type' => 'format_picker',
			),
			array(
				'name' => esc_html__('Choose Posts to Show', 'indigo'),
				'id' => $prefix . 'mod_pick_carousel',
				'type' => 'posts_picker',
				'post_type' => array( 'post', 'product', 'quadro_portfolio' ),
				'show_type' => true
			),
			array(
				'name' => esc_html__('Posts Offset', 'indigo'),
				'id' => $prefix . 'mod_carousel_offset',
				'type' => 'number',
				'desc' => esc_html__(' Enter a number (optional). Use this option to pass over any amount of posts. Delete value to cancel.', 'indigo')
			),
			array(
				'name' => esc_html__('Exclude Posts', 'indigo'),
				'id' => $prefix . 'mod_carousel_exclude',
				'type' => 'text',
				'desc' => esc_html__('Enter IDs for excluded posts, separated by a comma.', 'indigo')
			),
		)
	),

	// Adding modules LOGOS ROLL Type meta box
	'mod_logos_type_metabox' => array(
		'id' => 'mod-logos-qi-type-metabox',
		'title' => esc_html__('Logos Roll Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Layout', 'indigo'),
				'id' => $prefix . 'mod_logos_layout',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Carousel', 'indigo' ), 'value' => 'carousel'),
					array('name' => esc_html__('Still', 'indigo' ), 'value' => 'still'),
				),
				'std' => 'all'
			),
			array(
				'name' => esc_html__('Columns', 'indigo'),
				'id' => $prefix . 'mod_logos_columns',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('3', 'indigo' ), 'value' => 'three'),
					array('name' => esc_html__('4', 'indigo' ), 'value' => 'four'),
					array('name' => esc_html__('5', 'indigo' ), 'value' => 'five'),
					array('name' => esc_html__('6', 'indigo' ), 'value' => 'six'),
				),
				'std' => 'three'
			),
			array(
                'name' => esc_html__('', 'indigo'),
                'id' => $prefix . 'mod_logos_content',
                'type' => 'repeatable',
                'desc' => esc_html__('Add as many logos as you want, one at a time.', 'indigo'),
                'item-name' => esc_html__('Logo', 'indigo'),
                'repeat-fields' => array(
                	'img' => array( 'name' => 'img', 'title' => 'Image File', 'type' => 'upload' ),
                	'link_url' => array( 'name' => 'link_url', 'title' => 'Link (URL)', 'type' => 'text' ),
                ),
                'repeat-item' => esc_html__('Add another Logo', 'indigo')
            ),
		)
	),

	// Adding modules CRELLY SLIDER Type meta box
	'mod_crelly_type_metabox' => array(
		'id' => 'mod-crelly-qi-type-metabox',
		'title' => esc_html__('Crelly Slider Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Slider Shortcode', 'indigo'),
				'id' => $prefix . 'mod_crelly_shortcode',
				'type' => 'text',
				'desc' => esc_html__('Paste in this field the shortcode for the slider as you would normally paste on any page.', 'indigo')
			),
		)
	),

	// Adding modules DISPLAY Type meta box
	'mod_display_type_metabox' => array(
		'id' => 'mod-display-qi-type-metabox',
		'title' => esc_html__('Display Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Display Style', 'indigo'),
				'id' => $prefix . 'mod_display_layout',
				'type' => 'layout-picker',
				'path' => '/images/admin/display-styles/',
				'options' => array(
					'layout1' => array(
						'name' => 'layout1',
						'title' => esc_html__( 'Layout 1', 'indigo' ),
						'img' => 'display-style1.png',
						'description' => '',
					),
					'layout2' => array(
						'name' => 'layout2',
						'title' => esc_html__( 'Layout 2', 'indigo' ),
						'img' => 'display-style2.png',
						'description' => '',
					),
					'layout3' => array(
						'name' => 'layout3',
						'title' => esc_html__( 'Layout 3', 'indigo' ),
						'img' => 'display-style3.png',
						'description' => '',
					),
					'layout4' => array(
						'name' => 'layout4',
						'title' => esc_html__( 'Layout 4', 'indigo' ),
						'img' => 'display-style4.png',
						'description' => '',
					),
					'layout5' => array(
						'name' => 'layout5',
						'title' => esc_html__( 'Layout 5', 'indigo' ),
						'img' => 'display-style5.png',
						'description' => '',
					),
				),
				'desc' => wp_kses_post( __( 'To use layouts 1 or 3 <strong>large thumbnail</strong> size must be set on WordPress defaults of 1024 by 1024 pixels.', 'indigo' ) ),
				'std' => 'layout1'
			),
			array(
				'name' => esc_html__('Margins (make full width)', 'indigo'),
				'id' => $prefix . 'mod_display_margins',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('With Margins', 'indigo' ), 'value' => 'with-margins'),
					array('name' => esc_html__('Without Margins', 'indigo' ), 'value' => 'no-margins'),
				),
				'std' => 'with-margins'
			),
			array(
				'name' => esc_html__('What to show?', 'indigo'),
				'id' => $prefix . 'mod_display_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('All Posts', 'indigo' ), 'value' => 'all'),
					array('name' => esc_html__('By Categories', 'indigo' ), 'value' => 'tax'),
					array('name' => esc_html__('By Post Format', 'indigo' ), 'value' => 'format'),
					array('name' => esc_html__('Custom Selection', 'indigo' ), 'value' => 'custom'),
				),
				'std' => 'all'
			),
			array(
				'name' => esc_html__('Choose Categories to Show', 'indigo'),
				'id' => $prefix . 'mod_display_terms',
				'type' => 'tax_picker',
				'tax_slug' => 'category'
			),
			array(
				'name' => esc_html__('Choose Post Formats to Show', 'indigo'),
				'id' => $prefix . 'mod_display_formats',
				'type' => 'format_picker',
			),
			array(
				'name' => esc_html__('Choose Posts to Show', 'indigo'),
				'id' => $prefix . 'mod_pick_display',
				'type' => 'posts_picker',
				'post_type' => array( 'post', 'product' ),
				'show_type' => true
			),
			array(
				'name' => esc_html__('Posts Offset', 'indigo'),
				'id' => $prefix . 'mod_display_offset',
				'type' => 'number',
				'desc' => esc_html__(' Enter a number (optional). Use this option to pass over any amount of posts. Delete value to cancel.', 'indigo')
			),
			array(
				'name' => esc_html__('Exclude Posts', 'indigo'),
				'id' => $prefix . 'mod_display_exclude',
				'type' => 'text',
				'desc' => esc_html__('Enter IDs for excluded posts, separated by a comma.', 'indigo')
			),
		)
	),

	// Adding modules FLASH NEWS Type meta box
	'mod_flashnews_type_metabox' => array(
		'id' => 'mod-flashnews-qi-type-metabox',
		'title' => esc_html__('Flash News Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('How many posts to show?', 'indigo'),
				'id' => $prefix . 'mod_flashnews_pper',
				'type' => 'text',
				'std' => '',
				'desc' => esc_html__('Enter -1 to show all posts.', 'indigo')
			),
			array(
				'name' => esc_html__('What to show?', 'indigo'),
				'id' => $prefix . 'mod_flashnews_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('All Posts', 'indigo' ), 'value' => 'all'),
					array('name' => esc_html__('By Categories', 'indigo' ), 'value' => 'tax'),
					array('name' => esc_html__('By Post Format', 'indigo' ), 'value' => 'format'),
					array('name' => esc_html__('Custom Selection', 'indigo' ), 'value' => 'custom'),
				),
				'std' => 'all'
			),
			array(
				'name' => esc_html__('Choose Categories to Show', 'indigo'),
				'id' => $prefix . 'mod_flashnews_terms',
				'type' => 'tax_picker',
				'tax_slug' => 'category'
			),
			array(
				'name' => esc_html__('Choose Post Formats to Show', 'indigo'),
				'id' => $prefix . 'mod_flashnews_formats',
				'type' => 'format_picker',
			),
			array(
				'name' => esc_html__('Choose Posts to Show', 'indigo'),
				'id' => $prefix . 'mod_pick_flashnews',
				'type' => 'posts_picker',
				'post_type' => array( 'post' ),
				'show_type' => true
			),
			array(
				'name' => esc_html__('Posts Offset', 'indigo'),
				'id' => $prefix . 'mod_flashnews_offset',
				'type' => 'number',
				'desc' => esc_html__(' Enter a number (optional). Use this option to pass over any amount of posts. Delete value to cancel.', 'indigo')
			),
			array(
				'name' => esc_html__('Exclude Posts', 'indigo'),
				'id' => $prefix . 'mod_flashnews_exclude',
				'type' => 'text',
				'desc' => esc_html__('Enter IDs for excluded posts, separated by a comma.', 'indigo')
			),
		)
	),

	// Adding modules INSIGHTS Type meta box
	'mod_insights_type_metabox' => array(
		'id' => 'mod-insights-qi-type-metabox',
		'title' => esc_html__('Insights Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Text Color', 'indigo'),
				'id' => $prefix . 'mod_insights_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Animation', 'indigo'),
				'id' => $prefix . 'mod_insights_anim',
				'type' => 'select',
				'options' => qi_available_animations(),
				'desc' => '',
				'std' => 'none'
			),
			array(
				'name' => esc_html__('Animation Delay Between Elements (in ms.)', 'indigo'),
				'id' => $prefix . 'mod_insights_anim_delay',
				'type' => 'number',
			),
			array(
                'name' => esc_html__('Insights', 'indigo'),
                'id' => $prefix . 'mod_insights',
                'type' => 'repeatable',
                'desc' => esc_html__('Add as many Insights as you want, one at a time.', 'indigo'),
                'repeat-fields' => array(
                	'title' => array( 'name' => 'title', 'title' => 'Title', 'type' => 'text' ),
                	'content' => array( 'name' => 'content', 'title' => 'Content', 'type' => 'editor' ),
                	'img' => array( 'name' => 'img', 'title' => 'Image', 'type' => 'upload' ),
                	'button_text' => array( 'name' => 'button_text', 'title' => 'Button Text', 'type' => 'text' ),
                	'button_url' => array( 'name' => 'button_url', 'title' => 'Button Link', 'type' => 'text' ),
                	'layout' => array( 
                		'name' => 'layout', 
                		'title' => 'Layout', 
                		'type' => 'layout-picker',
                		'path' => '/images/admin/insight-layouts/',
                		'std' => 'layout1',
                		'options' => array(
							'layout1' => array(
								'name' => 'layout1',
								'title' => esc_html__( 'Layout 1', 'indigo' ),
								'img' => 'insight-layout1.png',
								'description' => '',
							),
							'layout2' => array(
								'name' => 'layout2',
								'title' => esc_html__( 'Layout 2', 'indigo' ),
								'img' => 'insight-layout2.png',
								'description' => '',
							),
							'layout3' => array(
								'name' => 'layout3',
								'title' => esc_html__( 'Layout 3', 'indigo' ),
								'img' => 'insight-layout3.png',
								'description' => '',
							),
							'layout4' => array(
								'name' => 'layout4',
								'title' => esc_html__( 'Layout 4', 'indigo' ),
								'img' => 'insight-layout4.png',
								'description' => '',
							),
						),
                	),
                ),
                'item-name' => esc_html__('Insight', 'indigo'),
                'repeat-item' => esc_html__('Add another Insight', 'indigo'),
            ),
		)
	),

	// Adding modules MAGAZINE Type meta box
	'mod_magazine_type_metabox' => array(
		'id' => 'mod-magazine-qi-type-metabox',
		'title' => esc_html__('Magazine Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Magazine Style', 'indigo'),
				'id' => $prefix . 'mod_magazine_layout',
				'type' => 'layout-picker',
				'path' => '/images/admin/magazine-styles/',
				'options' => array(
					'layout1' => array(
						'name' => 'layout1',
						'title' => esc_html__( 'Layout 1', 'indigo' ),
						'img' => 'magazine-style1.png',
						'description' => '',
					),
					'layout2' => array(
						'name' => 'layout2',
						'title' => esc_html__( 'Layout 2', 'indigo' ),
						'img' => 'magazine-style2.png',
						'description' => '',
					),
					'layout3' => array(
						'name' => 'layout3',
						'title' => esc_html__( 'Layout 3', 'indigo' ),
						'img' => 'magazine-style3.png',
						'description' => '',
					),
					'layout4' => array(
						'name' => 'layout4',
						'title' => esc_html__( 'Layout 4', 'indigo' ),
						'img' => 'magazine-style4.png',
						'description' => '',
					),
				),
				'desc' => '',
				'std' => 'layout1'
			),
			array(
				'name' => esc_html__('Columns', 'indigo'),
				'id' => $prefix . 'mod_magazine_columns',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Two', 'indigo' ), 'value' => 'two'),
					array('name' => esc_html__('Three', 'indigo' ), 'value' => 'three'),
				),
				'desc' => esc_html__('Applies only for layouts 2 and 4.', 'indigo'),
				'std' => 'two'
			),
			array(
				'name' => esc_html__('How many posts to show?', 'indigo'),
				'id' => $prefix . 'mod_magazine_perpage',
				'type' => 'text',
				'std' => '',
				'desc' => esc_html__('Applies only for layout 3 and 4. Enter -1 to show all posts. Will show this amount of posts *per page* if pagination enabled.', 'quadro')
			),
			array(
				'name' => esc_html__('Posts Pagination', 'quadro'),
				'id' => $prefix . 'mod_magazine_pag',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Disabled', 'quadro' ), 'value' => 'disabled'),
					array('name' => esc_html__('Enabled', 'quadro' ), 'value' => 'enabled'),
				),
				'desc' => __('Applies only for layout 3 and 4.', 'quadro'),
				'std' => 'disabled',
			),
			array(
				'name' => esc_html__('Excerpt', 'indigo'),
				'id' => $prefix . 'mod_magazine_excerpt',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'indigo' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'indigo' ), 'value' => 'hide'),
				),
				'desc' => esc_html__('Applies only for layout 4.', 'indigo'),
				'std' => 'show'
			),
			array(
				'name' => esc_html__('Exclude Posts Without Thumbnail?', 'indigo'),
				'id' => $prefix . 'mod_magazine_nothumb',
				'type' => 'checkbox'
			),
			array(
				'name' => esc_html__('What to show?', 'indigo'),
				'id' => $prefix . 'mod_magazine_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Latest Posts', 'indigo' ), 'value' => 'all'),
					array('name' => esc_html__('By Categories', 'indigo' ), 'value' => 'tax'),
					array('name' => esc_html__('By Post Format', 'indigo' ), 'value' => 'format'),
					array('name' => esc_html__('Custom Selection', 'indigo' ), 'value' => 'custom'),
				),
				'std' => 'all'
			),
			array(
				'name' => esc_html__('Choose Categories to Show', 'indigo'),
				'id' => $prefix . 'mod_magazine_terms',
				'type' => 'tax_picker',
				'tax_slug' => 'category'
			),
			array(
				'name' => esc_html__('Choose Post Formats to Show', 'indigo'),
				'id' => $prefix . 'mod_magazine_formats',
				'type' => 'format_picker',
			),
			array(
				'name' => esc_html__('Choose Posts to Show', 'indigo'),
				'id' => $prefix . 'mod_pick_magazine',
				'type' => 'posts_picker',
				'post_type' => array( 'post' ),
				'show_type' => true
			),
			array(
				'name' => esc_html__('Posts Offset', 'indigo'),
				'id' => $prefix . 'mod_magazine_offset',
				'type' => 'number',
				'desc' => esc_html__(' Enter a number (optional). Use this option to pass over any amount of posts. Delete value to cancel.', 'indigo')
			),
			array(
				'name' => esc_html__('Exclude Posts', 'indigo'),
				'id' => $prefix . 'mod_magazine_exclude',
				'type' => 'text',
				'desc' => esc_html__('Enter IDs for excluded posts, separated by a comma. Using this setting disables \'-1\' setting for posts quantity.', 'indigo')
			),
		)
	),

	// Adding modules SLOGAN Type meta box
	'mod_slogan_type_metabox' => array(
		'id' => 'mod-slogan-qi-type-metabox',
		'title' => esc_html__('Slogan Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Slogan Text', 'indigo'),
				'id' => $prefix . 'mod_slogan_text',
				'type' => 'prev-editor'
			),
			array(
				'name' => esc_html__('Slogan Size', 'indigo'),
				'id' => $prefix . 'mod_slogan_size',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Giant', 'indigo' ), 'value' => 'giant'),
					array('name' => esc_html__('Regular', 'indigo' ), 'value' => 'regular'),
					),
				'std' => 'giant'
			),
			array(
				'name' => esc_html__('Content Align', 'indigo'),
				'id' => $prefix . 'mod_slogan_align',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Center', 'indigo' ), 'value' => 'center'),
					array('name' => esc_html__('Left', 'indigo' ), 'value' => 'left'),
					array('name' => esc_html__('Right', 'indigo' ), 'value' => 'right'),
					),
				'std' => 'center'
			),
			array(
				'name' => esc_html__('Use Gallery Slider as Background', 'indigo'),
				'id' => $prefix . 'mod_slogan_gallery',
				'type' => 'gallery'
			),
			array(
				'name' => esc_html__('Video Background', 'indigo'),
				'id' => $prefix . 'mod_slogan_video_back_subtitle',
				'type' => 'subtitle',
				'desc' => esc_html__('(It\'s advisable to upload more than one video format to prevent some browsers from not finding proper codecs.)', 'indigo'),
			),
			array(
				'name' => esc_html__('Video Background (MP4)', 'indigo'),
				'id' => $prefix . 'mod_slogan_video_mp4',
				'type' => 'upload'
			),
			array(
				'name' => esc_html__('Video Background (WEBM)', 'indigo'),
				'id' => $prefix . 'mod_slogan_video_webm',
				'type' => 'upload'
			),
			array(
				'name' => esc_html__('Video Background (OGV/THEORA)', 'indigo'),
				'id' => $prefix . 'mod_slogan_video_ogv',
				'type' => 'upload'
			),
			array(
				'name' => esc_html__('1st Button Properties', 'indigo'),
				'id' => $prefix . 'mod_slogan_1st_button_subtitle',
				'type' => 'subtitle'
			),
			array(
				'name' => esc_html__('Text', 'indigo'),
				'id' => $prefix . 'mod_slogan_action_text',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Link', 'indigo'),
				'id' => $prefix . 'mod_slogan_action_link',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Color', 'indigo'),
				'id' => $prefix . 'mod_slogan_action_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Background', 'indigo'),
				'id' => $prefix . 'mod_slogan_action_back',
				'type' => 'color',
				'desc' => esc_html__('Optional. Will be set by main color if not set.', 'indigo'),
				'std' => '#'
			),
			array(
				'name' => esc_html__('2nd Button Properties', 'indigo'),
				'id' => $prefix . 'mod_slogan_1st_button_subtitle',
				'type' => 'subtitle'
			),
			array(
				'name' => esc_html__('Text', 'indigo'),
				'id' => $prefix . 'mod_slogan_action2_text',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Link', 'indigo'),
				'id' => $prefix . 'mod_slogan_action2_link',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Color', 'indigo'),
				'id' => $prefix . 'mod_slogan_action2_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Background', 'indigo'),
				'id' => $prefix . 'mod_slogan_action2_back',
				'type' => 'color',
				'desc' => esc_html__('Optional. Will be set by main color if not set.', 'indigo'),
				'std' => '#'
			),
			array(
				'name' => esc_html__('Animation', 'indigo'),
				'id' => $prefix . 'mod_slogan_anim',
				'type' => 'select',
				'options' => qi_available_animations(),
				'desc' => '',
				'std' => 'none'
			),
			array(
				'name' => esc_html__('Animation Delay Between Elements (in ms.)', 'indigo'),
				'id' => $prefix . 'mod_slogan_anim_delay',
				'type' => 'number',
			),
		)
	),

	// Adding modules CALL TO ACTION Type meta box
	'mod_cta_type_metabox' => array(
		'id' => 'mod-cta-qi-type-metabox',
		'title' => esc_html__('Call to Action Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Call to Action Text', 'indigo'),
				'id' => $prefix . 'mod_cta_text',
				'type' => 'prev-editor'
			),
			array(
				'name' => esc_html__('Call to Action Size', 'indigo'),
				'id' => $prefix . 'mod_cta_size',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Small', 'indigo' ), 'value' => 'small'),
					array('name' => esc_html__('Regular', 'indigo' ), 'value' => 'regular'),
					),
				'std' => 'small'
			),
			array(
				'name' => esc_html__('Animation', 'indigo'),
				'id' => $prefix . 'mod_cta_anim',
				'type' => 'select',
				'options' => qi_available_animations(),
				'desc' => '',
				'std' => 'none'
			),
			array(
				'name' => esc_html__('Animation Delay Between Elements (in ms.)', 'indigo'),
				'id' => $prefix . 'mod_cta_anim_delay',
				'type' => 'number',
			),
			array(
				'name' => esc_html__('Button Properties', 'indigo'),
				'id' => $prefix . 'mod_cta_button_subtitle',
				'type' => 'subtitle'
			),
			array(
				'name' => esc_html__('Text', 'indigo'),
				'id' => $prefix . 'mod_cta_action_text',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Link', 'indigo'),
				'id' => $prefix . 'mod_cta_action_link',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Color', 'indigo'),
				'id' => $prefix . 'mod_cta_action_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Background', 'indigo'),
				'id' => $prefix . 'mod_cta_action_back',
				'type' => 'color',
				'desc' => esc_html__('Optional. Will be set by main color if not set.', 'indigo'),
				'std' => '#'
			),
		)
	),

	// Adding modules INFO BOX Type meta box
	'mod_ibox_type_metabox' => array(
		'id' => 'mod-ibox-qi-type-metabox',
		'title' => esc_html__('Info Box Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Box Title', 'indigo'),
				'id' => $prefix . 'mod_ibox_title',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Box Text', 'indigo'),
				'id' => $prefix . 'mod_ibox_text',
				'type' => 'prev-editor'
			),
			array(
				'name' => esc_html__('Box Icon', 'indigo'),
				'id' => $prefix . 'mod_ibox_icon',
				'type' => 'icon_extended'
			),
			array(
				'name' => esc_html__('Button Properties', 'indigo'),
				'id' => $prefix . 'mod_ibox_1st_button_subtitle',
				'type' => 'subtitle'
			),
			array(
				'name' => esc_html__('Text', 'indigo'),
				'id' => $prefix . 'mod_ibox_button_text',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Link', 'indigo'),
				'id' => $prefix . 'mod_ibox_button_link',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Color', 'indigo'),
				'id' => $prefix . 'mod_ibox_button_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Background', 'indigo'),
				'id' => $prefix . 'mod_ibox_button_back',
				'type' => 'color',
				'desc' => esc_html__('Optional. Will be set by main color if not set.', 'indigo'),
				'std' => '#'
			),
			array(
				'name' => esc_html__('Box Settings', 'indigo'),
				'id' => $prefix . 'mod_ibox_settings_subtitle',
				'type' => 'subtitle'
			),
			array(
				'name' => esc_html__('Box Position', 'indigo'),
				'id' => $prefix . 'mod_ibox_position',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Center', 'indigo' ), 'value' => 'center'),
					array('name' => esc_html__('Left', 'indigo' ), 'value' => 'left'),
					array('name' => esc_html__('Right', 'indigo' ), 'value' => 'right'),
					),
				'std' => 'center'
			),
			array(
				'name' => esc_html__('Box Background Color', 'indigo'),
				'id' => $prefix . 'mod_ibox_background',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Box Text Color', 'indigo'),
				'id' => $prefix . 'mod_ibox_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Animation', 'indigo'),
				'id' => $prefix . 'mod_ibox_anim',
				'type' => 'select',
				'options' => qi_available_animations(),
				'desc' => '',
				'std' => 'none'
			),
		)
	),

	// Adding modules VIDEO & EMBEDS Type meta box
	'mod_video_type_metabox' => array(
		'id' => 'mod-video-qi-type-metabox',
		'title' => esc_html__('Video Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Embed URL', 'indigo'),
				'id' => $prefix . 'mod_video_url',
				'type' => 'text',
				'desc' => esc_html__(' Enter a YouTube, Vimeo, Wistia, Spotify or any other embed URL supported by', 'indigo') . ' <a href="https://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">oEmbed</a>.'
			),
			array(
				'name' => esc_html__('Embed Layout', 'indigo'),
				'id' => $prefix . 'mod_video_layout',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('With margins', 'indigo' ), 'value' => 'margin'),
					array('name' => esc_html__('No margins', 'indigo' ), 'value' => 'full'),
					),
				'std' => 'margin'
			),
			array(
				'name' => esc_html__('Embed Width', 'indigo'),
				'id' => $prefix . 'mod_video_width',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Regular', 'indigo' ), 'value' => 'regular'),
					array('name' => esc_html__('Giant', 'indigo' ), 'value' => 'giant'),
					array('name' => esc_html__('Small', 'indigo' ), 'value' => 'small'),
					),
				'std' => 'regular'
			),
		)
	),

	// Adding modules FEATURED Type meta box
	'mod_featured_type_metabox' => array(
		'id' => 'mod-featured-qi-type-metabox',
		'title' => esc_html__('Featured Post Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('What to show?', 'indigo'),
				'id' => $prefix . 'mod_featured_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Custom Selection', 'indigo' ), 'value' => 'custom'),
					array('name' => esc_html__('Last post (from all posts)', 'indigo' ), 'value' => 'all'),
					array('name' => esc_html__('Last post By Categories', 'indigo' ), 'value' => 'tax'),
					array('name' => esc_html__('Last post By Post Format', 'indigo' ), 'value' => 'format'),
				),
				'std' => 'custom'
			),
			array(
				'name' => esc_html__('Choose Categories to Show', 'indigo'),
				'id' => $prefix . 'mod_featured_terms',
				'type' => 'tax_picker',
				'tax_slug' => 'category'
			),
			array(
				'name' => esc_html__('Choose Post Formats to Show', 'indigo'),
				'id' => $prefix . 'mod_featured_formats',
				'type' => 'format_picker',
			),
			array(
				'name' => esc_html__('Choose Post to Show', 'indigo'),
				'id' => $prefix . 'mod_pick_featured',
				'type' => 'one_post_picker',
				'post_type' => array( 'post', 'quadro_portfolio' )
			),
			array(
				'name' => esc_html__('Posts Offset', 'indigo'),
				'id' => $prefix . 'mod_featured_offset',
				'type' => 'number',
				'desc' => esc_html__(' Enter a number (optional). Use this option to pass over any amount of posts. Delete value to cancel.', 'indigo')
			),
			array(
				'name' => esc_html__('Exclude Posts', 'indigo'),
				'id' => $prefix . 'mod_featured_exclude',
				'type' => 'text',
				'desc' => esc_html__('Enter IDs for excluded posts, separated by a comma.', 'indigo')
			),
			array(
				'name' => esc_html__('Select Featured Post Style', 'indigo'),
				'id' => $prefix . 'mod_featured_style',
				'type' => 'radio',
				'options' => array(
					array('name' => esc_html__('Content on right side', 'indigo' ), 'value' => 'type1'),
					array('name' => esc_html__('Content on left side', 'indigo' ), 'value' => 'type2')
					),
				'desc' => wp_kses_post( __( 'Note: To display featured posts <strong>large thumbnail</strong> size must be set on WordPress defaults of 1024 by 1024 pixels.', 'indigo' ) ),
				'std' => 'type1'
			),
			array(
				'name' => esc_html__('Post Date', 'indigo'),
				'id' => $prefix . 'mod_featured_date',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'indigo' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'indigo' ), 'value' => 'hide'),
				),
				'std' => 'show'
			),
			array(
				'name' => esc_html__('Post Categories', 'indigo'),
				'id' => $prefix . 'mod_featured_cats',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'indigo' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'indigo' ), 'value' => 'hide'),
				),
				'std' => 'show'
			),
		)
	),

	// Adding modules PORTFOLIO Type meta box
	'mod_portfolio_type_metabox' => array(
		'id' => 'mod-portfolio-qi-type-metabox',
		'title' => esc_html__('Portfolio Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Portfolio Style', 'indigo'),
				'id' => $prefix . 'mod_portfolio_style',
				'type' => 'layout-picker',
				'path' => '/images/admin/portfolio-styles/',
				'options' => array(
					'masonry' => array(
						'name' => 'masonry',
						'title' => esc_html__( 'Masonry Portfolio', 'indigo' ),
						'img' => 'portfolio-masonry.png',
						'description' => '',
					),
					'grid' => array(
						'name' => 'grid',
						'title' => esc_html__( 'Perfect Grid Portfolio', 'indigo' ),
						'img' => 'portfolio-grid.png',
						'description' => '',
					),
					'grid2' => array(
						'name' => 'grid2',
						'title' => esc_html__( 'Mosaic Portfolio', 'indigo' ),
						'img' => 'portfolio-mosaic.png',
						'description' => '',
					),
				),
				'desc' => '',
				'std' => 'masonry'
			),
			array(
				'name' => esc_html__('Layout', 'indigo'),
				'id' => $prefix . 'mod_portfolio_layout',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Full Width, no margins', 'indigo' ), 'value' => 'full'),
					array('name' => esc_html__('Regular Width, with margins', 'indigo' ), 'value' => 'margin'),
					),
				'std' => 'ajax'
			),
			array(
				'name' => esc_html__('Select Columns', 'indigo'),
				'id' => $prefix . 'mod_portfolio_columns',
				'type' => 'radio',
				'options' => array(
					array('name' => esc_html__('Two Columns', 'indigo' ), 'value' => 'two'),
					array('name' => esc_html__('Three Columns', 'indigo' ), 'value' => 'three'),
					array('name' => esc_html__('Four Columns', 'indigo' ), 'value' => 'four'),
					),
				'std' => 'three'
			),
			array(
				'name' => esc_html__('Loading Method', 'indigo'),
				'id' => $prefix . 'mod_portfolio_loading',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Ajax', 'indigo' ), 'value' => 'ajax'),
					array('name' => esc_html__('No Ajax', 'indigo' ), 'value' => 'noajax'),
					),
				'std' => 'ajax'
			),
			array(
				'name' => esc_html__('Reveal Info by Default', 'indigo'),
				'id' => $prefix . 'mod_portfolio_show_data',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'indigo' ), 'value' => 'show'),
					array('name' => esc_html__('Reveal on Hover', 'indigo' ), 'value' => 'hover'),
					array('name' => esc_html__('Hide', 'indigo' ), 'value' => 'hide'),
					),
				'std' => 'show'
			),
			array(
				'name' => esc_html__('Categories Filter', 'indigo'),
				'id' => $prefix . 'mod_portfolio_filter',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'indigo' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'indigo' ), 'value' => 'hide')
					),
				'std' => 'show'
			),
			array(
				'name' => esc_html__('Filter by', 'indigo'),
				'id' => $prefix . 'mod_portfolio_filter_terms',
				'type' => 'tax_picker_permanent',
				'tax_slug' => 'portfolio_tax'
			),
			array(
				'name' => esc_html__('Items per page', 'indigo'),
				'id' => $prefix . 'mod_portfolio_perpage',
				'type' => 'text',
				'desc' => esc_html__('Enter -1 to show all items in one page.', 'indigo')
			),
			array(
				'name' => esc_html__('Navigation', 'indigo'),
				'id' => $prefix . 'mod_portfolio_show_nav',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'indigo' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'indigo' ), 'value' => 'hide'),
				),
				'std' => 'show'
			),
			array(
				'name' => esc_html__('Portfolio Items', 'indigo'),
				'id' => $prefix . 'mod_portfolio_method_subtitle',
				'type' => 'subtitle',
			),
			array(
				'name' => esc_html__('What to show?', 'indigo'),
				'id' => $prefix . 'mod_portfolio_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('All Items', 'indigo' ), 'value' => 'all'),
					array('name' => esc_html__('By Categories', 'indigo' ), 'value' => 'tax'),
					array('name' => esc_html__('Custom Selection', 'indigo' ), 'value' => 'custom'),
				),
				'std' => 'all'
			),
			array(
				'name' => esc_html__('Choose Categories to Show', 'indigo'),
				'id' => $prefix . 'mod_portfolio_terms',
				'type' => 'tax_picker',
				'tax_slug' => 'portfolio_tax'
			),
			array(
				'name' => esc_html__('Choose Items to Show', 'indigo'),
				'id' => $prefix . 'mod_portfolio_picker',
				'type' => 'posts_picker',
				'post_type' => array( 'quadro_portfolio' ),
				'show_type' => false
			),
			array(
				'name' => esc_html__('Order Items by', 'indigo'),
				'id' => $prefix . 'mod_portfolio_orderby',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Date', 'indigo' ), 'value' => 'post_date'),
					array('name' => esc_html__('Title', 'indigo' ), 'value' => 'title'),
					array('name' => esc_html__('Menu Order', 'quadro' ), 'value' => 'menu_order'),
				),
				'desc' => esc_html__( 'Note: this setting won\'t work for "Custom Selection" method.', 'indigo' ),
				'std' => 'date'
			),
			array(
				'name' => esc_html__('Order', 'indigo'),
				'id' => $prefix . 'mod_portfolio_order',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Descendant (newer first, if by date)', 'indigo' ), 'value' => 'DESC'),
					array('name' => esc_html__('Ascendant (older first, if by date)', 'indigo' ), 'value' => 'ASC')
				),
				'desc' => esc_html__( 'Note: this setting won\'t work for "Custom Selection" method.', 'indigo' ),
				'std' => 'DESC'
			),
		)
	),

	// Adding modules PRICING TABLES Type meta box
	'mod_pr_tables_type_metabox' => array(
		'id' => 'mod-pr-tables-qi-type-metabox',
		'title' => esc_html__('Pricing Tables Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Animation', 'indigo'),
				'id' => $prefix . 'mod_pr_tables_anim',
				'type' => 'select',
				'options' => qi_available_animations(),
				'desc' => '',
				'std' => 'none'
			),
			array(
				'name' => esc_html__('Animation Delay Between Elements (in ms.)', 'indigo'),
				'id' => $prefix . 'mod_pr_tables_anim_delay',
				'type' => 'number',
			),
			array(
                'name' => esc_html__('', 'indigo'),
                'id' => $prefix . 'mod_pr_tables_plans',
                'type' => 'repeatable',
                'desc' => esc_html__('Add as many Plans as you want (5 plans maximum), one at a time. Drag to reorder.', 'indigo'),
                'item-name' => esc_html__('Plan', 'indigo'),
                'repeat-fields' => array(
                	'highlight' => array( 'name' => 'highlight', 'title' => 'Plan Highlight', 'type' => 'text' ),
                	'title' => array( 'name' => 'title', 'title' => 'Plan Title', 'type' => 'text' ),
                	'description' => array( 'name' => 'description', 'title' => 'Short Description', 'type' => 'textarea' ),
                	'price' => array( 'name' => 'price', 'title' => 'Price', 'type' => 'text' ),
                	'price_term' => array( 'name' => 'price_term', 'title' => 'Price Term (e.g. /month)', 'type' => 'text' ),
                	'price_subtext' => array( 'name' => 'price_subtext', 'title' => 'Price Subtext', 'type' => 'text' ),
                	'features' => array( 'name' => 'features', 'title' => 'Plan Features', 'type' => 'textarea', 'desc' => esc_html__( 'One feature per line. Begin each line with "*!"', 'indigo' ) ),
                	'button_url' => array( 'name' => 'button_url', 'title' => 'Button URL', 'type' => 'text' ),
                	'button_text' => array( 'name' => 'button_text', 'title' => 'Button Text', 'type' => 'text' ),
                	'feat' => array( 'name' => 'feat', 'title' => 'Is This a Featured Plan?', 'type' => 'checkbox' ),
                	'color' => array( 'name' => 'color', 'title' => 'Plan Color', 'type' => 'color' ),
                	'icon' => array( 'name' => 'icon', 'title' => 'Icon', 'type' => 'icon_extended' ),
                ),
                'repeat-item' => esc_html__('Add another Plan', 'indigo')
            ),
		)
	),

	// Adding modules GALLERY Type meta box
	'mod_gallery_type_metabox' => array(
		'id' => 'mod-gallery-qi-type-metabox',
		'title' => esc_html__('Gallery Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Create Gallery', 'indigo'),
				'id' => $prefix . 'mod_gallery_gallery',
				'type' => 'gallery'
			),
			array(
				'name' => esc_html__('Gallery Style', 'indigo'),
				'id' => $prefix . 'mod_gallery_style',
				'type' => 'layout-picker',
				'path' => '/images/admin/gallery-styles/',
				'options' => array(
					'mosaic' => array(
						'name' => 'mosaic',
						'title' => esc_html__( 'Mosaic', 'indigo' ),
						'img' => 'gallery-mosaic.png',
						'description' => '',
					),
					'masonry' => array(
						'name' => 'masonry',
						'title' => esc_html__( 'Masonry', 'indigo' ),
						'img' => 'gallery-masonry.png',
						'description' => '',
					),
					'grid' => array(
						'name' => 'grid',
						'title' => esc_html__( 'Perfect Grid', 'indigo' ),
						'img' => 'gallery-grid.png',
						'description' => '',
					),
				),
				'desc' => '',
				'std' => 'mosaic'
			),
			array(
				'name' => esc_html__('Gallery Layout', 'indigo'),
				'id' => $prefix . 'mod_gallery_layout',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Layout 1', 'indigo' ), 'value' => 'layout1'),
					array('name' => esc_html__('Layout 2', 'indigo' ), 'value' => 'layout2'),
					array('name' => esc_html__('Layout 3', 'indigo' ), 'value' => 'layout3'),
					array('name' => esc_html__('Layout 4', 'indigo' ), 'value' => 'layout4'),
					array('name' => esc_html__('Layout 5', 'indigo' ), 'value' => 'layout5'),
					array('name' => esc_html__('Layout 6', 'indigo' ), 'value' => 'layout6'),
					array('name' => esc_html__('Layout 7', 'indigo' ), 'value' => 'layout7'),
					array('name' => esc_html__('Layout 8', 'indigo' ), 'value' => 'layout8'),
					),
				'desc' => esc_html__('Each option represents a different layout from the style you\'ve chosen above. Combine Style and Layout to build the gallery you want.', 'indigo'),
				'std' => 'layout1'
			),
			array(
				'name' => esc_html__('Margins', 'indigo'),
				'id' => $prefix . 'mod_gallery_margins',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Without Margins', 'indigo' ), 'value' => 'false'),
					array('name' => esc_html__('With Margins', 'indigo' ), 'value' => 'true')
					),
				'std' => 'false'
			),
			array(
				'name' => esc_html__('Gallery Captions', 'indigo'),
				'id' => $prefix . 'mod_gallery_captions',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show on Hover', 'indigo' ), 'value' => 'hover'),
					array('name' => esc_html__('Always Visible', 'indigo' ), 'value' => 'visible'),
					),
				'std' => 'hover'
			),
			array(
				'name' => esc_html__('Open In Lightbox', 'indigo'),
				'id' => $prefix . 'mod_gallery_lightbox',
				'desc' => esc_html__('(Needs Responsive Lightbox plugin installed.)', 'indigo'),
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Enabled', 'indigo' ), 'value' => 'enabled'),
					array('name' => esc_html__('Disabled', 'indigo' ), 'value' => 'disabled'),
					),
				'std' => 'enabled'
			),
		)
	),

	// Adding modules SERVICES Type meta box
	'mod_services_type_metabox' => array(
		'id' => 'mod-services-qi-type-metabox',
		'title' => esc_html__('Services Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Services Layout', 'indigo'),
				'id' => $prefix . 'mod_services_layout',
				'type' => 'layout-picker',
				'path' => '/images/admin/service-layouts/',
				'options' => array(
					'type1' => array(
						'name' => 'type1',
						'title' => esc_html__( 'Layout 1', 'indigo' ),
						'img' => 'service-layout1.png',
						'description' => '',
					),
					'type2' => array(
						'name' => 'type2',
						'title' => esc_html__( 'Layout 2', 'indigo' ),
						'img' => 'service-layout2.png',
						'description' => '',
					),
					'type3' => array(
						'name' => 'type3',
						'title' => esc_html__( 'Layout 3', 'indigo' ),
						'img' => 'service-layout3.png',
						'description' => '',
					),
				),
				'desc' => '',
				'std' => 'type1'
			),
			array(
				'name' => esc_html__('Columns', 'indigo'),
				'id' => $prefix . 'mod_services_columns',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('One', 'indigo' ), 'value' => 'one'),
					array('name' => esc_html__('Two', 'indigo' ), 'value' => 'two'),
					array('name' => esc_html__('Three', 'indigo' ), 'value' => 'three'),
					array('name' => esc_html__('Four', 'indigo' ), 'value' => 'four')
					),
				'std' => 'three'
			),
			array(
				'name' => esc_html__('Show for Services', 'indigo'),
				'id' => $prefix . 'mod_services_show',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Icon', 'indigo' ), 'value' => 'icon'),
					array('name' => esc_html__('Image', 'indigo' ), 'value' => 'image'),
					array('name' => esc_html__('None', 'indigo' ), 'value' => 'none'),
					),
				'std' => 'icon'
			),
			array(
				'name' => esc_html__('Text Color', 'indigo'),
				'id' => $prefix . 'mod_services_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Icons Color', 'indigo'),
				'id' => $prefix . 'mod_services_icolor',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Animation', 'indigo'),
				'id' => $prefix . 'mod_services_anim',
				'type' => 'select',
				'options' => qi_available_animations(),
				'desc' => '',
				'std' => 'none'
			),
			array(
				'name' => esc_html__('Animation Delay Between Elements (in ms.)', 'indigo'),
				'id' => $prefix . 'mod_services_anim_delay',
				'type' => 'number',
			),
			array(
                'name' => esc_html__('', 'indigo'),
                'id' => $prefix . 'mod_services_services',
                'type' => 'repeatable',
                'desc' => esc_html__('Add as many services as you want, one at a time. Drag to reorder.', 'indigo'),
                'item-name' => esc_html__('Service', 'indigo'),
                'repeat-fields' => array(
                	'title' => array( 'name' => 'title', 'title' => 'Title', 'type' => 'text' ),
                	'content' => array( 'name' => 'content', 'title' => 'Content', 'type' => 'textarea' ),
                	'link_url' => array( 'name' => 'link_url', 'title' => 'Link (URL)', 'type' => 'text' ),
                	'link_text' => array( 'name' => 'link_text', 'title' => 'Link Text', 'type' => 'text' ),
                	'icon' => array( 'name' => 'icon', 'title' => 'Icon', 'type' => 'icon_extended' ),
                	'img' => array( 'name' => 'img', 'title' => 'Image File', 'type' => 'upload' ),
                ),
                'repeat-item' => esc_html__('Add another Service', 'indigo')
            ),
		)
	),

	// Adding modules SLIDABLE INSIGHTS Type meta box
	'mod_sl_insights_type_metabox' => array(
		'id' => 'mod-sl-insights-qi-type-metabox',
		'title' => esc_html__('Slidable Insights Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Navigation Style', 'indigo'),
				'id' => $prefix . 'mod_sl_insights_nav',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Numbered', 'indigo' ), 'value' => 'numbered'),
					array('name' => esc_html__('Arrows', 'indigo' ), 'value' => 'arrows'),
					),
				'std' => 'numbered'
			),
			array(
				'name' => esc_html__('Text Color', 'indigo'),
				'id' => $prefix . 'mod_sl_insights_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Animation', 'indigo'),
				'id' => $prefix . 'mod_sl_insights_anim',
				'type' => 'select',
				'options' => qi_available_animations(),
				'desc' => '',
				'std' => 'none'
			),
			array(
				'name' => esc_html__('Animation Delay Between Elements (in ms.)', 'indigo'),
				'id' => $prefix . 'mod_sl_insights_anim_delay',
				'type' => 'number',
			),
			array(
                'name' => esc_html__('Slidable Insights', 'indigo'),
                'id' => $prefix . 'mod_sl_insights',
                'type' => 'repeatable',
                'desc' => esc_html__('Add as many Showcase as you want, one at a time.', 'indigo'),
                'repeat-fields' => array(
                	'title' => array( 'name' => 'title', 'title' => 'Title', 'type' => 'text' ),
                	'content' => array( 'name' => 'content', 'title' => 'Content', 'type' => 'textarea' ),
                	'img' => array( 'name' => 'img', 'title' => 'Image', 'type' => 'upload' ),
                	'button_text' => array( 'name' => 'button_text', 'title' => 'Button Text', 'type' => 'text' ),
                	'button_url' => array( 'name' => 'button_url', 'title' => 'Button Link', 'type' => 'text' ),
                	'layout' => array( 
                		'name' => 'layout', 
                		'title' => 'Layout', 
                		'type' => 'layout-picker',
                		'path' => '/images/admin/insight-layouts/',
                		'std' => 'layout1',
                		'options' => array(
							'layout1' => array(
								'name' => 'layout1',
								'title' => esc_html__( 'Layout 1', 'indigo' ),
								'img' => 'insight-layout1.png',
								'description' => '',
							),
							'layout2' => array(
								'name' => 'layout2',
								'title' => esc_html__( 'Layout 2', 'indigo' ),
								'img' => 'insight-layout2.png',
								'description' => '',
							),
							'layout3' => array(
								'name' => 'layout3',
								'title' => esc_html__( 'Layout 3', 'indigo' ),
								'img' => 'insight-layout3.png',
								'description' => '',
							),
							'layout4' => array(
								'name' => 'layout4',
								'title' => esc_html__( 'Layout 4', 'indigo' ),
								'img' => 'insight-layout4.png',
								'description' => '',
							),
						),
                	),
                ),
                'item-name' => esc_html__('Insight', 'indigo'),
                'repeat-item' => esc_html__('Add another Insight', 'indigo'),
            ),
		)
	),

	// Adding modules TEAM Type meta box
	'mod_team_type_metabox' => array(
		'id' => 'mod-team-qi-type-metabox',
		'title' => esc_html__('Team Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Select Style', 'indigo'),
				'id' => $prefix . 'mod_team_style',
				'type' => 'radio',
				'options' => array(
					array('name' => esc_html__('Two Columns', 'indigo' ), 'value' => 'type1'),
					array('name' => esc_html__('Three Columns', 'indigo' ), 'value' => 'type2'),
					array('name' => esc_html__('Four Columns', 'indigo' ), 'value' => 'type3'),
					),
				'std' => 'type1'
			),
			array(
                'name' => esc_html__('Team Members', 'indigo'),
                'id' => $prefix . 'mod_team_content',
                'type' => 'repeatable',
                'desc' => esc_html__('Add as many team members as you want, one at a time.', 'indigo') . '<br />' . esc_html__('Define which social networks you\'d like to enable in the USER CONTACT METHODS section at', 'indigo') . ' <a href="' . esc_url( admin_url( 'themes.php?page=quadro-settings&tab=social' ) ) . '">' . esc_html__( 'Theme Options >> Social Tab', 'indigo' ) . '</a>.',
                'item-name' => esc_html__('Team Member', 'indigo'),
                'repeat-fields' => array(
                	'name' => array( 'name' => 'name', 'title' => 'Name', 'type' => 'text' ),
                	'role' => array( 'name' => 'role', 'title' => 'Role', 'type' => 'text' ),
                	'link' => array( 'name' => 'link', 'title' => 'Link', 'type' => 'text' ),
                	'content' => array( 'name' => 'content', 'title' => 'Content', 'type' => 'textarea' ),
                	'img' => array( 'name' => 'img', 'title' => 'Photo', 'type' => 'upload' ),
                	'social' => array( 'name' => 'social', 'title' => 'Social Networks', 'type' => 'social-flex' ),
                ),
                'repeat-item' => esc_html__('Add another Team member', 'indigo')
            ),
		)
	),

	// Adding modules TESTIMONIALS Type meta box
	'mod_testimonials_type_metabox' => array(
		'id' => 'mod-testimonials-qi-type-metabox',
		'title' => esc_html__('Testimonials Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Select Style', 'indigo'),
				'id' => $prefix . 'mod_testimonial_style',
				'type' => 'radio',
				'options' => array(
					array('name' => esc_html__('Slider', 'indigo' ), 'value' => 'type1'),
					array('name' => esc_html__('One Column', 'indigo' ), 'value' => 'type4'),
					array('name' => esc_html__('Two Columns', 'indigo' ), 'value' => 'type2'),
				),
				'std' => 'type1'
			),
			array(
				'name' => esc_html__('Background Style', 'indigo'),
				'id' => $prefix . 'mod_testimonial_back_style',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Solid Color', 'indigo' ), 'value' => 'solid'),
					array('name' => esc_html__('Transparent', 'indigo' ), 'value' => 'transp'),
				),
				'std' => 'solid'
			),
			array(
				'name' => esc_html__('Background Color (optional)', 'indigo'),
				'id' => $prefix . 'mod_testimonial_back',
				'type' => 'color',
				'std' => '#'
			),
			array(
				'name' => esc_html__('Text Color (optional)', 'indigo'),
				'id' => $prefix . 'mod_testimonial_color',
				'type' => 'color',
				'std' => '#'
			),
			array(
                'name' => esc_html__('', 'indigo'),
                'id' => $prefix . 'mod_testimonial_content',
                'type' => 'repeatable',
                'desc' => esc_html__('Add as many testimonials as you want, one at a time.', 'indigo'),
                'item-name' => esc_html__('Testimonial', 'indigo'),
                'repeat-fields' => array(
                	'content' => array( 'name' => 'content', 'title' => 'Content', 'type' => 'textarea' ),
                	'author' => array( 'name' => 'author', 'title' => 'Author', 'type' => 'text' ),
                	'subtitle' => array( 'name' => 'subtitle', 'title' => 'Subtitle', 'type' => 'text' ),
                	'link' => array( 'name' => 'link', 'title' => 'Link', 'type' => 'text' ),
                	'img' => array( 'name' => 'img', 'title' => 'Photo', 'type' => 'upload' ),
                ),
                'repeat-item' => esc_html__('Add another Testimonial', 'indigo')
            ),
		)
	),

	// Adding modules VIDEO POSTS Type meta box
	'mod_videoposts_type_metabox' => array(
		'id' => 'mod-videoposts-qi-type-metabox',
		'title' => esc_html__('Video Posts Slider Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('How many posts to show?', 'indigo'),
				'id' => $prefix . 'mod_videoposts_pper',
				'type' => 'text',
				'std' => '',
				'desc' => esc_html__('Enter -1 to show all posts.', 'indigo')
			),
			array(
				'name' => esc_html__('What to show?', 'indigo'),
				'id' => $prefix . 'mod_videoposts_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('All Posts', 'indigo' ), 'value' => 'all'),
					array('name' => esc_html__('By Categories', 'indigo' ), 'value' => 'tax'),
					array('name' => esc_html__('Custom Selection', 'indigo' ), 'value' => 'custom'),
				),
				'std' => 'all'
			),
			array(
				'name' => esc_html__('Choose Categories to Show', 'indigo'),
				'id' => $prefix . 'mod_videoposts_terms',
				'type' => 'tax_picker',
				'tax_slug' => 'category'
			),
			array(
				'name' => esc_html__('Choose Posts to Show', 'indigo'),
				'id' => $prefix . 'mod_pick_videoposts',
				'type' => 'posts_picker',
				'post_type' => array( 'post' ),
				'post_format' => array( 'video' ),
				'show_type' => false
			),
			array(
				'name' => esc_html__('Posts Offset', 'indigo'),
				'id' => $prefix . 'mod_videoposts_offset',
				'type' => 'number',
				'desc' => esc_html__(' Enter a number (optional). Use this option to pass over any amount of posts. Delete value to cancel.', 'indigo')
			),
			array(
				'name' => esc_html__('Exclude Posts', 'indigo'),
				'id' => $prefix . 'mod_videoposts_exclude',
				'type' => 'text',
				'desc' => esc_html__('Enter IDs for excluded posts, separated by a comma.', 'indigo')
			),
			array(
				'name' => esc_html__('Text Color (optional)', 'indigo'),
				'id' => $prefix . 'mod_videoposts_color',
				'type' => 'color',
				'std' => '#'
			),
		)
	),

	// Adding modules SLIDER Type meta box
	'mod_slider_type_metabox' => array(
		'id' => 'mod-slider-qi-type-metabox',
		'title' => esc_html__('Slider Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
                'name' => esc_html__('', 'indigo'),
                'id' => $prefix . 'mod_slider_slides',
                'type' => 'repeatable',
                'desc' => wp_kses_post( __('Add as many slides as you want, one at a time. Drag to reorder.<br /><strong>Note</strong>: editors turn into regular textareas when sorting them or adding new ones. Update or publish to re-enable.', 'indigo') ),
                'item-name' => esc_html__('Slide', 'indigo'),
                'repeat-fields' => array(
                	'content' => array( 'name' => 'content', 'title' => 'Content', 'type' => 'editor' ),
                	'align' => array( 'name' => 'align', 'title' => 'Content Align', 'type' => 'select',
                	'options' => array(
						array('name' => esc_html__('Center', 'indigo' ), 'value' => 'center'),
						array('name' => esc_html__('Left', 'indigo' ), 'value' => 'left'),
						array('name' => esc_html__('Right', 'indigo' ), 'value' => 'right'),
					) ),
                	'link_url' => array( 'name' => 'link_url', 'title' => 'Button URL', 'type' => 'text' ),
                	'link_text' => array( 'name' => 'link_text', 'title' => 'Button Text', 'type' => 'text' ),
                	'img' => array( 'name' => 'img', 'title' => 'Image File', 'type' => 'upload' ),
                ),
                'repeat-item' => esc_html__('Add another Slide', 'indigo')
            ),
			array(
				'name' => esc_html__('Margins', 'indigo'),
				'id' => $prefix . 'mod_slider_margins',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Disable', 'indigo' ), 'value' => 'disable'),
					array('name' => esc_html__('Enable', 'indigo' ), 'value' => 'enable'),
				),
				'std' => 'disable'
			),
			array(
				'name' => esc_html__('Transition Timer (in millisecs.)', 'indigo'),
				'id' => $prefix . 'mod_slider_time',
				'type' => 'number'
			),
			array(
				'name' => esc_html__('Slider Height', 'indigo'),
				'id' => $prefix . 'mod_slider_height',
				'type' => 'text',
				'desc' => wp_kses_post( __(' Enter a number and its unit in pixels (e.g. <strong>500px</strong>) or <strong>100vh</strong> to make it full-height (optional).', 'indigo') )
			),
		)
	),

	// Adding modules POSTS SLIDER Type meta box
	'mod_pslider_type_metabox' => array(
		'id' => 'mod-pslider-qi-type-metabox',
		'title' => esc_html__('Posts Slider Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Select Caption Position', 'indigo'),
				'id' => $prefix . 'mod_pslider_caption_pos',
				'type' => 'radio',
				'options' => array(
					array('name' => esc_html__('Center', 'indigo' ), 'value' => 'center'),
					array('name' => esc_html__('Left', 'indigo' ), 'value' => 'left'),
					array('name' => esc_html__('Right', 'indigo' ), 'value' => 'right'),
					array('name' => esc_html__('Left & Right (alternated)', 'indigo' ), 'value' => 'alternated'),
					),
				'desc' => '',
				'std' => 'center'
			),
			array(
				'name' => esc_html__('Transition Timer (in millisecs.)', 'indigo'),
				'id' => $prefix . 'mod_pslider_time',
				'type' => 'text',
				'desc' => wp_kses_post( __('Enter <strong>stop</strong> to disable autorun.', 'indigo') )
			),
			array(
				'name' => esc_html__('What to show?', 'indigo'),
				'id' => $prefix . 'mod_pslider_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Custom Selection', 'indigo' ), 'value' => 'custom'),
					array('name' => esc_html__('Latest posts (from all posts)', 'indigo' ), 'value' => 'all'),
					array('name' => esc_html__('Latest posts By Categories', 'indigo' ), 'value' => 'tax'),
					array('name' => esc_html__('Latest posts By Post Format', 'indigo' ), 'value' => 'format'),
				),
				'std' => 'custom'
			),
			array(
				'name' => esc_html__('Choose Categories to Show', 'indigo'),
				'id' => $prefix . 'mod_pslider_terms',
				'type' => 'tax_picker',
				'tax_slug' => 'category'
			),
			array(
				'name' => esc_html__('Choose Post Formats to Show', 'indigo'),
				'id' => $prefix . 'mod_pslider_formats',
				'type' => 'format_picker',
			),
			array(
				'name' => esc_html__('Choose Posts to Show', 'indigo'),
				'id' => $prefix . 'mod_pick_pslider',
				'type' => 'posts_picker',
				'post_type' => array( 'post', 'quadro_portfolio' ),
				'show_type' => false
			),
			array(
				'name' => esc_html__('How many posts to show?', 'indigo'),
				'id' => $prefix . 'mod_pslider_pper',
				'type' => 'text',
				'std' => '',
			),
			array(
				'name' => esc_html__('Posts Offset', 'indigo'),
				'id' => $prefix . 'mod_pslider_offset',
				'type' => 'number',
				'desc' => esc_html__(' Enter a number (optional). Use this option to pass over any amount of posts. Delete value to cancel.', 'indigo')
			),
			array(
				'name' => esc_html__('Exclude Posts', 'indigo'),
				'id' => $prefix . 'mod_pslider_exclude',
				'type' => 'text',
				'desc' => esc_html__('Enter IDs for excluded posts, separated by a comma.', 'indigo')
			),
			array(
				'name' => esc_html__('Margins (make full width)', 'indigo'),
				'id' => $prefix . 'mod_pslider_margins',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('With Margins', 'indigo' ), 'value' => 'with-margins'),
					array('name' => esc_html__('Without Margins', 'indigo' ), 'value' => 'no-margins'),
				),
				'std' => 'with-margins'
			),
		)
	),

	// Adding modules AUTHORS Type meta box
	'mod_authors_type_metabox' => array(
		'id' => 'mod-authors-qi-type-metabox',
		'title' => esc_html__('Authors Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('What to show?', 'indigo'),
				'id' => $prefix . 'mod_authors_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Custom Selection', 'indigo' ), 'value' => 'custom'),
					array('name' => esc_html__('All Authors', 'indigo' ), 'value' => 'all'),
				),
				'std' => 'custom'
			),
			array(
				'name' => esc_html__('Choose Authors to Show', 'indigo'),
				'id' => $prefix . 'mod_pick_authors',
				'type' => 'authors_picker',
			),
			array(
				'name' => esc_html__('Users Bio', 'indigo'),
				'id' => $prefix . 'mod_authors_bio',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'indigo' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'indigo' ), 'value' => 'hide'),
				),
				'std' => 'show'
			),
			array(
				'name' => esc_html__('Users Web & Social Profiles', 'indigo'),
				'id' => $prefix . 'mod_authors_extras',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'indigo' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'indigo' ), 'value' => 'hide'),
				),
				'std' => 'show'
			),
		)
	),

	// Adding modules BLOG Type meta box
	'mod_blog_type_metabox' => array(
		'id' => 'mod-blog-qi-type-metabox',
		'title' => esc_html__('Blog Module Options', 'indigo'),
		'page' => 'quadro_mods',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Blog Style', 'indigo'),
				'id' => $prefix . 'mod_blog_layout',
				'type' => 'radio',
				'options' => array(
					array('name' => esc_html__('Classic Style', 'indigo' ), 'value' => 'classic'),
					array('name' => esc_html__('Teasers Style', 'indigo' ), 'value' => 'teasers'),
					array('name' => esc_html__('Headlines Style', 'indigo' ), 'value' => 'headlines'),
					array('name' => esc_html__('Masonry Style', 'indigo' ), 'value' => 'masonry'),
					array('name' => esc_html__('Metro Style', 'indigo' ), 'value' => 'metro'),
					),
				'std' => 'classic'
			),
			array(
				'name' => esc_html__('Columns', 'indigo'),
				'id' => $prefix . 'mod_blog_columns',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Three', 'indigo' ), 'value' => 'three'),
					array('name' => esc_html__('Two', 'indigo' ), 'value' => 'two')
					),
				'std' => 'three',
				'desc' => esc_html__( '(Available in Masonry Blog Style)', 'indigo' ),
			),
			array(
				'name' => esc_html__('Margins', 'indigo'),
				'id' => $prefix . 'mod_blog_margins',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Without Margins', 'indigo' ), 'value' => 'false'),
					array('name' => esc_html__('With Margins', 'indigo' ), 'value' => 'true')
					),
				'std' => 'false',
				'desc' => esc_html__( '(Available in Masonry Blog Style)', 'indigo' )
			),
			array(
				'name' => esc_html__('Posts Loading Animation', 'indigo'),
				'id' => $prefix . 'mod_blog_anim',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('None', 'indigo' ), 'value' => 'none'),
					array('name' => esc_html__('Type 1', 'indigo' ), 'value' => '1'),
					array('name' => esc_html__('Type 2', 'indigo' ), 'value' => '2'),
					array('name' => esc_html__('Type 3', 'indigo' ), 'value' => '3'),
					array('name' => esc_html__('Type 4', 'indigo' ), 'value' => '4'),
					array('name' => esc_html__('Type 5', 'indigo' ), 'value' => '5'),
					array('name' => esc_html__('Type 6', 'indigo' ), 'value' => '6'),
					array('name' => esc_html__('Type 7', 'indigo' ), 'value' => '7'),
					array('name' => esc_html__('Type 8', 'indigo' ), 'value' => '8'),
					),
				'std' => '3',
				'desc' => esc_html__( '(Available in Masonry Blog Style)', 'indigo' ),
			),
			array(
				'name' => esc_html__('Posts per page', 'indigo'),
				'id' => $prefix . 'mod_blog_perpage',
				'type' => 'text',
				'desc' => esc_html__('Enter -1 to show all posts in one page or leave empty to use WordPress general setting in Settings >> Reading.', 'indigo')
			),
			array(
				'name' => esc_html__('Navigation', 'indigo'),
				'id' => $prefix . 'mod_blog_show_nav',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('Show', 'indigo' ), 'value' => 'show'),
					array('name' => esc_html__('Hide', 'indigo' ), 'value' => 'hide'),
				),
				'desc' => esc_html__('Keep in mind that navigation will always navigate all posts regardless of your custom selection at this screen.', 'indigo'),
				'std' => 'show'
			),
			array(
				'name' => esc_html__('What to show?', 'indigo'),
				'id' => $prefix . 'mod_blog_method',
				'type' => 'select',
				'options' => array(
					array('name' => esc_html__('All Posts', 'indigo' ), 'value' => 'all'),
					array('name' => esc_html__('By Categories', 'indigo' ), 'value' => 'tax'),
					array('name' => esc_html__('By Post Format', 'indigo' ), 'value' => 'format'),
					array('name' => esc_html__('Custom Selection', 'indigo' ), 'value' => 'custom'),
				),
				'std' => 'all'
			),
			array(
				'name' => esc_html__('Choose Categories to Show', 'indigo'),
				'id' => $prefix . 'mod_blog_terms',
				'type' => 'tax_picker',
				'tax_slug' => 'category'
			),
			array(
				'name' => esc_html__('Choose Post Formats to Show', 'indigo'),
				'id' => $prefix . 'mod_blog_formats',
				'type' => 'format_picker',
			),
			array(
				'name' => esc_html__('Choose Posts to Show', 'indigo'),
				'id' => $prefix . 'mod_pick_blog',
				'type' => 'posts_picker',
				'post_type' => array( 'post' ),
				'show_type' => true
			),
			array(
				'name' => esc_html__('Posts Offset', 'indigo'),
				'id' => $prefix . 'mod_blog_offset',
				'type' => 'number',
				'desc' => esc_html__(' Enter a number (optional). Use this option to pass over any amount of posts. Delete value to cancel.', 'indigo')
			),
			array(
				'name' => esc_html__('Exclude Posts', 'indigo'),
				'id' => $prefix . 'mod_blog_exclude',
				'type' => 'text',
				'desc' => esc_html__('Enter IDs for excluded posts, separated by a comma. Using this setting disables \'-1\' setting for posts quantity.', 'indigo')
			),
		)
	),


);

/**
 * [$quadro_cfields_def filter]
 */
$quadro_cfields_def = apply_filters( 'qi_filter_cfields_definition', $quadro_cfields_def );

/**
 * [$quadro_cfields_mods_def filter]
 */
$quadro_cfields_mods_def = apply_filters( 'qi_filter_cfields_mods_definition', $quadro_cfields_mods_def );


?>