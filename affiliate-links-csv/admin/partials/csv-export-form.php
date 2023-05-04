<?php
$export_url = admin_url('edit.php?post_type=affiliate-links&page=affiliate-links-csv&action=export_csv&_wpnonce=' . wp_create_nonce('affil_links_export_nonce'));
?>
<form method="get" enctype="multipart/form-data">
    <h2><?php _e('Export affiliate links to a CSV file', 'affiliate-links-csv'); ?></h2>
    <a href="<?php echo esc_url($export_url); ?>" class="button button-primary"><?php _e('Export CSV-file', 'affiliate-links-csv'); ?></a>
</form>
