<form action="" method="post" enctype="multipart/form-data">
	<?php wp_nonce_field('affil_links_export_nonce'); ?>
	<h2><?php _e('Export affiliate links to a CSV file', 'affiliate-links-csv'); ?></h2>
    <input type="hidden" name="action" value="affiliate_links_csv_export">
	<input type="submit" name="export_csv" value="<?php _e('Export CSV-file', 'affiliate-links-csv'); ?>"
           class="button button-primary">
</form>


