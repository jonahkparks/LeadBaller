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

    public function adminSection()
    {
        echo 'Here you can select the LeadBaller QuickBase environment to use.<br />  Please <strong>do not</strong> change unless you know what you are doing!';
    }

    public function textExample()
    {
        $value = esc_attr(get_option('text_example'));
        echo '<input type="text" class="regular-text" name="text_example" value="' . $value . '" placeholder="Write something here">';
    }

    public function firstName()
    {
        $value = esc_attr(get_option('first_name'));
        echo '<input type="text" class="regular-text" name="first_name" value="' . $value . '" placeholder="Write your first name">';
    }

    public function environmentChoice()
    {
        $value = esc_attr(get_option('environment_choice'));
        ?>
            Value = <?php echo $value ?><br />
            <select name="environment_choice" id="environment_choice">
                <option value="test" <?php selected( $value, "test" ); ?>>Test</option>
                <option value="production" <?php selected( $value, "Production" ); ?>>Production</option>
            </select>
        <?php
    }
}
