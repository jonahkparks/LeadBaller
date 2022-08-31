<?php
/**
 * @package email-landing-plugin
 *
 */

namespace Inc\Base;

use Inc\API\QuickBaseRestApi;

class LogoShortcode
{
    public function register()
    {
        add_shortcode('clientLogo', array($this, 'logoCode'));
    }

    public function logoCode()
    {
        if (!isset($_GET['id']))
        {
            return;
        }

        $merge_url = base64_decode($_GET['id']);

        $active_option = array();
        $output = '';

        $options = get_option( 'email_landing_options' );

        if ( count($options) === 0 )
        {
            return;
        }

        foreach ($options as $key => $value) 
        {
            if (isset($options[$key]['is_active'])) {
                $active_option = $options[$key];
            }
        }

        $app_token = '';
        $realm = $active_option['realm_name'];
        $user_token = $active_option['app_token'];
        $user_agent = '';

        $query_table = $active_option['prospects_table'];
        $select = array($active_option['related_campaign_field']);
        $merge_url = base64_decode($_GET['id']);
        $where = "{" . $active_option['merge_url_field'] . ".EX.'" . $merge_url . "'}";

        $QuickBaseAPI = new QuickBaseRestAPI($user_token, $app_token, $realm, $user_agent);

        $response = $QuickBaseAPI->query_for_data($query_table, $select , $where);
        $campaign_id = json_decode($response, true)['data']['0'][$active_option['related_campaign_field']]['value'];

        $query_table = $active_option['campaign_table'];
        $select = array($active_option['client_logo']);
        $where = "{" . $active_option['campaign_id'] . ".EX." . $campaign_id . "}";

        $response = $QuickBaseAPI->query_for_data($query_table, $select , $where);
        $logo_url = json_decode($response, true)['data']['0'][$active_option['client_logo']]['value'];

        if (isset($logo_url))
        {
            $output = '<img src="'. $logo_url . '">';
        }

        return $output;
    }

    public function debug_to_console($data) 
  {
    $output = $data;
    if (is_array($output)) {
        $output = implode(',', $output);
    }

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";

  }
}