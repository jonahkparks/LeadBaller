<?php
/**
 * @package lb-quickbase-plugin
 *
 */

namespace Inc;

final class Init
{
    /**
     * Store all the classes inside an array
     * @return array of classes
     */
    public static function get_services()
    {
        return [
            Pages\Admin::class,
            Base\Enqueue::class,
            Base\SettingsLink::class
        ];
    }

    /**
     * Loop through all the classes and initialize them
     */
    public static function register_services()
    {
        foreach (self::get_services() as $class) {
            $service = self::instantiate($class);
            if (method_exists($service, 'register')) {
                $service->register();
            }
        }
    }

    /**
     * Initialize the class
     */
    private static function instantiate ($class)
    {
        $service = new $class();

        return new $service;
    }
}

/*

use Inc\Base\Activate;
use Inc\Base\Deactivate;
use Templates\Admin;

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
/*        }

        public function load_prospect_video($prospectId)
        {
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
}
*/
