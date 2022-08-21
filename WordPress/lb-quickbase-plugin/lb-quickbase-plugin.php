<?php
/**
 * @package lb-quickbase-plugin
 *
 * Plugin Name: LeadBaller QuickBase Plugin
 * Description: Handles basic communication with QuickBase
 * Version: 1.0.0
 * Author: Jeremy Lahners
 * Text Domain: leadballer-quickbase-plugin
 */

// Exit out of the code if a user attempts to access the plugin directly
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('LBQuickBasePlugin')) {
    class LBQuickBasePlugin
    {
        private $auth_token = '';
        private const CAMPAIGN_PROD = 'brx55z77r';
        private const CAMPAIGN_TEST = 'br4n2s75h';
        private const PROSPECTS_PROD = 'brx55z79y';
        private const PROSPECTS_TEST = 'br4n2s75y';
        private const ENVIRONMENT = 'test';

        public function __construct()
        {
            // Create custom post type
            add_action('init', array($this, 'create_custom_post_type'));

            /*
            // Add assets (js, css, etc)
            add_action('wp_enqueue_scripts', array($this, 'load_assets'));

            // Add shortcode
            add_shortcode( 'load-quickbase', 'load_shortcode' );

            // Load javascript
            add_action('wp_footer', array($this, 'load_scripts'));

            // Register REST API
            add_action('rest_api_init', array($this, 'register_rest_api'));
            */

            // Add shortcode for client logo
            add_shortcode('qb-client-logo', 'load_client_logo');

            // Add shortcode for client calendly
            add_shortcode('qb-client-calendly', 'load_client_calendly');

            // Add shortcode for prospect video
            add_shortcode('qb-prospect-video', 'load_prospect_video');
        }

        public function activate()
        {
            // Generate CPTs
            $this->create_custom_post_type();

            // Flush rewrite rules
            flush_rewrite_rules();
        }

        public function deactivate()
        {
            // flush rewrite rules
            flush_rewrite_rules();
        }

        private function get_authentication_token($tableName, $environment)
        {
            $tableId = 'Undefined';

            if ($tableName == 'Campaigns') {
                if ($environment == 'Test') {
                    $tableId = $CAMPAIGN_TEST;
                } elseif ($environment == 'Prod') {
                    $tableId = $CAMPAIGN_PROD;
                }
            } elseif ($tableName == 'Prospects') {
                if ($environment == 'Test') {
                    $tableId = $PROSPECTS_TEST;
                } elseif ($environment == 'Prod') {
                    $tableId = $PROSPECTS_PROD;
                }
            }

            if ($tableId == 'Undefined') {
                exit;
            }

            /*
            $headers = array
            {
                'QB-Realm-Hostname' => 'leadballer.quickbase.com',
                'Content-Type' => 'application/json'
            }
            var internalTable = '';

            if (qbTable = 'campaigns') {
                internalTable = (prodInstance = "yes" ? campaignsProd : campaignsTest );
            }
            var headers = {
                'QB-Realm-Hostname': 'leadballer.quickbase.com',
                'Content-Type': 'application/json'
            };

            var authToken = '';

            $.ajax({
                url: 'https://api.quickbase.com/v1/auth/temporary/' + internalTable,
                method: 'GET',
                async: false,
                headers: headers,
                xhrFields: { withCredentials: true },
                success: function(result) {
                    authToken = result.temporaryAuthorization;
                }
            })
            */
        }

        public function load_prospect_video($prospectId)
        {
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

        public function load_assets()
        {
            wp_enqueue_style(
                'lb-quickbase-plugin-css',
                plugin_dir_url(__FILE__) . 'css/lb-quickbase.css',
                array(),
                1,
                'all'
            );

            wp_enqueue_script(
                'lb-quickbase-plugin-js',
                plugin_dir_url(__FILE__) . 'js/lb-quickbase.js',
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

                var nonce = '<?php echo wp_create_nonce('wp_rest');?>';

                (function($) {
                    $('#quickbase-plugin__form').submit( function(event) {
                        event.preventDefault();

                        var form = $(this).serialize();

                        $.ajax({
                            method: 'post',
                            url: '<?php echo get_rest_url(null, 'lb-quickbase-plugin/v1/send-query');?>',
                            headers: { 'X-WP-Nonce': nonce },
                            data: form
                        })
                    })
                })
            </script>
        <?php }

        public function register_rest_api()
        {
            register_rest_route('lb-quickbase-plugin/v1', 'send-query', array(
                'methods' => 'POST',
                'callback' => array($this, 'handle_quickbase_query')
            ));
        }

        public function handle_quickbase_query($data)
        {
            $headers = $data->get_headers();
            $params = $data->get_params();

            $nonce = $headers['x_wp_nonce'][0];

            if (!wp_verify_nonce($nonce, 'wp_rest')) {
                return new WP_REST_Response('Invalid Details', 422);
            }

            $post_id = wp_insert_post([
                'post_type' => 'quickbase_plugin_form',
                'post_title' => 'Query',
                'post_status' => 'publish'
            ]);

            return new WP_REST_Response('Thank you', 200);
        }
    }

    $lbqbplugin = new LBQuickBasePlugin();
}

// activation
register_activation_hook(__FILE__, array( $lbqbplugin, 'activate'));

// deactivation
register_deactivation_hook(__FILE__, array( $lbqbplugin, 'deactivate'));
