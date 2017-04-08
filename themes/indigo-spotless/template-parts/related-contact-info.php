<?php
/**
 * Display related links/publications for the current post
 */
$contacts = aecom_get_individual_contact_info();
$contact_info = aecom_get_related_contact_info();
if($contact_info): ?>
<aside class="related-content related-contacts">
  <?php if ( ! ( aecom_is_one_page() && is_front_page() ) ) { // no header on one-page site homepages ?>
    <h1><?php esc_html_e( 'Contact', 'aecom' ); ?></h1>
  <?php } ?>
  <?php
  foreach ( array( 'local', 'global' ) as $info_set ) {
    if ( isset( $contact_info[ $info_set ] ) ) {
      echo apply_filters( 'the_content', $contact_info[ $info_set ] );
    }
  }
  ?>
</aside><!-- .related-links -->
<?php
endif;
if($contacts): ?>
<aside class="related-content individual-contacts filter-bar">
  <div class="filter select-market has-dropdown contacts-button">
    <h3><a href="#" class="ae-dropdown-toggle"><?php echo aecom_get_individual_contacts_label() ?></a></h3>
    <div class="ae-dropdown">
      <?php
      $contacts_per_row = 2;
      $contacts_amount = count($contacts);
      $rows = ceil($contacts_amount / $contacts_per_row);
      $counter = 0;
      ?>
      <div class="individual-contacts-container ae-dropdown-content cols-<?php echo 1 < $contacts_amount ? 2 : 1 ?>">
        <?php for($i = 0; $i < $rows; $i++): ?>
        <div class="contacts-row">
          <?php for($j = $contacts_per_row * $i; $j < $contacts_per_row * ($i + 1) && $j < $contacts_amount; $j++): ?>
          <div class="contacts-column">
            <div class="contact-container">
              <?php echo apply_filters( 'the_content', $contacts[$j] ); ?>
            </div>
          </div>
          <?php endfor; ?>
        </div>
        <?php endfor; ?>
      </div>
    </div>
  </div>
</aside>
<?php endif;
