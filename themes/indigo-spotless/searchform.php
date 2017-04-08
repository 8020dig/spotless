<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html__('Search for:', 'indigo'); ?></span>
		<?php // choose search filter by post type
		switch(get_post_type(get_the_ID())){
			case "service":
				$search_select="Search Services";
				break;
			case "market":
				$search_select="Search Markets";
				break;
			case "project":
				$search_select="Search Clients";
				break;
			default:
				$search_select="Search Spotless.com";
			}
		?>
		<input type="search" class="search-field" placeholder="<?php echo $search_select;?>" value="" name="s" title="<?php echo esc_html__('Search for:', 'indigo'); ?>" />
	</label>
	<input type="submit" class="search-submit" value="<?php echo esc_html__('Search', 'indigo'); ?>" />
</form>