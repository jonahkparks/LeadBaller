<?php
/**
 * @package email-landing-plugin
 *
 */

namespace Inc\Base;

class Activate
{
    public static function activate()
    {
        flush_rewrite_rules();

        $defaults = array();

        if ( !get_option( 'email_landing_options' )) {
            update_option( 'email_landing_options', $defaults );
        }
    }
}
