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

        // Add shortcode
        add_shortcode( 'load-quickbase', 'load_shortcode' );

        // Load javascript
        add_action('wp_footer', array($this, 'load_scripts'));

        // Register REST API
        add_action('rest_api_init', array($this, 'register_rest_api'));
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

        register_post_type('quickbase_plugin_form', $args);
    }

    public function load_assets() 
    {
        wp_enqueue_style( 
            'quickbase-plugin-css', 
            plugin_dir_url( __FILE__ ) . 'css/quickbase.css', 
            array(), 
            1, 
            'all' 
        );

        wp_enqueue_script( 
            'quickbase-plugin-js', 
            plugin_dir_url( __FILE__ ) . 'js/quickbase.js', 
            array('jquery'), 
            1, 
            false
        );
    }

    public function load_shortcode()
    {

    }

    public function load_scripts()
    { ?>
        <script>

            var nonce = '<?php echo wp_create_nonce( 'wp_rest' );?>';

            (function($) {
                $('#quickbase-plugin__form').submit( function(event) {
                    event.preventDefault();

                    var form = $(this).serialize();

                    $.ajax({
                        method: 'post',
                        url: '<?php echo get_rest_url(null, 'quickbase-plugin/v1/send-query');?>',
                        headers: { 'X-WP-Nonce': nonce },
                        data: form
                    })
                })
            })
        </script>
    <?php }

    public function register_rest_api()
    {
        register_rest_route( 'quickbase-plugin/v1', 'send-query', array(
            'methods' => 'POST',
            'callback' => array($this, 'handle_quickbase_query')
        ));
    }

    public function handle_quickbase_query($data)
    {
        $headers = $data->get_headers();
        $params = $data->get_params();

        $nonce = $headers['x_wp_nonce'][0];

        if(!wp_verify_nonce( $nonce, 'wp_rest' ))
        {
            return new WP_REST_Response('Invalid Details', 422);
        }

        $post_id = wp_insert_post([
            'post_type' => 'quickbase_plugin_form',
            'post_title' => 'Query',
            'post_status' => 'publish'
        ])

        if($post_id) 
        {
            return new WP_REST_Response('Thank you', 200);
        }
    }
 }

 new QuickBasePlugin();
