<?php
/**
 * Display related links/publications for the current post
 */

if ( $related_items = aecom_get_related_links() ) :

$first_link_has_image = ! empty( $related_items[ array_keys( $related_items )[0] ]['thumb'] );

?>
<aside class="related-content related-links"><ul<?php echo $first_link_has_image ? ' class="first-link-has-image"' : ''; ?>>
  <?php foreach ( $related_items as $item ) {
    $item_title = $item[ aecom_get_lang() ];
    $link_text = $item[ aecom_lang_suffix( 'link_text' ) ];
    $link_target = $item['new'] ? ' target="_blank"' : '';

    $link_attrs = 'href="' . esc_url( $item['url'] ) . '"' . $link_target . ' title="' . esc_attr( $link_text ) . '"';
    ?>
    <li class="related-item">
    <?php if ( ! empty( $item['thumb'] ) ) { ?>
      <figure>
        <a class="image-link" <?php echo $link_attrs; ?>>
          <img src="<?php echo esc_url( $item['thumb'] ); ?>" alt="<?php echo esc_attr( $item_title ); ?>">
        </a>
        <figcaption class="related-item-title"><a <?php echo $link_attrs; ?>><?php echo wp_kses_post( $item_title ); ?></a></figcaption>
      </figure>
    <?php } else { ?>
      <p class="related-item-title"><a <?php echo $link_attrs; ?>><?php echo wp_kses_post( $item_title ); ?></a></p>
    <?php } ?>
    <?php if ( ! empty( $link_text ) ) { ?>
      <p class="related-item-meta"><a <?php echo $link_attrs; ?>><?php echo wp_kses_post( $link_text ); ?></a></p>
    <?php } ?>
    </li>
  <?php } ?>
</ul></aside><!-- .related-links -->
<?php
endif;
