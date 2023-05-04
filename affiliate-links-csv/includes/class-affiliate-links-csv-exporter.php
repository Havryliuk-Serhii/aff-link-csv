<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Affiliate_Links_CSV_Exporter {
	public function __construct() {
		$this->load_dependencies();
		$this->affiliate_links_process_csv_export();
	}

	private function load_dependencies() {
		require_once AFFILIATE_LINKS_CSV_PLUGIN_DIR . '/admin/partials/csv-export-form.php';
	}

	public function affiliate_links_process_csv_export() {
		$nonce = isset( $_GET['_wpnonce'] ) ? $_GET['_wpnonce'] : '';
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'affil_links_export_nonce' ) ) {
				wp_die( 'Incorrect nonce' );
			}
			$this->export_csv();

	}
	public function export_csv() {
		ob_start();
		global $wpdb;
		$affiliate_links = $wpdb->get_results("SELECT * FROM {$wpdb->posts} WHERE post_type = 'affiliate-links'");
		$filename = "affiliate_links.csv";

		header('Content-Type: text/csv; charset=utf-8');
		header( 'Content-Description: File Transfer' );
		header('Content-Disposition: attachment;filename='. $filename);
		header('Cache-Control:must-revalidate, post-check=0, pre-check=0');
		header( 'Cache-Control: private', false );
		header('Pragma: no-cache');
		header('Expires: 0');

		$file = fopen('php://output', 'w');
		fputcsv($file, array('ID', 'Post_Title', 'Post_Content'));

		foreach ($affiliate_links as $row) {
			fputcsv($file, array($row->ID, $row->post_title, $row->post_content));
		}

		fclose($file);
		ob_end_flush();
		die();
	}
}
