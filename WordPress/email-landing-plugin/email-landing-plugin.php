<?php
/**
 * @package email-landing-plugin
 *
 * Plugin Name: LeadBaller Email Landing Plugin
 * Description: Provides widgets for Email Campaign landing pages
 * Version: 1.0.0
 * Author: Jeremy Lahners
 * Text Domain: email-landing-plugin
 */

// Exit out of the code if a user attempts to access the plugin directly
if (!defined('ABSPATH')) {
    exit;
}

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php'))
{
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

function activate_email_landing_plugin() 
{
    Inc\Base\Activate::activate();
}

register_activation_hook(__FILE__, 'activate_email_landing_plugin');

function deactivate_email_landing_plugin() 
{
    Inc\Base\Deactivate::deactivate();
}

register_deactivation_hook(__FILE__, 'deactivate_email_landing_plugin');

if (class_exists( 'Inc\\Init')) {
    Inc\Init::register_services();
}

