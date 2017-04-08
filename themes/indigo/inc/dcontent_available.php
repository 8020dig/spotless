<?php

/**
 * Define available RMS
 *
 * The 'path' argument inside each RMS indicates a folder inside the /inc/dcontent
 * folder of the theme, ALWAYS. All RMS should go inside that folder.
 */

function qi_available_demo_packs() {

	$dcontent_packs = array(

		'main' => array(
			'slug' 		=> 'main',
			'path'		=> 'main/',
			'name' 		=> esc_html__('Main Demo', 'quadro'),
			'desc' 		=> esc_html__('This is the full demo of Indigo Theme. You\'ll get many blog and portfolio possibilities, homepages, about pages, a shop page and more.', 'quadro'),
			'tags'		=> esc_html__('multipurpose, versatile, corporate, shop, portfolio, blog', 'quadro'),
			'thumbs' 	=> array( 'main.jpg', '1.jpg', '2.jpg', '3.jpg', '4.jpg' ),
			'url'		=> 'https://preview.artisanthemes.io/indigo/',
			// RMS File Name
			'file' 		=> 'indigomain.demo.xml.gz',
			// RMS Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// RMS Widgets
			'widgets' 	=> 'widget_data.json',
			// RMS Plugins
			'plugins' 	=> 	array(
								'contact-form-7'=>'Contact Form 7',
								'jetpack'=>'Jetpack',
								'siteorigin-panels'=>'Page Builder',
								'so-widgets-bundle'=>'SiteOrigin Widgets Bundle',
								'quadro-portfolio'=>'Quadro Portfolio Type',
								'quadro-shortcodes'=>'Quadro Shortcodes',
								'wp-mega-menus-master'=>'CF Mega Menus',
								'responsive-lightbox'=>'Responsive Lightbox',
								'woocommerce'=>'WooCommerce',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'app' => array(
			'slug' 		=> 'app',
			'path'		=> 'app/',
			'name' 		=> esc_html__('Outfit App', 'quadro'),
			'desc' 		=> esc_html__('A cool site for any mobile app. Featuring how the app works, its main features and users\' pics. Pages included: Home, How it Works, Users Pics.', 'quadro'),
			'tags'		=> esc_html__('app, startup', 'quadro'),
			'thumbs' 	=> array( 'main.jpg', '1.jpg', '2.jpg' ),
			'url'		=> 'https://preview.artisanthemes.io/indigo-app/',
			// RMS File Name
			'file' 		=> 'indigoapp.demo.xml.gz',
			// RMS Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// RMS Widgets
			'widgets' 	=> 'widget_data.json',
			// RMS Plugins
			'plugins' 	=> 	array(
								'responsive-lightbox'=>'Responsive Lightbox',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'movies' => array(
			'slug' 		=> 'movies',
			'path'		=> 'movies/',
			'name' 		=> esc_html__('Movies', 'quadro'),
			'desc' 		=> esc_html__('Inspired on a very famous online streaming site :), a ready made site that can serve a movies/TV series catalog, a film production company, an entertainment site, etc. Pages included: Home, About, Catalog.', 'quadro'),
			'tags'		=> esc_html__('entertainment, portfolio, creative', 'quadro'),
			'thumbs' 	=> array( 'main.jpg', '1.jpg', '2.jpg', '3.jpg', '4.jpg' ),
			'url'		=> 'https://preview.artisanthemes.io/indigo-movies/',
			// RMS File Name
			'file' 		=> 'indigomovies.demo.xml.gz',
			// RMS Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// RMS Widgets
			'widgets' 	=> 'widget_data.json',
			// RMS Plugins
			'plugins' 	=> 	array(
								'quadro-portfolio'=>'Quadro Portfolio Type',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'sharp' => array(
			'slug' 		=> 'sharp',
			'path'		=> 'sharp/',
			'name' 		=> esc_html__('Sharp', 'quadro'),
			'desc' 		=> esc_html__('A ready made site for a modern online service or an agency with a sharp look. Pages included: Home, About, Works, Blog, Contact. Includes a set of custom CSS rules for extra fun.', 'quadro'),
			'tags'		=> esc_html__('agency, corporate, modern, services', 'quadro'),
			'thumbs' 	=> array( 'main.jpg', '1.jpg', '2.jpg', '3.jpg', '4.jpg' ),
			'url'		=> 'https://preview.artisanthemes.io/indigo-sharp/',
			// RMS File Name
			'file' 		=> 'indigosharp.demo.xml.gz',
			// RMS Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// RMS Widgets
			'widgets' 	=> 'widget_data.json',
			// RMS Plugins
			'plugins' 	=> 	array(
								'contact-form-7'=>'Contact Form 7',
								'siteorigin-panels'=>'Page Builder',
								'so-widgets-bundle'=>'SiteOrigin Widgets Bundle',
								'quadro-portfolio'=>'Quadro Portfolio Type',
								'quadro-shortcodes'=>'Quadro Shortcodes',
								'responsive-lightbox'=>'Responsive Lightbox',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'agency' => array(
			'slug' 		=> 'agency',
			'path'		=> 'agency/',
			'name' 		=> esc_html__('Agency', 'quadro'),
			'desc' 		=> esc_html__('Agency can serve from a small studio to a big agency. Use it to show your services and to feature your work. Add your copy, mix it up, and give your company its deserved website. Pages included: Home, About, Creative Process, Works, Contact.', 'quadro'),
			'tags'		=> esc_html__('studio, portfolio, services, creative, business, corporate', 'quadro'),
			'thumbs' 	=> array( 'main.jpg', '1.jpg', '2.jpg', '3.jpg' ),
			'url'		=> 'https://preview.artisanthemes.io/indigo-agency/',
			// RMS File Name
			'file' 		=> 'indigoagency.demo.xml.gz',
			// RMS Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// RMS Widgets
			'widgets' 	=> 'widget_data.json',
			// RMS Plugins
			'plugins' 	=> 	array(
								'quadro-portfolio'=>'Quadro Portfolio Type',
								'siteorigin-panels'=>'Page Builder',
								'contact-form-7'=>'Contact Form 7',
								'responsive-lightbox'=>'Responsive Lightbox',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'shop' => array(
			'slug' 		=> 'shop',
			'path'		=> 'shop/',
			'name' 		=> esc_html__('Shop', 'quadro'),
			'desc' 		=> esc_html__('The perfect look and layout for a modern online store. A white-boxed site, with a neat slider on the homepage to feature products/news/offers, and pages prepared to show the big categories of your shop each one with its own style. Pages included: Home, Shop Category Pages, FAQs.', 'quadro'),
			'tags'		=> esc_html__('shop, e-commerce, store, retailer', 'quadro'),
			'thumbs' 	=> array( 'main.jpg', '1.jpg', '2.jpg', '3.jpg', '4.jpg' ),
			'url'		=> 'https://preview.artisanthemes.io/indigo-shop/',
			// RMS File Name
			'file' 		=> 'indigoshop.demo.xml.gz',
			// RMS Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// RMS Widgets
			'widgets' 	=> 'widget_data.json',
			// RMS Plugins
			'plugins' 	=> 	array(
								'woocommerce'=>'WooCommerce',
								'siteorigin-panels'=>'Page Builder',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'corporate' => array(
			'slug' 		=> 'corporate',
			'path'		=> 'corporate/',
			'name' 		=> esc_html__('Corporate', 'quadro'),
			'desc' 		=> esc_html__('Build a corporate business site. Pages included: Home, Services, Portfolio, News, Contact.', 'quadro'),
			'tags'		=> esc_html__('business, corporate, services, agency', 'quadro'),
			'thumbs' 	=> array( 'main.jpg', '1.jpg' ),
			'url'		=> 'https://preview.artisanthemes.io/indigo-corporate/',
			// RMS File Name
			'file' 		=> 'indigocorporate.demo.xml.gz',
			// RMS Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// RMS Widgets
			'widgets' 	=> 'widget_data.json',
			// RMS Plugins
			'plugins' 	=> 	array(
								'quadro-portfolio'=>'Quadro Portfolio Type',
								'contact-form-7'=>'Contact Form 7',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'magazine' => array(
			'slug' 		=> 'magazine',
			'path'		=> 'magazine/',
			'name' 		=> esc_html__('Magazine', 'quadro'),
			'desc' 		=> esc_html__('A modern magazine style site, with category pages and space for advertisement.', 'quadro'),
			'tags'		=> esc_html__('magazine, journalism, trendy, modern, news', 'quadro'),
			'thumbs' 	=> array( 'main.jpg', '1.jpg', '2.jpg', '3.jpg' ),
			'url'		=> 'https://preview.artisanthemes.io/indigo-magazine/',
			// RMS File Name
			'file' 		=> 'indigomagazine.demo.xml.gz',
			// RMS Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// RMS Widgets
			'widgets' 	=> 'widget_data.json',
			// RMS Plugins
			'plugins' 	=> 	array(
								'jetpack'=>'Jetpack',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'fullscreen' => array(
			'slug' 		=> 'fullscreen',
			'path'		=> 'fullscreen/',
			'name' 		=> esc_html__('FullScreen', 'quadro'),
			'desc' 		=> esc_html__('A one page site with a trendy style and inside navigation.', 'quadro'),
			'tags'		=> esc_html__('one page, fullscreen, trendy, pop, hipster', 'quadro'),
			'thumbs' 	=> array( 'main.jpg', '1.jpg', '2.jpg' ),
			'url'		=> 'https://preview.artisanthemes.io/indigo-fullscreen/',
			// RMS File Name
			'file' 		=> 'indigofullscreen.demo.xml.gz',
			// RMS Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// RMS Widgets
			'widgets' 	=> 'widget_data.json',
			// RMS Plugins
			'plugins' 	=> 	array(
								'quadro-portfolio'=>'Quadro Portfolio Type',
								'contact-form-7'=>'Contact Form 7',
								'responsive-lightbox'=>'Responsive Lightbox',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'market' => array(
			'slug' 		=> 'market',
			'path'		=> 'market/',
			'name' 		=> esc_html__('Market', 'quadro'),
			'desc' 		=> esc_html__('A representative site for a close-to-the-people kind of place. Includes maps for locations and a useful shopping cart via WooCommerce plugin. Pages included: Home, Blog, About, Stores, FAQs, E-market.', 'quadro'),
			'tags'		=> esc_html__('market, e-commerce, store, retailer', 'quadro'),
			'thumbs' 	=> array( 'main.jpg', '1.jpg' ),
			'url'		=> 'https://preview.artisanthemes.io/indigo-market/',
			// RMS File Name
			'file' 		=> 'indigomarket.demo.xml.gz',
			// RMS Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// RMS Widgets
			'widgets' 	=> 'widget_data.json',
			// RMS Plugins
			'plugins' 	=> 	array(
								'siteorigin-panels'=>'Page Builder',
								'woocommerce'=>'WooCommerce',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'portfolio' => array(
			'slug' 		=> 'portfolio',
			'path'		=> 'portfolio/',
			'name' 		=> esc_html__('Portfolio', 'quadro'),
			'desc' 		=> esc_html__('A minimal portfolio for a cool studio or a freelancer. It features your works in a clean and modern way, portraying a cool style and lots of character. Pages included: Portfolio (as homepage), About, Contact.', 'quadro'),
			'tags'		=> esc_html__('studio, agency, portfolio, creative, hipster, freelancer', 'quadro'),
			'thumbs' 	=> array( 'main.jpg', '1.jpg' ),
			'url'		=> 'https://preview.artisanthemes.io/indigo-portfolio/',
			// RMS File Name
			'file' 		=> 'indigoportfolio.demo.xml.gz',
			// RMS Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// RMS Widgets
			'widgets' 	=> 'widget_data.json',
			// RMS Plugins
			'plugins' 	=> 	array(
								'quadro-portfolio'=>'Quadro Portfolio Type',
								'responsive-lightbox'=>'Responsive Lightbox',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'blog' => array(
			'slug' 		=> 'blog',
			'path'		=> 'blog/',
			'name' 		=> esc_html__('Personal Blog', 'quadro'),
			'desc' 		=> esc_html__('A Medium-like blog. Clean. Personal. Beautiful. Pages included: Home 1, Home 2, Home 3, About me.', 'quadro'),
			'tags'		=> esc_html__('personal, stories, medium, blog', 'quadro'),
			'thumbs' 	=> array( 'main.jpg' ),
			'url'		=> 'https://preview.artisanthemes.io/indigo-blog/',
			// RMS File Name
			'file' 		=> 'indigoblog.demo.xml.gz',
			// RMS Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// RMS Widgets
			'widgets' 	=> 'widget_data.json',
			// RMS Plugins
			'plugins' 	=> 	array(),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'restaurant' => array(
			'slug' 		=> 'restaurant',
			'path'		=> 'restaurant/',
			'name' 		=> esc_html__('Restaurant', 'quadro'),
			'desc' 		=> esc_html__('A premium restaurant website with room for promos, a menu and beautiful food pics. Pages included: Home, Menu, About, News, Contact.', 'quadro'),
			'tags'		=> esc_html__('food, bar, resto, deli, premium', 'quadro'),
			'thumbs' 	=> array( 'main.jpg', '1.jpg' ),
			'url'		=> 'https://preview.artisanthemes.io/indigo-restaurant/',
			// RMS File Name
			'file' 		=> 'indigorestaurant.demo.xml.gz',
			// RMS Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// RMS Widgets
			'widgets' 	=> 'widget_data.json',
			// RMS Plugins
			'plugins' 	=> 	array(
								'responsive-lightbox'=>'Responsive Lightbox',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'stories' => array(
			'slug' 		=> 'stories',
			'path'		=> 'stories/',
			'name' 		=> esc_html__('Stories', 'quadro'),
			'desc' 		=> esc_html__('A site for a story telling little project. Think of HONY in web version, reloaded. Pages included: Homepage.', 'quadro'),
			'tags'		=> esc_html__('story telling, stories, journalism, medium, blog', 'quadro'),
			'thumbs' 	=> array( 'main.jpg', '1.jpg' ),
			'url'		=> 'https://preview.artisanthemes.io/indigo-stories/',
			// RMS File Name
			'file' 		=> 'indigostories.demo.xml.gz',
			// RMS Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// RMS Widgets
			'widgets' 	=> 'widget_data.json',
			// RMS Plugins
			'plugins' 	=> 	array(),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'travel' => array(
			'slug' 		=> 'travel',
			'path'		=> 'travel/',
			'name' 		=> esc_html__('Travel', 'quadro'),
			'desc' 		=> esc_html__('A modern style site for a travel agency. Uses Crelly Slider as a homepage opener, a Services module to showcase the agency features and a Portfolio to introduce vacation packages. Use it for any sort of service retailer company. Pages included: Home, About, Blog, Packages, Trip Tips.', 'quadro'),
			'tags'		=> esc_html__('travel, agency, packages, blog', 'quadro'),
			'thumbs' 	=> array( 'main.jpg', '1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg' ),
			'url'		=> 'https://preview.artisanthemes.io/indigo-travel/',
			// RMS File Name
			'file' 		=> 'indigotravel.demo.xml.gz',
			// RMS Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// RMS Widgets
			'widgets' 	=> 'widget_data.json',
			// RMS Plugins
			'plugins' 	=> 	array(
								'crelly-slider'=>'Crelly Slider',
								'quadro-portfolio'=>'Quadro Portfolio Type',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'coworking' => array(
			'slug' 		=> 'coworking',
			'path'		=> 'coworking/',
			'name' 		=> esc_html__('Coworking', 'quadro'),
			'desc' 		=> esc_html__('A ready-made site for a coworking space. It will serve any kind of down to the point mission, though. Got a service you need to promote? Trying a new product campaign? This is the one. Go for it. Pages included: Home, Our Mission, Our Space, Pricing, Contact Us. Please enable "Legacy Bundled Widgets in Settings >> Page Builder >> Widgets".', 'quadro'),
			'tags'		=> esc_html__('coworking, space, studio, freelancer', 'quadro'),
			'thumbs' 	=> array( 'main.jpg', '1.jpg', '2.jpg', '3.jpg' ),
			'url'		=> 'https://preview.artisanthemes.io/indigo-coworking/',
			// RMS File Name
			'file' 		=> 'indigocoworking.demo.xml.gz',
			// RMS Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// RMS Widgets
			'widgets' 	=> 'widget_data.json',
			// RMS Plugins
			'plugins' 	=> 	array(
								'contact-form-7'=>'Contact Form 7',
								'siteorigin-panels'=>'Page Builder',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),


	);

	return $dcontent_packs;

}

?>