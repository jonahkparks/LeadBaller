<?php
/**
 * @package lb-quickbase-plugin
 *
 */

namespace Inc;

class Deactivate
{
    public static function deactivate()
    {
        // Flush rewrite rules
        flush_rewrite_rules();
    }
}
