<?php

/**
 * Define available animations and their definitions
 *
 */

function qi_available_animations() {

	$available_animations = array(

		'none' => array(
			'value' 	=> 'none',
			'name' 		=> esc_html__('None', 'indigo'),
			'first'		=> '',
			'second'	=> '',
		),

		'fadein' => array(
			'value' 	=> 'fadein',
			'name' 		=> esc_html__('FadeIn', 'indigo'),
			'first'		=> 'wow fadeIn',
			'second'	=> 'wow fadeIn',
		),

		'fadeinup' => array(
			'value' 	=> 'fadeinup',
			'name' 		=> esc_html__('FadeIn Up', 'indigo'),
			'first'		=> 'wow fadeInUp',
			'second'	=> 'wow fadeInUp',
		),

		'fadeindown' => array(
			'value' 	=> 'fadeindown',
			'name' 		=> esc_html__('FadeIn Down', 'indigo'),
			'first'		=> 'wow fadeInDown',
			'second'	=> 'wow fadeInDown',
		),

		'fadeinleft' => array(
			'value' 	=> 'fadeinleft',
			'name' 		=> esc_html__('FadeIn Left', 'indigo'),
			'first'		=> 'wow fadeInLeft',
			'second'	=> 'wow fadeInLeft',
		),

		'fadeinright' => array(
			'value' 	=> 'fadeinright',
			'name' 		=> esc_html__('FadeIn Right', 'indigo'),
			'first'		=> 'wow fadeInRight',
			'second'	=> 'wow fadeInRight',
		),

		'fadeinupb' => array(
			'value' 	=> 'fadeinupb',
			'name' 		=> esc_html__('FadeIn Up Big', 'indigo'),
			'first'		=> 'wow fadeInUpBig',
			'second'	=> 'wow fadeInUpBig',
		),

		'fadeindownb' => array(
			'value' 	=> 'fadeindownb',
			'name' 		=> esc_html__('FadeIn Down Big', 'indigo'),
			'first'		=> 'wow fadeInDownBig',
			'second'	=> 'wow fadeInDownBig',
		),
		
		'fadeinleftb' => array(
			'value' 	=> 'fadeinleftb',
			'name' 		=> esc_html__('FadeIn Left Big', 'indigo'),
			'first'		=> 'wow fadeInLeftBig',
			'second'	=> 'wow fadeInLeftBig',
		),

		'fadeinrightb' => array(
			'value' 	=> 'fadeinrightb',
			'name' 		=> esc_html__('FadeIn Right Big', 'indigo'),
			'first'		=> 'wow fadeInRightBig',
			'second'	=> 'wow fadeInRightBig',
		),

		'bouncein' => array(
			'value' 	=> 'bouncein',
			'name' 		=> esc_html__('BounceIn', 'indigo'),
			'first'		=> 'wow bounceIn',
			'second'	=> 'wow bounceIn',
		),

		'bounceinup' => array(
			'value' 	=> 'bounceinup',
			'name' 		=> esc_html__('BounceIn Up', 'indigo'),
			'first'		=> 'wow bounceInUp',
			'second'	=> 'wow bounceInUp',
		),

		'bounceindown' => array(
			'value' 	=> 'bounceindown',
			'name' 		=> esc_html__('BounceIn Down', 'indigo'),
			'first'		=> 'wow bounceInDown',
			'second'	=> 'wow bounceInDown',
		),

		'bounceinleft' => array(
			'value' 	=> 'bounceinleft',
			'name' 		=> esc_html__('BounceIn Left', 'indigo'),
			'first'		=> 'wow bounceInLeft',
			'second'	=> 'wow bounceInLeft',
		),

		'bounceinright' => array(
			'value' 	=> 'bounceinright',
			'name' 		=> esc_html__('BounceIn Right', 'indigo'),
			'first'		=> 'wow bounceInRight',
			'second'	=> 'wow bounceInRight',
		),

		'flipinx' => array(
			'value' 	=> 'flipinx',
			'name' 		=> esc_html__('FlipIn X', 'indigo'),
			'first'		=> 'wow flipInX',
			'second'	=> 'wow flipInX',
		),

		'flipiny' => array(
			'value' 	=> 'flipiny',
			'name' 		=> esc_html__('FlipIn Y', 'indigo'),
			'first'		=> 'wow flipInY',
			'second'	=> 'wow flipInY',
		),

		'rotindownleft' => array(
			'value' 	=> 'rotindownleft',
			'name' 		=> esc_html__('Rotate In Down Left', 'indigo'),
			'first'		=> 'wow rotateInDownLeft',
			'second'	=> 'wow rotateInDownLeft',
		),

		'rotindownright' => array(
			'value' 	=> 'rotindownright',
			'name' 		=> esc_html__('Rotate In Down Right', 'indigo'),
			'first'		=> 'wow rotateInDownRight',
			'second'	=> 'wow rotateInDownRight',
		),

		'rotinupleft' => array(
			'value' 	=> 'rotinupleft',
			'name' 		=> esc_html__('Rotate In Up Left', 'indigo'),
			'first'		=> 'wow rotateInUpLeft',
			'second'	=> 'wow rotateInUpLeft',
		),

		'rotinupright' => array(
			'value' 	=> 'rotinupright',
			'name' 		=> esc_html__('Rotate In Up Right', 'indigo'),
			'first'		=> 'wow rotateInUpRight',
			'second'	=> 'wow rotateInUpRight',
		),

		'slideinup' => array(
			'value' 	=> 'slideinup',
			'name' 		=> esc_html__('SlideIn Up', 'indigo'),
			'first'		=> 'wow slideInUp',
			'second'	=> 'wow slideInUp',
		),

		'slideindown' => array(
			'value' 	=> 'slideindown',
			'name' 		=> esc_html__('SlideIn Down', 'indigo'),
			'first'		=> 'wow slideInDown',
			'second'	=> 'wow slideInDown',
		),

		'slideinleft' => array(
			'value' 	=> 'slideinleft',
			'name' 		=> esc_html__('SlideIn Left', 'indigo'),
			'first'		=> 'wow slideInLeft',
			'second'	=> 'wow slideInLeft',
		),

		'slideinright' => array(
			'value' 	=> 'slideinright',
			'name' 		=> esc_html__('SlideIn Right', 'indigo'),
			'first'		=> 'wow slideInRight',
			'second'	=> 'wow slideInRight',
		),

		'zoomin' => array(
			'value' 	=> 'zoomin',
			'name' 		=> esc_html__('ZoomIn', 'indigo'),
			'first'		=> 'wow zoomIn',
			'second'	=> 'wow zoomIn',
		),

		'zoominup' => array(
			'value' 	=> 'zoominup',
			'name' 		=> esc_html__('ZoomIn Up', 'indigo'),
			'first'		=> 'wow zoomInUp',
			'second'	=> 'wow zoomInUp',
		),

		'zoomindown' => array(
			'value' 	=> 'zoomindown',
			'name' 		=> esc_html__('ZoomIn Down', 'indigo'),
			'first'		=> 'wow zoomInDown',
			'second'	=> 'wow zoomInDown',
		),

		'zoominleft' => array(
			'value' 	=> 'zoominleft',
			'name' 		=> esc_html__('ZoomIn Left', 'indigo'),
			'first'		=> 'wow zoomInLeft',
			'second'	=> 'wow zoomInLeft',
		),

		'zoominright' => array(
			'value' 	=> 'zoominright',
			'name' 		=> esc_html__('ZoomIn Right', 'indigo'),
			'first'		=> 'wow zoomInRight',
			'second'	=> 'wow zoomInRight',
		),

		'bounce' => array(
			'value' 	=> 'bounce',
			'name' 		=> esc_html__('Bounce', 'indigo'),
			'first'		=> 'wow bounce',
			'second'	=> 'wow bounce',
		),

		'flash' => array(
			'value' 	=> 'flash',
			'name' 		=> esc_html__('Flash', 'indigo'),
			'first'		=> 'wow flash',
			'second'	=> 'wow flash',
		),

		'pulse' => array(
			'value' 	=> 'pulse',
			'name' 		=> esc_html__('Pulse', 'indigo'),
			'first'		=> 'wow pulse',
			'second'	=> 'wow pulse',
		),

		'swing' => array(
			'value' 	=> 'swing',
			'name' 		=> esc_html__('Swing', 'indigo'),
			'first'		=> 'wow swing',
			'second'	=> 'wow swing',
		),

		'tada' => array(
			'value' 	=> 'tada',
			'name' 		=> esc_html__('Tada', 'indigo'),
			'first'		=> 'wow tada',
			'second'	=> 'wow tada',
		),

		'fadeinlr' => array(
			'value' 	=> 'fadeinlr',
			'name' 		=> esc_html__('FadeIn Left Up', 'indigo'),
			'first'		=> 'wow fadeInLeft',
			'second'	=> 'wow fadeInUp',
		),

		'fadeinur' => array(
			'value' 	=> 'fadeinur',
			'name' 		=> esc_html__('FadeIn Up Right', 'indigo'),
			'first'		=> 'wow fadeInUp',
			'second'	=> 'wow fadeInRight',
		),

	);

	// Apply Filter Available Animations
	$available_animations = apply_filters( 'qi_filter_available_animations', $available_animations );

	return $available_animations;

}

?>