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
        $settings_options = get_option( 'settings_option_name' );
        $value = esc_attr($settings_options['text_example']);

        ?>
			<input class="regular-text" type="text" name="settings_option_name[text_example]" id="text_example" value="<?php echo $value ?>">
		<?php
    }

    public function firstName()
    {
        $settings_options = get_option( 'settings_option_name' );
        $value = esc_attr($settings_options['first_name']);

        ?>
			<input class="regular-text" type="text" name="settings_option_name[first_name]" id="first_name" value="<?php echo $value ?>">
		<?php
    }

    public function environmentChoice()
    {
        $settings_options = get_option( 'settings_option_name' );
        $value = esc_attr($settings_options['environment_choice']);
        
        ?>
            <select name="settings_option_name[environment_choice]" id="environment_choice">
                <?php $selected = ($value === 'test') ? 'selected' : '' ; ?>
                <option value="test" <?php echo $selected; ?>>Test</option>
                <?php $selected = ($value === 'production') ? 'selected' : '' ; ?>
                <option value="production" <?php echo $selected; ?>>Production</option>
            </select> 
        <?php
    }
}
