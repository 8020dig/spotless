<?php
/**
 * Display related videos for the current post
 */

$all_videos = array(
  'about-aecom' => array(
    // CHANGE VIDEO CODE BELOW TO CHANGE PRIMARY VIDEO
    array(
      'wistia-id' => 'tkkgax9can',
      'title' => 'Innovation knows no boundaries',
    ),
    array(
      'wistia-id' => '7d50ugasci',
      'title' => 'Built to deliver a better world',
    ),
  ),
//
  'critical-infrastructure-protection' => array(
    // CHANGE VIDEO CODE BELOW TO CHANGE PRIMARY VIDEO
    array(
      'wistia-id' => '6wj5lxe4c1',
      'title' => 'Our expertise in Critical Infrastructure Protection',
    ),
  ),
//
'east-tennessee-technology-park' => array(
    // CHANGE VIDEO CODE BELOW TO CHANGE PRIMARY VIDEO
    array(
      'wistia-id' => '8s1zpcdzjn',
      'title' => 'UAS Technology Eliminates Risk and Improves Performance',
    ),
    array(
      'wistia-id' => 'vtl7nzge9x',
      'title' => 'Vision 2016: The past, the present and the future',
    ),
    array(
      'wistia-id' => '9haehea534',
      'title' => 'Enabling Oak Ridge’s next chapter',
    ),
  ),


  // ...
);

if ( ! empty( $all_videos[ $post->post_name ] ) ) :

$videos = $all_videos[ $post->post_name ];

?>
<aside class="related-content related-videos">
  <h1><?php _e( 'Related Media', 'aecom' ); ?></h1>

  <?php
  // first (featured) video
  $video = array_shift( $videos ); ?>
  <article class="related-item">
    <div class="wistia_embed wistia_async_<?php echo esc_attr( $video['wistia-id'] ); ?> popover=true popoverAnimateThumbnail=true"></div>
    <h2 class="related-item-title"><?php echo esc_html( $video['title'] ); ?></h2>
  </article><!-- .related-item -->

  <?php if ( ! empty( $videos ) ) : // remaining, non-featured videos ?>
    <div class="related-item additional-videos">
      <h2 class="related-item-meta"><?php _e( 'See our other videos', 'aecom' ); ?></h2>

      <?php foreach ( $videos as $video ) : ?>

        <article>
          <div class="wistia_embed no-thumbnail wistia_async_<?php echo esc_attr( $video['wistia-id'] ); ?> popover=true popoverContent=html">
            <h2 class="related-item-title"><?php echo esc_html( $video['title'] ); ?></h2>
          </div>
        </article>

      <?php endforeach; ?>

    </div>
  <?php endif; ?>

</aside><!-- .related-projects -->
<?php

endif;
