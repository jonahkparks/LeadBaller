<?php
/**
 * @package email-landing-plugin
 *
 */

namespace Inc\Base;

use Inc\API\QuickBaseRestApi;

class BaseShortcode
{
    public $lb_redirect;
    public $app_token;
    public $realm;
    public $user_token;
    public $user_agent;
    public $merge_url;
    public $active_option = array();

    public function __construct() 
    {
        $this->lb_redirect = "https://www.leadballer.com";

        $this->merge_url = $this->getMergeURLID();

        $this->active_option = $this->getActiveOption();

        $this->app_token = '';
        $this->realm = $this->active_option['realm_name'];
        $this->user_token = $this->active_option['app_token'];
        $this->user_agent = '';
    }

    public function getMergeURLID()
    {
        // if no ID is passed in the URL, redirect to the LeadBaller website
        if (!isset($_GET['id']))
        {
            $this->redirect();
            return;
        }
        
        return base64_decode($_GET['id']);
    }

    public function redirect()
    {
        global $post;
        if (isset($post->post_name) && $post->post_name == 'booking') {
            echo '<script>window.location.replace("' . $this->lb_redirect . '");</script>';
        }
    }

    public function decodeID()
    {
        return base64_decode($_GET['id']);
    }

    public function getActiveOption()
    {
        $active_option = array();

        $options = get_option( 'email_landing_options' );

        // If no configured options are defined for the plugin, redirect to the LeadBaller website
        if ( count($options) === 0 )
        {
            $this->redirect();
            exit;
        }

        foreach ($options as $key => $value) 
        {
            if (isset($options[$key]['is_active'])) {
                $active_option = $options[$key];
            }
        }

        return $active_option;
    }

    public function queryForSingleValue( string $table, string $queryFor, string $where )
    {
        $data_array = array();
        $output = '';

        $query_table = $this->active_option[$table];
        $select = array($this->active_option[$queryFor]);

        $QuickBaseAPI = new QuickBaseRestAPI($this->user_token, $this->app_token, $this->realm, $this->user_agent);

        $response = $QuickBaseAPI->query_for_data($query_table, $select , $where);

        // if no response is returned, redirect to the LeadBaller website
        if ( empty(json_decode($response, true)['data']) ) {
            $this->redirect();
            exit;
        }

        $data_array = json_decode($response, true)['data'];

        $output = $data_array['0'][$this->active_option[$queryFor]]['value'];

        return $output;
    }
}