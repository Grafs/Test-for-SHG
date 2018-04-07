<?php
/*
Plugin Name: TestWP
Plugin URI:
Description: For a test task Skyline Health Group
Version: 0.1
Author: Oleg Medinskiy
Author URI:
Text Domain: testwp
Domain Path: /languages/
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.txt
*/

/** Plugin Dir Path */
define( 'TESTWP_EXT_DIR', str_replace( '\\', '/', plugin_dir_path( __FILE__ ) ) );

/** Plugin Url Path */
define( 'TESTWP_EXT_URL', str_replace( '\\', '/', plugin_dir_url( __FILE__ ) ) );

/** Require Custom Post Films */
require_once TESTWP_EXT_DIR . 'inc/custom_page_films.php';

/** Require Custom Meta Box */
require_once TESTWP_EXT_DIR . 'inc/custom_meta.php';

/** Require Woocommerce Filter for Films */
require_once TESTWP_EXT_DIR . 'inc/wc_filters.php';

/** Require Custom Registration Functions */
require_once TESTWP_EXT_DIR . 'inc/registration_form.php';



if( !function_exists('testwp_registration_redirect') ) {

	/**
	 * Redirect after registration
	 *
	 * @return string|void
	 */
	function testwp_registration_redirect() {
		return home_url( '/twfilmscat/all/' );
	}
	add_filter( 'registration_redirect', 'testwp_registration_redirect' );
}



if( !function_exists('testwp_redirect_add_to_cart') && in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );

	/**
	 * Redirect after press button Add to Cart
	 *
	 * @param $url
	 * @return string
	 */
	function testwp_redirect_add_to_cart( $url ) {
		return 'https://www.paypal.com/ua/home';
	}

	add_filter( 'add_to_cart_redirect', 'testwp_redirect_add_to_cart' );
}