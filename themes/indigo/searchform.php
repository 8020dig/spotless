<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html__('Search for:', 'indigo'); ?></span>
		<input type="search" class="search-field" placeholder="" value="" name="s" title="<?php echo esc_html__('Search for:', 'indigo'); ?>" />
	</label>
	<input type="submit" class="search-submit" value="<?php echo esc_html__('Search', 'indigo'); ?>" />
</form>