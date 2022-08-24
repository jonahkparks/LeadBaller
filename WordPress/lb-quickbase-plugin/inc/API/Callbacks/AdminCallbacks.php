<?php
/**
 * @package lb-quickbase-plugin
 *
 */

namespace Inc\API\Callbacks;

use Inc\Base\BaseController;

class AdminCallbacks extends BaseController
{
    public function adminDashboard()
    {
        return require_once("$this->plugin_path/templates/admin.php");
    }

    public function environmentsPage()
    {
        return require_once("$this->plugin_path/templates/environments.php");
    }

    public function tablesPage()
    {
        return require_once("$this->plugin_path/templates/tables.php");
    }

    public function optionGroups($input)
    {
        return $input;
    }

    public function checkboxSanitize($input)
    {
        return $input;
    }

    public function adminSection()
    {
        echo 'Here you can select the LeadBaller QuickBase environment to use.<br />  Please <strong>do not</strong> change unless you know what you are doing!';
    }
}
