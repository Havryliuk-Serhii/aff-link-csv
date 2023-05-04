<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * The Affiliate Links CSV Class.
 */
class Affiliate_Links_CSV {
	public function __construct() {
		$this->load_dependencies();
	}

	private function load_dependencies() {
		require_once AFFILIATE_LINKS_CSV_PLUGIN_DIR . '/admin/class-affiliate-links-csv-admin.php';
		require_once AFFILIATE_LINKS_CSV_PLUGIN_DIR . '/includes/class-affiliate-links-csv-importer.php';
		require_once AFFILIATE_LINKS_CSV_PLUGIN_DIR . '/includes/class-affiliate-links-csv-exporter.php';
	}

	public function run() {
		$exporter = new Affiliate_Links_CSV_Exporter();
		add_action('admin_menu', array($exporter, 'handle_export_action'), 1);
		(new Affiliate_Links_CSV_Admin())->add_hooks();
	}
}
