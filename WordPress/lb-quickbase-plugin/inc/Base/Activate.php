<?php
/**
 * @package lb-quickbase-plugin
 *
 */

namespace Inc\Base;

class Activate
{
    public static function activate()
    {
        flush_rewrite_rules();

        if ( get_option( 'qb_settings_admin' )) {
            return;
        }

        $admin_defaults = array();

        update_option( 'qb_settings_admin', $admin_defaults );
    }
}
