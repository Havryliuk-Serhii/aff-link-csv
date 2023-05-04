<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
	die();
}

class Affiliate_Links_CSV_Exporter {

	public function handle_export_action() {
		global $pagenow;

		if ($pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'affiliate-links' && isset($_GET['page']) && $_GET['page'] == 'affiliate-links-csv' && isset($_GET['action']) && $_GET['action'] == 'export_csv' && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'affil_links_export_nonce')) {
			$this->export_csv();
			exit;
		}
	}

	public function display_export_form() {
		require_once AFFILIATE_LINKS_CSV_PLUGIN_DIR . '/admin/partials/csv-export-form.php';
	}

	public function export_csv() {
		global $wpdb;
		$affiliate_links = $wpdb->get_results("SELECT * FROM {$wpdb->posts} WHERE post_type = 'affiliate-links'");

		// Specifying headers for a csv-file
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename=affiliate_links.csv');
		header('Cache-Control: no-cache, no-store, must-revalidate');
		header('Pragma: no-cache');
		header('Expires: 0');

		// Create a csv-file
		$file = fopen('php://output', 'w');
		fputcsv($file, array('ID', 'Post_Title', 'Post_name', 'Post_Content', 'Post_excerpt', 'Post_status', 'Comment_status', 'Post_type', 'Guid' ));

		// Filling the file with data
		foreach ($affiliate_links as $row) {
			fputcsv($file, array($row->ID, $row->post_title, $row->post_name, $row->post_content, $row->post_excerpt,
				$row->post_status, $row->comment_status, $row->post_type, $row->guid ));
		}

		fclose($file);
	}
}
