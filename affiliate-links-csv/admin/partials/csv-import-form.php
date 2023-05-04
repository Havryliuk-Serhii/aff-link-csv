<?php

?>
<form action="" method="post" enctype="multipart/form-data">
    <h2><?php _e( 'Import affiliate links from a CSV file', 'affiliate-links-csv' ); ?></h2>
	<?php wp_nonce_field( 'affiliate_links_csv_import_nonce_action', 'affiliate_links_csv_import_nonce' ); ?>
	<input type="file" name="import_csv" accept=".csv" required>
	<input type="submit" name="import_submit" value="<?php _e( 'Import', 'affiliate-links-csv' ); ?>" class="button button-primary">
</form>
