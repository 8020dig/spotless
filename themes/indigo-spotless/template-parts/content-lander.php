<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package AECOM
 */

if ( $lander = aecom_get_post_type_lander( $post_type ) ) :

$is_section_page = $post->post_parent === 0;
$labelledby = $is_section_page ? '' : '';

?>

<article id="post-<?php echo esc_attr( $lander->ID ); ?>" class="hentry lander-content" aria-labelledby="archive-title">

  <div class="lander-entry-content">
    <?php echo apply_filters( 'the_content', $lander->post_content ); ?>
  </div><!-- .entry-content -->

  <footer class="entry-footer"></footer>
</article><!-- #post-## -->

<?php

endif;
