<?php
/**
 * @package lb-quickbase-plugin
 *
 */

namespace Inc\Pages;

use \Inc\Base\BaseController;

class Admin extends BaseController
{
    public function register()
    {
        // Add admin pages
        add_action('admin_menu', array($this, 'add_admin_pages'));
    }

    public function add_admin_pages()
    {
        add_menu_page('LB QuickBase Plugin', 'QuickBase', 'manage_options', 'lbqbplugin', array($this, 'admin_index'), 'dashicons-database', 110);
    }

    public function admin_index()
    {
        require_once $this->plugin_path . 'templates/admin.php';
    }
}
