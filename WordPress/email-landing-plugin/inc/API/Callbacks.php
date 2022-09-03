<?php
/**
 * @package lb-quickbase-plugin
 *
 */

namespace Inc\API;

use Inc\Base\BaseController;

class Callbacks extends BaseController
{

    public function tableSanitize($input) 
    {
        
        $output = get_option( 'email_landing_options' );
        
        // Handle removing a single environment
        if (isset($_POST['remove']))
        {
            $remove = filter_input( INPUT_POST, 'remove', FILTER_SANITIZE_STRING, array( 'default' => false ) ); 
            unset($output[$remove]);

            return $output;
        }

        // Handle adding the first environment 
        if ( count($output) == 0 )
        {
            $output[$input['env_name']] = $input;

            return $output;
        }

        // Handle adding additional environments
        foreach ($output as $key => $value)
        {
            // Handle edit case when environment is empty
            if (!isset($input['env_name'])) {
                $input = array_merge(array('env_name' => $_POST['env_name']), $input);
            }

            if( $input['env_name'] === $key )
            {
                $output[$key] = $input;
            } else {
                $output[$input['env_name']] = $input;
            }
        }

        // TODO: Figure out how to check if is_active = true then change all other environments to is_active = false

        // if( isset($input['is_active']) )
        // {
        //     $this->resetActiveEnvironment($input['env_name']);
        // }

        return $output;
    }

    public function resetActiveEnvironment( $new_env )
    {
        $output = get_option( 'email_landing_options' );

        foreach ($output as $key => $value)
        {
            if( $key !== $new_env )
            {
                if (isset($output[$key]['is_active'])) 
                {
                    unset($output[$key]['is_active']);
                }
            }
        }

        var_dump($output);
        die;

        update_option( 'email_landing_options', $output );
    }

    public function settingsPage()
    {
        return require_once("$this->plugin_path/templates/admin.php");
    }

    public function adminSectionManager($input)
    {
        
    }

    public function prospectSectionManager($input)
    {
        
    }

    public function campaignSectionManager($input)
    {
        
    }

    public function textField( $args )
    {
        $name = $args['label_for'];
		$option_name = $args['option_name'];
        $classes = isset($args['class']) ? $args['class'] : '';
        $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
        $value = '';
        $status = '';

        if ( isset($_POST["edit_env"]) ) 
        {
		    $input = get_option( $option_name );
            $value = $input[$_POST["edit_env"]][$name];

            if ($name == 'env_name') {
                $status = 'disabled=1';
            }
        }

        echo '<input type="text" class="regular-text ' . $classes . '" name="' . $option_name . '[' . $name . ']' . '" id="' . $name . '" value="' . $value . '" placeholder="' . $placeholder . '" ' . $status . ' required>';
    }

    public function checkboxField( $args)
    {
        $name = $args['label_for'];
        $classes = $args['class'];
        $option_name = $args['option_name'];
        $value = '';

        if ( isset($_POST["edit_env"]) ) 
        {
		    $input = get_option( $option_name );
            $value = (isset($input[$_POST["edit_env"]][$name]) && $input[$_POST["edit_env"]][$name] ? 'checked=1': '');
        }

        echo '<div class="' . $classes . '"><input type="checkbox" name="' . $option_name . '[' . $name . ']' . '" id="' . $name . '" value="1" ' . $value . '"><label for="' . $name .'"><div></div></label></div>';
    }
}