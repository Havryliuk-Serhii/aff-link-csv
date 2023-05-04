<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Affiliate_Links_CSV_Importer {
	public function display_import_form() {
		require_once AFFILIATE_LINKS_CSV_PLUGIN_DIR . '/admin/partials/csv-import-form.php';
	}
	public function csv_import() {

		if ( isset( $_POST['import_submit'] ) && ! empty( $_FILES['import_csv']['tmp_name'] ) ) {
			// Verify nonce for security.
			check_admin_referer( 'affiliate_links_csv_import_nonce_action', 'affiliate_links_csv_import_nonce' );

			// Read the uploaded CSV file.
			$csv_file = $_FILES['import_csv']['tmp_name'];
			$file_handle = fopen( $csv_file, 'r' );

			// Initialize counters for imported and failed rows.
			$imported = 0;
			$failed = 0;

			// Skip the header row.
			$header = fgetcsv($file_handle);

			// Получение данных из базы данных
			global $wpdb;

			// Loop through each row of the file.
			while ( ( $row = fgetcsv( $file_handle, 1000, ',' ) ) !== false ) {
				// Assign values to variables.
				$post_id         = (int) $row[0];
				$post_title      = $row[1];
				$post_name       = $row[2];
				$post_content    = $row[3];
				$post_excerpt    = $row[4];
				$post_status     = $row[5];
				$comment_status  = $row[6];
				$post_type       = 'affiliate-links';
				$guid            = $row[8];

				// Create a new post or update the existing one.
				if ( ! $post_id || ( $post_id && ! get_post( $post_id ) ) )  {
					// Create a new post.
					$post_data = array(
						'post_title'    => $post_title,
						'post_name'     => $post_name,
						'post_content'  => $post_content,
						'post_excerpt'  => $post_excerpt,
						'post_status'   => $post_status,
						'comment_status'=> $comment_status,
						'post_type'     => $post_type,
						'guid'          => $guid,
					);
					$insert_result = wp_insert_post($post_data, true);

					if ( !is_wp_error($insert_result) ) {
						$imported++;
					} else {
						$failed++;
					}
				} else {
					// Update the existing post.
					$post_data = array(
						'ID'            => $post_id,
						'post_title'    => $post_title,
						'post_name'     => $post_name,
						'post_content'  => $post_content,
						'post_excerpt'  => $post_excerpt,
						'post_status'   => $post_status,
						'comment_status'=> $comment_status,
						'post_type'     => $post_type,
						'guid'          => $guid,
					);
					$update_result = wp_update_post($post_data, true);

					if ( !is_wp_error($update_result) ) {
						$imported++;
					} else {
						$failed++;
					}
				}
			}
			fclose( $file_handle );

			// Display an admin notice with the import results.
			add_action( 'admin_notices', function () use ( $imported, $failed ) {
				$message = sprintf( __( 'Affiliate links import completed. Imported: %d, Failed: %d', 'affiliate-links-csv' ), $imported, $failed );
				echo '<div class="notice notice-success is-dismissible"><p>' . $message . '</p></div>';
			});
		}

		// Display the import form.
		$this->display_import_form();
	}
}
