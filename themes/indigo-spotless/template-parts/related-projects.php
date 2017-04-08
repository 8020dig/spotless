<?php
/**
 * Display related projects for the current post
 */

if ( $projects = aecom_get_related_projects() ) :

?>
<div class="related-content related-projects blog-style-masonry masonry-margins-true no-sidebar">
<h1><?php _e( 'Related Projects', 'aecom' ); ?></h1>
<aside class="anim-grid anim-3 blog-container blog-content blog-masonry blog-columns-three masonry">
  <?php foreach ( $projects as $project ) { ?>
    <?php if ( $project_thumbnail_id = get_post_thumbnail_id( $project->ID ) ) { ?>
      <article class="related-item blog-item size-item market type-market status-publish has-post-thumbnail hentry masonry-brick shown">
       	<header class="entry-header">
       	  <div class="entry-thumbnail">
            <?php
            $project_permalink = get_post_permalink( $project->ID );
            ?>
            <a href="<?php echo esc_url( $project_permalink ); ?>" title="<?php echo esc_attr( $project->post_title ); ?>" class="image-link">
              <?php echo get_the_post_thumbnail($project->ID, 'spotless-grid-2x'); ?>
            </a>
          </div>
          
          <h1 class="entry-title">
			      <a href="<?php echo esc_url( $project_permalink ); ?>" rel="bookmark"><?php echo esc_html( $project->post_title ); ?></a>
		      </h1>
		    </header>
		    <div class="entry-summary">
          <?php echo _x( 'From:', 'related content source prefix', 'aecom' ); ?></span>
          <?php
          if(!empty($project->featured_project))
            _e( 'Featured Projects', 'aecom' );
          ?>
        </div>
      </article><!-- .related-item -->
    <?php } ?>
  <?php } ?>
</aside><!-- .related-projects -->
</div>
<?php
endif;
