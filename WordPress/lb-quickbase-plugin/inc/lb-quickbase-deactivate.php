<?php
/**
 * @package lb-quickbase-plugin
 *
 */

 class LBQuickBaseDeactivate
 {
    public static function deactivate()
    {
        // Flush rewrite rules
        flush_rewrite_rules();
    }
 }
