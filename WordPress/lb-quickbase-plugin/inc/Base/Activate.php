<?php
/**
 * @package lb-quickbase-plugin
 *
 */

namespace Inc\Base;

class Activate
{
    public static function activate()
    {
        // Generate CPTs
        //$this->create_custom_post_type();

        // Flush rewrite rules
        flush_rewrite_rules();
    }

    /*
    public function create_custom_post_type()
    {
        $args = array(
            'public' => true,
            'has_archive' => true,
            'supports' => array('title'),
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'capability' => 'manage_options',
            'labels' => array(
                'name' => 'Clients',
                'singular_name' => 'Client Entry'
            ),
            'menu_icon' => 'dashicons-businessperson'
        );

        register_post_type('Clients', $args);

        $args = array(
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'environment', 'tableId'),
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'capability' => 'manage_options',
            'labels' => array(
                'name' => 'QuickBase Tables',
                'singular_name' => 'QuickBase Table'
            ),
            'menu_icon' => 'dashicons-database'
        );

        register_post_type('QuickBase Tables', $args);
    }
    */
}
