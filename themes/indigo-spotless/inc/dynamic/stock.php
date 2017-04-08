<?php
// do not allow direct access to this file
if ( ! defined( 'URS_LOADER' ) )
  exit();

// load stock data
$quote = urs_dynamic_data_get( 'global_urs_content_stock_data', 'common', true );

if ( empty( $quote ) )
  exit();

$delta_class = '';
$delta_text = '%1s: unchanged as of %3$s';
if ( floatval( $quote['change'] ) > 0 ) {
  $delta_class = 'up';
  $delta_text = '%1s: +%2s as of %3$s';
} elseif ( floatval( $quote['change'] ) < 0 ) {
  $delta_class = 'down';
  $delta_text = '%1s: %2s as of %3$s';
}

// switch to UTC to get date/time
// TODO: except... the feed is in ET. what?
$normal_tz = date_default_timezone_get();
date_default_timezone_set( 'UTC' );
$date = date( 'h:i A \E\T m/d/Y', $quote['time'] );
date_default_timezone_set( $normal_tz );

$delta_text = sprintf( $delta_text, $quote['ticker'], $quote['change'], $date );

?>
<aside class="stock-quote">
  <a href="http://phx.corporate-ir.net/phoenix.zhtml?c=131318&p=irol-irhome">
    <?php echo $quote['exchange']; ?>
    <span class="quote-value" title="<?php echo $delta_text; ?>">
      <span class="stock-status-indicator <?php echo $delta_class; ?>"></span>
      <?php echo '$' . $quote['trade']; ?>
    </span>
  </a>
</aside>
