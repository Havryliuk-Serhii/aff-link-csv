<?php
/*
Plugin Name: Affiliate Links Import/Export in CSV files
Description: An extension for the Affiliate Links plugin that allows you to import and export entered links in CSV files.
Version: 1.0
Author: Serhii Havryliuk
*/
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die();
}


define( 'AFFILIATE_LINKS_CSV_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'AFFILIATE_LINKS_CSV_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Check if the main Affiliate Links plugin is active
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'affiliate-links/affiliate-links.php' ) ) {
	require_once AFFILIATE_LINKS_CSV_PLUGIN_DIR . 'includes/class-affiliate-links-csv.php';

	// Begins execution of the extension plugin.
	$Affiliate_Links_CSV = new Affiliate_Links_CSV();
	$Affiliate_Links_CSV -> run();

	/**
	 * Activation/deactivation stuff
	 */
	register_activation_hook( __FILE__, 'csv_activate' );
	register_deactivation_hook( __FILE__, 'csv_deactivate' );

	function csv_activate(){
		do_action( 'csv_activate' );
	}

	function csv_deactivate() {
		remove_action( 'csv_activate', array( 'Affiliate_Links_CSV', 'activate' ) );
	}

} else {
	// Display a notice to inform the user that the main Affiliate Links plugin is required for this extension to work.
	add_action( 'admin_notices', 'affiliate_links_csv_required_notice' );
}

function affiliate_links_csv_required_notice() {
	$message = __( 'The Affiliate Links CSV plugin requires an activated Affiliate Links plugin to work. Please activate the Affiliate Links plugin.', 'affiliate-links-csv' );
	echo '<div class="notice notice-error is-dismissible"><p>' . $message . '</p></div>';
}
