<?php
/**
 * @package email-landing-plugin
 *
 */

namespace Inc\Base;

use Inc\API\QuickBaseRestApi;

class VideoShortcode extends BaseShortcode
{
    public function register()
    {
        add_shortcode('prospectVideo', array($this, 'videoCode'));
    }

    public function videoCode()
    {
        $output = '';

        $where = "{" . $this->active_option['merge_url_field'] . ".EX.'" . $this->merge_url . "'}";
        $video_url =  $this->queryForSingleValue( 'prospects_table', 'video_url_field', $where);

        $output = '<video width="600" height="500" controls><source src="'. $video_url . '" type="video/mp4"></video>';

        return $output;
    }
}
