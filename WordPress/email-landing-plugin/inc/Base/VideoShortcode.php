<?php
/**
 * @package email-landing-plugin
 *
 */

namespace Inc\Base;

use Inc\API\QuickBaseRestApi;

class VideoShortcode
{
    public function register()
    {
        add_shortcode('prospectVideo', array($this, 'videoCode'));
    }

    public function videoCode()
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
            return $output;
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
        $select = array($active_option['video_url_field']);
        $where = "{" . $active_option['merge_url_field'] . ".EX.'" . $merge_url . "'}";

        $QuickBaseAPI = new QuickBaseRestAPI($user_token, $app_token, $realm, $user_agent);

        $response = $QuickBaseAPI->query_for_data($query_table, $select , $where);
        $video_url = json_decode($response, true)['data']['0'][$active_option['video_url_field']]['value'];

        if (isset($video_url)) 
        {
            $output = '<video width="600" controls><source src="'. $video_url . '" type="video/mp4"></video>';
        }

        return $output;
    }
}