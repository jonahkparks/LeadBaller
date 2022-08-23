<?php
/**
 * @package lb-quickbase-plugin
 *
 * Plugin Name: LeadBaller QuickBase Plugin
 * Description: Handles basic communication with QuickBase
 * Version: 1.0.0
 * Author: Jeremy Lahners
 * Text Domain: leadballer-quickbase-plugin
 */

// Exit out of the code if a user attempts to access the plugin directly
if (!defined('ABSPATH')) {
    exit;
}

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php'))
{
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

function activate_lb_quickbase_plugin() 
{
    Inc\Base\Activate::activate();
}

register_activation_hook(__FILE__, 'activate_lb_quickbase_plugin');

function deactivate_lb_quickbase_plugin() 
{
    Inc\Base\Deactivate::deactivate();
}

register_deactivation_hook(__FILE__, 'deactivate_lb_quickbase_plugin');

if (class_exists( 'Inc\\Init')) {
    Inc\Init::register_services();
}

