<?php
/**
 * @package email-landing-plugin
 *
 */

namespace Inc\Base;

class BaseController
{
    public $plugin_path;
    public $plugin_url;
    public $plugin_name;
    public $plugin_basename;
    public $managers = array();

    public function __construct()
    {
        $this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
        $this->plugin_url = plugin_dir_url(dirname(__FILE__, 2));
        $this->plugin_basename = plugin_basename(dirname(__FILE__, 3));
        $this->plugin_name = "$this->plugin_basename/$this->plugin_basename.php";

        $this->managers = array(
        );
    }

    public function activated( string $key )
	{
		$option = get_option( 'qb_settings_admin' );

		return isset( $option[ $key ] ) ? $option[ $key ] : false;
	}
}