<?php
/**
 * @package email-landing-plugin
 *
 */

namespace Inc\Base;

use Inc\API\QuickBaseRestApi;

class LogoShortcode extends BaseShortcode
{
    public function register()
    {
        add_shortcode('clientLogo', array($this, 'logoCode'));
    }

    public function logoCode()
    {
        $output = '';

        $where = "{" . $this->active_option['merge_url_field'] . ".EX.'" . $this->merge_url . "'}";
        $campaign_id =  $this->queryForSingleValue( 'prospects_table', 'related_campaign_field', $where);


        $where = "{" . $this->active_option['campaign_id'] . ".EX." . $campaign_id . "}";
        $logo_url = $this->queryForSingleValue( 'campaign_table', 'client_logo', $where );

        $output = '<img src="'. $logo_url . '" width="150">';

        return $output;
    }
}