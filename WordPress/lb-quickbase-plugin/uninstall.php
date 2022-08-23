<?php

/**
 * Trigger this file on uninstall of the plugin
 *
 * @package lb-quickbase-plugin
 */

if (! defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Clear database-stored data
$clients = get_posts(array(
   'post_type' => 'Clients',
   'numberposts' => -1
));

foreach ($clients as $client) {
    wp_delete_post($client->ID, true);
}

$qbTables = get_posts(array(
   'post_type' => 'QuickBase Tables',
   'numberposts' => -1
));

foreach ($qbTables as $qbTable) {
    wp_delete_post($qbTable->ID, true);
}
