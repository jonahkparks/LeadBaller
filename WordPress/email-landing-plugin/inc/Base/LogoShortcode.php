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

        $app_token = $active_option['app_token'];
        $realm = $active_option['realm_name'];
        $user_token = '';
        $user_agent = '';

        $query_table = $active_option['prospects_table'];
        $select = array($active_option['related_campaign_field']);
        $merge_url = base64_decode($_GET['id']);
        $where = '{' . $active_option['merge_url_field'] . '.EX.' . $merge_url . '}';

        $QuickBaseAPI = new QuickBaseRestAPI($user_token, $app_token, $realm, $user_agent);
        $QuickBaseAPI->get_and_set_temporary_access_token($query_table);
        $campaign_id = $QuickBaseAPI->query_for_data($query_table, $select , $where);

        $query_table = $active_option['campaign_table'];
        $select = array($active_option['client_logo']);
        $where = '{' . $active_option['campaign_id'] . '.EX.' . $campaign_id . '}';

        $QuickBaseAPI->get_and_set_temporary_access_token($query_table);
        $logo_url = $QuickBaseAPI->query_for_data($query_table, $select , $where);

        if (isset($logo_url))
        {
            $output = '<img src="'. $logo_url . '">';
        }

        return $output;
    }
}