<?php
/**
 * Handles the display of admin notices for license status
 */


/*-----------------------------------------------------------------------------------*/
/*	Admin Notices
/*-----------------------------------------------------------------------------------*/

// Groups & hooks admin notices
function at_admin_notices() {

	// Only for testing purposes. Leave commented.
	// delete_transient( 'empty_license_dismissed' );
	// delete_transient( 'expired_license_dismissed' );

	// Check for dismissed transient
	if ( false === get_transient( 'empty_license_dismissed' ) ) {
		add_action( 'admin_notices', 'at_empty_license_notice' );
	}

	// Check for expired license transient
	if ( false === get_transient( 'expired_license_dismissed' ) ) {
		add_action( 'admin_notices', 'at_expired_license_notice' );
	}

}
add_action( 'admin_init', 'at_admin_notices' );


// Throw a notice if license details are not complete
function at_empty_license_notice() {
	
	global $quadro_options;

	// Don't show the notice if all the fields are completed
	if ( $quadro_options['quadro_username'] !== '' && $quadro_options['quadro_userpass'] !== '' && $quadro_options['quadro_userlicense'] !== '' ) return false;

	?>
	<div class="at-admin-notice notice notice-error is-dismissible" data-notice="empty_license">
		<input type="hidden" id="at_notices_nonce" name="at_notices_nonce" value="<?php echo wp_create_nonce('at_notices_nonce'); ?>" />
		<p><?php _e( 'You might be missing important updates and new features by not activating your theme. Please activate it by', 'quadro'); ?> <a href="<?php echo admin_url( 'themes.php?page=quadro-settings' ); ?>"><?php _e('completing your license details here.', 'quadro' ); ?></a></p>
	</div>
	<?php
}


// Throw a notice if license is expired
function at_expired_license_notice() {

	// Only for testing purposes. Leave commented.
	// delete_transient( 'expired_license_check' );

	// Perform checks only once every 12 hours
	if ( false === get_transient( 'expired_license_check' ) ) {

		global $quadro_options;

		// Define empty variable to prevent errors
		$response = '';

		// Don't show the notice if no field is completed (we show the previous one)
		if ( $quadro_options['quadro_username'] === '' || $quadro_options['quadro_userpass'] === '' || $quadro_options['quadro_userlicense'] === '' ) return false;

		// Check for license expiration
		$check_url = 'https://artisanthemes.io/api/theme-updates-check';
		
		$send_for_check = array(
			'body' => array(
				'item_slug' 	=> get_option('template'),
				'username' 		=> $quadro_options['quadro_username'],
				'userpass' 		=> $quadro_options['quadro_userpass'],
				'license' 		=> $quadro_options['quadro_userlicense'],
				'domain' 		=> esc_url( $_SERVER['SERVER_NAME'] ),
			)
		);

		$raw_response = wp_remote_post($check_url, $send_for_check);
		
		if ( !is_wp_error($raw_response) && isset($raw_response['response']) && $raw_response['response']['code'] == 200 ) {
			// remove SSL message from response
			$response = str_replace( '<!-- Really Simple SSL mixed content fixer active -->', '', $raw_response['body'] );
		}

		// Set License Expiration Check Transient
		set_transient( 'expired_license_check', $response, 12 * HOUR_IN_SECONDS );

	} else {

		// Output cached notice
		$response = wp_kses_post( get_transient( 'expired_license_check' ) );

	}

	// If response is 'ok' we don't show the notice
	if ( $response == 'ok' ) return false;
	
	?>
	<div class="at-admin-notice notice notice-error is-dismissible" data-notice="expired_license">

		<input type="hidden" id="at_notices_nonce" name="at_notices_nonce" value="<?php echo wp_create_nonce('at_notices_nonce'); ?>" />

		<?php if ( $response == 'The password for this user does not match the registered password.' ) { ?>
			<p><?php _e( 'You might be missing important updates and new features by not activating your theme. Please', 'quadro'); ?> <a href="<?php echo admin_url( 'themes.php?page=quadro-settings' ); ?>"><?php _e('make sure the password on your license details is correct.', 'quadro' ); ?></a></p>
		<?php } else if ( $response == 'This is not a valid username. Please make sure you are registered at artisanthemes.io before going on.' ) { ?>
			<p><?php _e( 'You might be missing important updates and new features by not activating your theme. Please', 'quadro'); ?> <a href="<?php echo admin_url( 'themes.php?page=quadro-settings' ); ?>"><?php _e('make sure the username on your license details is correct.', 'quadro' ); ?></a></p>
		<?php } else if ( $response == 'This theme has not been registered for this user yet. Please login at https://artisanthemes.io and register it at your profile section.' ) { ?>
			<p><?php _e( 'You might be missing important updates and new features by not activating your theme. Please', 'quadro'); ?> <a href="<?php echo admin_url( 'themes.php?page=quadro-settings' ); ?>"><?php _e('make sure the license ID on your license details is correct.', 'quadro' ); ?></a></p>
		<?php } else if ( $response == "This license isn't active right now. Please renew it to keep the theme updated." ) { ?>
			<p><?php _e( 'Your theme license is expired. To avoid missing important updates and new features,', 'quadro'); ?> <a href="https://artisanthemes.io/dashboard"><?php _e('renew it here.', 'quadro' ); ?></a>
				<br /><?php _e('(This message will refresh after some hours)', 'quadro' ); ?>
			</p>
		<?php } else { ?>
			<p><?php echo $response; ?></p>
		<?php } ?>
	
	</div>
	<?php
	
}


// Function to handle the storing of notices dissmisions
function at_notices_dismiss() {

	// Check nonce first
	$nonce = esc_attr( $_POST['security'] );
	if ( ! wp_verify_nonce( $nonce, 'at_notices_nonce' ) ) die( '-1' );

	$notice = esc_attr( $_POST['notice'] );

	if ( $notice == 'empty_license' ) {
		set_transient( 'empty_license_dismissed', true, 1 * DAY_IN_SECONDS );
	}
	elseif ( $notice == 'expired_license' ) {
		set_transient( 'expired_license_dismissed', true, 6 * DAY_IN_SECONDS );
	}

	die();

}
add_action('wp_ajax_at_notices_dismiss', 'at_notices_dismiss');


// Refresh license check transients when options saved
function at_refresh_license_checks() {
	delete_transient( 'expired_license_check' );
}
// add_action( 'at_theme_options_updated_general', 'at_refresh_license_checks' );