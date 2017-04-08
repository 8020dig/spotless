<?php
/**
 * Display the contents of the "sidebar content" meta box
 */

if ( $sidebar_content = aecom_get_sidebar_content() ) :
?>
<aside class="related-content sidebar-content">
  <?php echo $sidebar_content; ?>
</aside><!-- .sidebar-content -->
<?php
endif;
