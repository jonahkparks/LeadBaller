<?php
/**
 * @package lb-quickbase-plugin
 *
 */

namespace Inc\API\Callbacks;

use Inc\Base\BaseController;

class ManagerCallbacks extends BaseController
{
    public function checkboxSanitize($input)
    {
        $output = array();

        foreach ( $this->managers as $key => $value ) {
            $key = filter_var($key, FILTER_SANITIZE_STRING);
            $value = filter_var($value, FILTER_SANITIZE_STRING);

            $output[$key] = ( isset( $input[$key] ) && $input[$key] ) ? true : false;
        }

        return $output;
    }

    public function adminSectionManager($input)
    {
        echo 'Manage the Sections and Features of this Plugin by activating the checkboxes below';
    }

    public function checkboxField( $args)
    {
        $name = $args['label_for'];
        $classes = $args['class'];
        $option_group = $args['option_group'];
        $checkbox = get_option( $option_group );
        $checked = ( isset($checkbox[$name]) && $checkbox[$name] ? 'checked' : '');

        echo '<div class="' . $classes . '"><input type="checkbox" name="' . $option_group . '[' . $name . ']' . '" id="' . $name . '" value="1" ' . $checked .'><label for="' . $name .'"><div></div></label></div>';
    }
}