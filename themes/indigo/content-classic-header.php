<?php
/**
 * Template for displaying single post header.
 *
 */
?>

<?php
$post_id = get_the_id();

// Get header data
$header_back 	= esc_attr( get_post_meta( $post_id, 'quadro_post_header_back', true ) );
$style			= '';

// Bring Feat. Image if selected as background
if ( has_post_thumbnail() && $header_back != 'color' ) {
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'quadro-full-thumb' );
	$style = 'style="background-image: url(\'' . esc_url($image[0]) . '\');"';
}
?>

<header class="entry-header clear">

	<?php if ( has_post_thumbnail() && $header_back != 'color' ) { ?>
	<div class="entry-thumbnail" <?php echo $style; ?>></div>
	<?php } ?>

	<div class="entry-inner">
		
		<?php qi_before_post_title(); ?>

		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>

		<?php qi_after_post_title(); ?>

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

			<?php if ( ! post_password_required() && ( comments_open() && '0' != get_comments_number() ) ) : ?>
				<span class="meta-separator">&#8226;</span>
	        	<span class="comments-link"><?php comments_popup_link( esc_html__( 'Comment', 'indigo' ), esc_html__( '1 Comment', 'indigo' ), esc_html__( '% Comments', 'indigo' ) ); ?></span>
	        <?php endif; ?>
	        
		</div>

	</div>

</header><!-- .entry-header -->