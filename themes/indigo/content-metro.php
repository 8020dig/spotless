<?php
/**
 * @package quadro
 */
?>

<?php
$post_id = get_the_id();
// Get header type
$header_back 		= esc_attr( get_post_meta( $post_id, 'quadro_post_header_back', true ) );
$header_text_color	= esc_attr( get_post_meta( $post_id, 'quadro_post_header_text_color', true ) );
$header_overlay		= esc_attr( get_post_meta( $post_id, 'quadro_post_header_overlay', true ) );
$header_text_color 	= $header_text_color == '' ? 'auto' : $header_text_color;
$has_thumb			= has_post_thumbnail( $post_id ) ? 'has-feat-img' : 'hasnt-feat-img';

// Bring Feat. Image or Solid Color as background
if ( $header_back == 'color' ) {
	$header_back_color 	= esc_attr( get_post_meta( $post_id, 'quadro_post_header_back_color', true ) );
	$style = 'style="background-color: ' . $header_back_color . ';"';
}
else {
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'quadro-full-thumb' );
	$style = 'style="background-image: url(\'' . esc_url($image[0]) . '\');"';
}
?>

<?php // Enabling the "more tag"
global $more;
$more = 0;
?>

<article id="post-<?php the_ID(); ?>" data-original="<?php echo esc_url($image[0]); ?>" <?php post_class('lazy blog-item post-title-' . $header_text_color . ' overlay-' . $header_overlay . ' ' . $has_thumb . ' header-' . $header_back); ?> <?php echo $style; ?>>

	<div class="dark-overlay"></div>

	<header class="entry-header">

		<div class="entry-inner">
	
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>

			<div class="entry-meta">
				
				<?php quadro_posted_by_gravatar( $post->post_author, 40 ); ?>

				<span class="meta-separator">&#8226;</span>
				
				<?php quadro_posted_on(); ?>

				<?php /* translators: used between list items, there is a space after the comma */
				$category_list = get_the_category_list( ', ' );
				if ( $category_list != '' ) {
					if ( quadro_categorized_blog() ) {
						$cats_text = '<span class="meta-separator">&#8226;</span><p class="cat-links">' . esc_html__( 'In %1$s', 'indigo' ) . '</p>';
						printf( $cats_text, $category_list );
					} // end check for categories on this blog 
				} ?>

			</div>

		</div>

	</header><!-- .entry-header -->

</article><!-- #post-## -->