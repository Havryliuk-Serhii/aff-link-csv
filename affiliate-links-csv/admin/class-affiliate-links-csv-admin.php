<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Affiliate_Links_CSV_Admin {
	public function add_hooks() {
		// Add a new submenu item under the main Affiliate Links menu.
		add_action( 'admin_menu', array( $this, 'add_submenu_page' ) );
	}

	public function add_submenu_page() {
		add_submenu_page(
			'edit.php?post_type=affiliate-links',
			__( 'Import/Export CSV', 'affiliate-links-csv' ),
			__( 'Import/Export CSV', 'affiliate-links-csv' ),
			'manage_options',
			'affiliate-links-csv',
			array( $this, 'submenu_page_callback' )
		);
	}

	public function submenu_page_callback() {
		?>
        <h1><?php _e('Import/Export Affiliate Links', 'affiliate-links-csv'); ?></h1>
        <div class="wrap">
			<?php settings_errors();
			(new Affiliate_Links_CSV_Importer())->affiliate_links_process_csv_import();
			(new Affiliate_Links_CSV_Exporter())->display_export_form();
			?>
        </div>
		<?php
	}
}
