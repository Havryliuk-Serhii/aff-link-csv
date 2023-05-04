<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Affiliate_Links_CSV_Importer {
	public function __construct() {
		$this->load_dependencies();
	}

	private function load_dependencies() {
		require_once AFFILIATE_LINKS_CSV_PLUGIN_DIR . '/admin/partials/csv-import-form.php';
	}
	public function affiliate_links_process_csv_import() {

	}
}
