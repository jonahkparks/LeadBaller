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

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php'))
{
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

use Inc\Activate;
use Inc\Deactivate;

if (!class_exists('LBQuickBase')) {
    class LBQuickBase
    {
        private $plugin;
        private $auth_token = '';
        private const CAMPAIGN_PROD = 'brx55z77r';
        private const CAMPAIGN_TEST = 'br4n2s75h';
        private const PROSPECTS_PROD = 'brx55z79y';
        private const PROSPECTS_TEST = 'br4n2s75y';
        private const ENVIRONMENT = 'test';

        function __construct() {
            $this->$plugin = plugin_basename( __FILE__ );
        }

        public function register()
        {
            // Add admin pages
            add_action('admin_menu', array($this, 'add_admin_pages'));

            add_filter('plugin_action_links' . $plugin, array($this, 'settings_link'));

            // Add shortcode for client logo
            add_shortcode('qb-client-logo', 'load_client_logo');

            // Add shortcode for client calendly
            add_shortcode('qb-client-calendly', 'load_client_calendly');

            // Add shortcode for prospect video
            add_shortcode('qb-prospect-video', 'load_prospect_video');
        }

        public function activate()
        {
            Activate::activate();
        }

        public function add_admin_pages()
        {
            add_menu_page('LB QuickBase Plugin', 'QuickBase', 'manage_options', 'lbqbplugin', array($this, 'admin_index'), 'dashicons-database', 110);
        }

        public function admin_index()
        {
            require_once plugin_dir_path(__FILE__) . 'templates/admin.php';
        }

        public function settings_link( $links )
        {
            $settings_link = '<a href="admin.php?page=lbqbplugin">Settings</a>';
            array_push( $links , $settings_link );
            return $links;
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

    $lbqbplugin = new LBQuickBase();
    $lbqbplugin->register();

    // activation
    register_activation_hook(__FILE__, array( $lbqbplugin, 'activate'));

    // deactivation
    register_deactivation_hook(__FILE__, array( 'Deactivate', 'deactivate'));
}
