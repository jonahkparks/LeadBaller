<?php
/**
 * @package email-landing-plugin
 *
 */

namespace Inc\Base;

class Deactivate
{
    public static function deactivate()
    {
        // Flush rewrite rules
        flush_rewrite_rules();
    }
}
