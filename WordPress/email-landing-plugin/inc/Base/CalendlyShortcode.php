<?php
/**
 * @package email-landing-plugin
 *
 */

namespace Inc\Base;

use Inc\API\QuickBaseRestApi;

class CalendlyShortcode extends BaseShortcode
{
    public function register()
    {
        add_shortcode('calendlyEmbed', array($this, 'calendlyCode'));
    }

    public function calendlyCode()
    {
        $where = "{" . $this->active_option['merge_url_field'] . ".EX.'" . $this->merge_url . "'}";
        $campaign_id =  $this->queryForSingleValue( 'prospects_table', 'related_campaign_field', $where);


        $where = "{" . $this->active_option['campaign_id'] . ".EX." . $campaign_id . "}";
        $calendly_embed = $this->queryForSingleValue( 'campaign_table', 'calendly_field', $where );

        return $calendly_embed;
    }
}