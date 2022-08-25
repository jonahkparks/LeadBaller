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

        $admin_defaults = array();

        if ( !get_option( 'qb_settings_admin' )) {
            update_option( 'qb_settings_admin', $admin_defaults );
        }

        if ( !get_option( 'qb_cpt_admin' )) {
            update_option( 'qb_cpt_admin', $admin_defaults );
        }
    }
}
