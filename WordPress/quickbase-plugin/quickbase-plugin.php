<?php
/**
 * Plugin Name: LeadBaller QuickBase Plugin
 * Description: Handles basic communication with QuickBase
 * Version: 1.0.0
 * Author: Jeremy Lahners
 * Text Domain: leadballer-quickbase-plugin
 */

 // Exit out of the code if a user attempts to access the plugin directly
 if( !defined('ABSPATH'))
 {
    exit;
 }

 class QuickBasePlugin {

    public function __construct()
    {
        // Create custom post type
        add_action('init', array($this, 'create_custom_post_type'));

        // Add assets (js, css, etc)
        add_action('wp_enqueue_scripts', array($this, 'load_assets'));
    }

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

        register_post_type('quickbase_plugin', $args);
    }

    public function load_assets() 
    {
        wp_enqueue_style( 'quickbase-plugin-css', plugin_dir_url( __FILE__ ) . 'css/quickbase.css', array(), 1, 'all'' );
    }
 }

 new QuickBasePlugin();

 // Remove the admin bar from the front end
 add_filter( 'show_admin_bar', '__return_false');