<?php
/**
 * @package email-landing-plugin
 *
 */

namespace Inc\Base;

use Inc\API\QuickBaseRestApi;

class CalendlyShortcode
{
    public function register()
    {
        add_shortcode('calendlyEmbed', array($this, 'calendlyCode'));
    }

    public function calendlyCode()
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
        $select = array($active_option['calendly_field']);
        $where = "{" . $active_option['campaign_id'] . ".EX." . $campaign_id . "}";

        $response = $QuickBaseAPI->query_for_data($query_table, $select , $where);
        $calendly_embed = json_decode($response, true)['data']['0'][$active_option['calendly_field']]['value'];

        if (isset($calendly_embed))
        {
            $output = $calendly_embed;
        }

        return $output;
    }
}